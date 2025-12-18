<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;

class SaveController extends Controller
{
    public function toggle(Post $post)
    {
        $save = $post->saves()->where('user_id', auth()->id())->first();

        if ($save) {
            $save->delete();
        } else {
            $post->saves()->create(['user_id' => auth()->id()]);
        }

        return back();
    }
}
