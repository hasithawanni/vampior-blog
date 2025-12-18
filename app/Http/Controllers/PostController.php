<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Gate;
use App\Models\Post;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;

class PostController extends Controller
{
    // 1. Show the Dashboard (with Search & Pagination)
    public function index(Request $request)
    {
        // Start a query to get posts with their authors and categories
        $query = Post::with(['user', 'category'])->latest();

        // Search Logic: If the user typed something...
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                    ->orWhere('content', 'like', "%{$search}%");
            });
        }

        // Pagination: Get 6 posts per page
        $posts = $query->paginate(6);

        // Return the view
        return view('dashboard', compact('posts'));
    }

    // 1. Show the Create Form
    public function create()
    {
        $categories = Category::all();
        return view('posts.create', compact('categories'));
    }

    // 2. Save the New Post
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|max:255',
            'category_id' => 'required|exists:categories,id',
            'content' => 'required',
            'image' => 'nullable|image|max:2048',
        ]);

        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('posts', 'public');
        }

        Post::create([
            'user_id' => Auth::id(),
            'category_id' => $request->category_id,
            'title' => $request->title,
            'slug' => Str::slug($request->title),
            'content' => $request->content,
            'image' => $imagePath,
            'status' => 'published',
            'published_at' => now(),
        ]);

        return redirect()->route('dashboard')->with('success', 'Post created successfully!');
    }

    // 3. Show a Single Post
    public function show($slug)
    {
        $post = Post::where('slug', $slug)->firstOrFail();
        return view('posts.show', compact('post'));
    }

    // 4. Show the Edit Form
    public function edit(Post $post)
    {
        Gate::authorize('update', $post);

        /** @var \App\Models\User $user */
        $user = Auth::user(); // We tell VS Code: "This is OUR User model"

        if ($user->id !== $post->user_id && !$user->hasRole('admin')) {
            abort(403);
        }

        $categories = Category::all();
        return view('posts.edit', compact('post', 'categories'));
    }

    // 5. Update the Post
    public function update(Request $request, Post $post)
    {
        Gate::authorize('update', $post);

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
        ]);

        $imagePath = $post->image;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('posts', 'public');
        }

        $post->update([
            'title' => $request->title,
            'slug' => Str::slug($request->title),
            'category_id' => $request->category_id,
            'content' => $request->content,
            'image' => $imagePath,
        ]);

        return redirect()->route('dashboard')->with('success', 'Post updated successfully!');
    }

    // 6. Delete the Post
    public function destroy(Post $post)
    {
        Gate::authorize('delete', $post);

        /** @var \App\Models\User $user */
        $user = Auth::user();

        if ($user->id !== $post->user_id && !$user->hasRole('admin')) {
            abort(403);
        }

        $post->delete();

        return redirect()->route('dashboard')->with('success', 'Post deleted!');
    }
}
