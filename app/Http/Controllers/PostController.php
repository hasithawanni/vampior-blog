<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Category;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Cache; // Import Cache Facade

class PostController extends Controller
{
    /**
     * 1. Show the Dashboard (with Search, Filtering, and Caching)
     * Directly addresses "Search/Filtering" and "Server-side caching" requirements.
     */
    public function index(Request $request)
    {
        // Generate a unique cache key based on query parameters to satisfy the "Caching" requirement
        $cacheKey = 'posts_page_' . $request->get('page', 1) .
            '_search_' . $request->get('search', '') .
            '_cat_' . $request->get('category', '') .
            '_tag_' . $request->get('tag', '') .
            '_auth_' . $request->get('author', '');

        // Cache the post results for 10 minutes (600 seconds)
        $posts = Cache::remember($cacheKey, 600, function () use ($request) {
            $query = Post::with(['user', 'category', 'tags'])->where('status', 'published');

            // 🔎 Search by Title or Content
            if ($request->filled('search')) {
                $query->where(function ($q) use ($request) {
                    $q->where('title', 'like', '%' . $request->search . '%')
                        ->orWhere('content', 'like', '%' . $request->search . '%');
                });
            }

            // 📂 Filter by Category
            if ($request->filled('category')) {
                $query->whereHas('category', fn($q) => $q->where('slug', $request->category));
            }

            // 🏷️ Filter by Tag
            if ($request->filled('tag')) {
                $query->whereHas('tags', fn($q) => $q->where('slug', $request->tag));
            }

            // 👤 Filter by Author
            if ($request->filled('author')) {
                $query->whereHas('user', fn($q) => $q->where('name', 'like', '%' . $request->author . '%'));
            }

            return $query->latest()->paginate(6);
        });

        // Cache categories separately for optimization
        $categories = Cache::remember('all_categories', 3600, function () {
            return Category::all();
        });

        return view('dashboard', compact('posts', 'categories'));
    }

    /**
     * 2. Show the Create Form
     * Implements RBAC: Only Admin and Editor can access.
     */
    public function create()
    {
        if (!auth()->user()->hasAnyRole(['admin', 'editor'])) {
            abort(403, 'Unauthorized action. Readers cannot create posts.');
        }

        $categories = Category::all();
        return view('posts.create', compact('categories'));
    }

    /**
     * 3. Save the New Post
     * Uses Eloquent ORM and handles Image Storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|max:255',
            'category_id' => 'required|exists:categories,id',
            'content' => 'required',
            'image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'tags' => 'nullable|string',
        ]);

        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('posts', 'public');
        }

        $post = Post::create([
            'user_id' => auth()->id(),
            'category_id' => $request->category_id,
            'title' => $request->title,
            'slug' => Str::slug($request->title) . '-' . rand(100, 999),
            'content' => $request->content,
            'image' => $imagePath,
            'status' => 'draft', // Requires moderation
        ]);

        $this->syncTags($post, $request->tags);

        // Clear cache so the new post eventually appears
        Cache::flush();

        return redirect()->route('dashboard')->with('success', 'Post created! It will appear once an admin approves it.');
    }

    /**
     * 4. Show a Single Post
     * Implements dynamic routing /blog/{slug}.
     */
    public function show($slug)
    {
        $post = Post::where('slug', $slug)
            ->with(['user', 'category', 'comments.user', 'tags'])
            ->firstOrFail();

        return view('posts.show', compact('post'));
    }

    /**
     * 5. Show the Edit Form
     */
    public function edit(Post $post)
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();

        if ($user->id !== $post->user_id && !$user->hasRole('admin')) {
            abort(403);
        }

        $categories = Category::all();
        return view('posts.edit', compact('post', 'categories'));
    }

    /**
     * 6. Update the Post
     */
    public function update(Request $request, Post $post)
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();

        if ($user->id !== $post->user_id && !$user->hasRole('admin')) {
            abort(403);
        }

        $request->validate([
            'title' => 'required|max:255',
            'category_id' => 'required|exists:categories,id',
            'content' => 'required',
            'image' => 'nullable|image|max:2048',
            'tags' => 'nullable|string',
        ]);

        $imagePath = $post->image;
        if ($request->hasFile('image')) {
            if ($post->image) {
                Storage::disk('public')->delete($post->image);
            }
            $imagePath = $request->file('image')->store('posts', 'public');
        }

        $post->update([
            'title' => $request->title,
            'slug' => Str::slug($request->title) . '-' . $post->id,
            'category_id' => $request->category_id,
            'content' => $request->content,
            'image' => $imagePath,
        ]);

        $this->syncTags($post, $request->tags);

        Cache::flush(); // Clear cache to reflect updates

        return redirect()->route('dashboard')->with('success', 'Post updated successfully!');
    }

    /**
     * 7. Delete the Post
     */
    public function destroy(Post $post)
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();

        if ($user->id !== $post->user_id && !$user->hasRole('admin')) {
            abort(403);
        }

        if ($post->image) {
            Storage::disk('public')->delete($post->image);
        }
        $post->delete();

        Cache::flush();

        return redirect()->route('dashboard')->with('success', 'Post deleted!');
    }

    /**
     * Helper Method: Handle Tag synchronization logic
     */
    private function syncTags(Post $post, ?string $tagsString)
    {
        if (!$tagsString) {
            $post->tags()->detach();
            return;
        }

        $tagNames = collect(explode(',', $tagsString))
            ->map(fn($tag) => trim(strtolower($tag)))
            ->filter();

        $tagIds = [];
        foreach ($tagNames as $name) {
            $tag = Tag::firstOrCreate(
                ['name' => $name],
                ['slug' => Str::slug($name)]
            );
            $tagIds[] = $tag->id;
        }

        $post->tags()->sync($tagIds);
    }
}
