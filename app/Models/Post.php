<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property int $user_id
 * @property string $title
 * @property \App\Models\User $user
 * @method static \Illuminate\Database\Eloquent\Builder|Post query()
 */
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
        return $this->hasMany(Comment::class)->latest();
    }

    public function tags()
    {
        return $this->belongsToMany(Tag::class);
    }

    /**
     * Relationship: A post has many likes
     */
    public function likes()
    {
        return $this->hasMany(Like::class);
    }

    /**
     * Check if a specific user has liked this post
     */
    public function isLikedBy($user)
    {
        if (!$user) return false;
        return $this->likes()->where('user_id', $user->id)->exists();
    }

    /**
     * Relationship: A post has many saves
     */
    public function saves()
    {
        return $this->hasMany(Save::class);
    }

    /**
     * Check if a specific user has saved this post
     */
    public function isSavedBy($user)
    {
        if (!$user) return false;
        return $this->saves()->where('user_id', $user->id)->exists();
    }
}
