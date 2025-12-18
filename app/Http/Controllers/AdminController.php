<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Post;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function index()
    {
        // Check if Admin
        if (!auth()->user()->is_admin) {
            abort(403);
        }

        // Fetch posts. 
        // Note: We use ::with('user'), NOT ::user()
        $posts = Post::query()->with('user')->latest()->get();
        return view('admin.index', compact('posts'));
    }
}
