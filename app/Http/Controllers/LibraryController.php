<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;

class LibraryController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        // Get posts the user has saved
        $savedPosts = Post::whereHas('saves', function ($q) use ($user) {
            $q->where('user_id', $user->id);
        })->with(['user', 'category', 'tags'])->latest()->get();

        // Get posts the user has liked
        $likedPosts = Post::whereHas('likes', function ($q) use ($user) {
            $q->where('user_id', $user->id);
        })->with(['user', 'category', 'tags'])->latest()->get();

        return view('library.index', compact('savedPosts', 'likedPosts'));
    }
}
