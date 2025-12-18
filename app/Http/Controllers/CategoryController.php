<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function show(\App\Models\Category $category)
    {
        // Fetch posts belonging to this category that are ONLY 'published'
        $posts = $category->posts()
            ->where('status', 'published') // 👈 Add this moderation filter
            ->with(['user', 'category'])
            ->latest()
            ->paginate(6);

        return view('categories.show', compact('category', 'posts'));
    }
}
