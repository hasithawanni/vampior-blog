<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;  // <--- Keep this!

class User extends Authenticatable
{
    use HasFactory, Notifiable, HasRoles; // <--- Removed HasApiTokens

    protected $fillable = [
        'name',
        'email',
        'password',
        'github_id',
        'google_id',
        'github_token',
        'google_token',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
}