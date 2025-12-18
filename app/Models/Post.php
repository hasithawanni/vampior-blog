<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory; // <--- This was missing
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'category_id',
        'title',
        'slug',
        'content',
        'image',
        'status',
        'published_at',
        'is_featured'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    // A Post has many Comments
    public function comments()
    {
        return $this->hasMany(Comment::class)->latest(); // Show newest comments first
    }
}
