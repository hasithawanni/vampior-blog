<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Mail\NewCommentNotification;
use Illuminate\Support\Facades\Mail;

class CommentController extends Controller
{
    public function store(Request $request, Post $post)
    {
        $request->validate(['content' => 'required|min:5']);

        $comment = $post->comments()->create([
            'content' => $request->content,
            'user_id' => auth()->id(),
        ]);

        // 🚀 TRIGGER: This sends the email to the author of the post
        if ($post->user && $post->user->email) {
            \Illuminate\Support\Facades\Mail::to($post->user->email)
                ->send(new \App\Mail\NewCommentNotification($post, $comment));
        }

        return back()->with('success', 'Comment posted!');
    }
}
