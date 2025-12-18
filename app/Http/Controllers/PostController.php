<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Gate;
use App\Models\Post;
use App\Models\Category;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class PostController extends Controller
{
    // 1. Show the Dashboard (with Search & Pagination)
    public function index(Request $request)
    {
        $query = Post::with(['user', 'category', 'tags'])
            ->where('status', 'published')
            ->latest();

        if ($request->has('search')) {
            $searchTerm = $request->search;
            $query->where(function ($q) use ($searchTerm) {
                $q->where('title', 'like', '%' . $searchTerm . '%')
                    ->orWhere('content', 'like', '%' . $searchTerm . '%');
            });
        }

        $posts = $query->paginate(6);

        return view('dashboard', compact('posts'));
    }

    // 2. Show the Create Form
    public function create()
    {
        if (!auth()->user()->hasAnyRole(['admin', 'editor'])) {
            abort(403, 'Unauthorized action. Readers cannot create posts.');
        }

        $categories = Category::all();
        return view('posts.create', compact('categories'));
    }

    // 3. Save the New Post
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
            'status' => 'draft',
        ]);

        $this->syncTags($post, $request->tags);

        return redirect()->route('dashboard')->with('success', 'Post created! It will appear once an admin approves it.');
    }

    // 4. Show a Single Post
    public function show($slug)
    {
        // UPDATED: Added 'tags' to eager loading
        $post = Post::where('slug', $slug)
            ->with(['user', 'category', 'comments.user', 'tags'])
            ->firstOrFail();

        return view('posts.show', compact('post'));
    }

    // 5. Show the Edit Form
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

    // 6. Update the Post
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
            'tags' => 'nullable|string', // Added tags to validation
        ]);

        $imagePath = $post->image;
        if ($request->hasFile('image')) {
            // Delete old image if new one is uploaded
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

        // UPDATED: Now syncing tags during update
        $this->syncTags($post, $request->tags);

        return redirect()->route('dashboard')->with('success', 'Post updated successfully!');
    }

    // 7. Delete the Post
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
