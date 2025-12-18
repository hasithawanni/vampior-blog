<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Like extends Model
{
    protected $fillable = ['user_id', 'post_id']; // Allow these to be saved

    public function post()
    {
        return $this->belongsTo(Post::class);
    }
}
