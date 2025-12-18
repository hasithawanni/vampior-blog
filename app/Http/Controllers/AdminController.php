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
        // Professional check using Spatie HasRoles trait
        if (!auth()->user()->hasRole('admin')) {
            abort(403);
        }

        $posts = Post::with(['user', 'category'])->latest()->get();
        $users = User::all();

        return view('admin.index', compact('posts', 'users'));
    }

    /**
     * Requirement: Ability to change user roles (Admin, Editor, Reader)
     */
    public function updateRole(Request $request, User $user)
    {
        // Validate the incoming role from the dropdown
        $request->validate([
            'role' => 'required|in:admin,editor,reader'
        ]);

        // Prevent admin from changing their own role
        if (auth()->id() === $user->id) {
            return back()->with('error', 'You cannot change your own role.');
        }

        // Use Spatie's syncRoles to remove old roles and assign the new one
        $user->syncRoles([$request->role]);

        return back()->with('success', "User role updated to {$request->role} successfully!");
    }

    /**
     * Requirement: Blog post moderation (approve, reject, delete)
     */
    public function updateStatus(Post $post, $status)
    {
        // Allowed statuses based on project requirements
        $allowedStatuses = ['published', 'draft', 'rejected'];

        if (in_array($status, $allowedStatuses)) {
            $post->update(['status' => $status]);
            return back()->with('success', "Post has been {$status}.");
        }

        return back()->with('error', 'Invalid status update.');
    }
}
