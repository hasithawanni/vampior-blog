<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function index()
    {
        // Check if Admin
        if (!auth()->user()->is_admin) {
            abort(403);
        }

        $posts = Post::with(['user', 'category'])->latest()->get();
        $users = User::all();

        return view('admin.index', compact('posts', 'users'));
    }

    /**
     * Requirement: Ability to change user roles
     */
    public function updateRole(User $user)
    {
        // Prevent admin from de-admining themselves (optional safety)
        if (auth()->id() === $user->id) {
            return back()->with('error', 'You cannot change your own role.');
        }

        $user->update([
            'is_admin' => !$user->is_admin
        ]);

        return back()->with('success', 'User role updated successfully!');
    }

    /**
     * Requirement: Blog post moderation (approve, reject)
     */
    public function updateStatus(Post $post, $status)
    {
        // Validate that the status is one of your allowed migration values
        $allowedStatuses = ['published', 'draft', 'rejected'];

        if (in_array($status, $allowedStatuses)) {
            $post->update(['status' => $status]);
            return back()->with('success', "Post has been {$status}.");
        }

        return back()->with('error', 'Invalid status update.');
    }
}
