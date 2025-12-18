<?php

use App\Http\Controllers\SocialAuthController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\LikeController; // New Controller
use App\Http\Controllers\SaveController; // New Controller
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LibraryController;

// --- 1. PUBLIC ROUTES (Anyone can visit) ---
Route::get('/', [PostController::class, 'index'])->name('dashboard');
Route::get('/dashboard', [PostController::class, 'index']);
Route::get('/blog/{slug}', [PostController::class, 'show'])->name('posts.show');
Route::get('/categories/{category:slug}', [CategoryController::class, 'show'])->name('categories.show');
Route::get('/tags/{tag:slug}', [PostController::class, 'tagIndex'])->name('tags.show'); // Optional but professional

// --- 2. SOCIAL AUTH ROUTES ---
Route::get('/auth/{provider}/redirect', [SocialAuthController::class, 'redirect'])->name('social.redirect');
Route::get('/auth/{provider}/callback', [SocialAuthController::class, 'callback'])->name('social.callback');

// --- 3. AUTHENTICATED USER ROUTES (Must be logged in) ---
Route::middleware('auth')->group(function () {

    // A. GENERAL AUTH ROUTES (Available to Reader, Editor, and Admin)
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/my-library', [LibraryController::class, 'index'])->name('library.index');

    // Commenting (Reader Duty)
    Route::post('/posts/{post}/comments', [CommentController::class, 'store'])->name('comments.store');

    // NEW: Likes & Saves (Reader Duty)
    Route::post('/posts/{post}/like', [LikeController::class, 'toggle'])->name('posts.like');
    Route::post('/posts/{post}/save', [SaveController::class, 'toggle'])->name('posts.save');

    // B. AUTHOR-ONLY ROUTES (Restricted to Admin and Editor)
    Route::middleware(['role:admin|editor'])->group(function () {
        Route::get('/posts/create', [PostController::class, 'create'])->name('posts.create');
        Route::post('/posts', [PostController::class, 'store'])->name('posts.store');
        Route::get('/posts/{post}/edit', [PostController::class, 'edit'])->name('posts.edit');
        Route::put('/posts/{post}', [PostController::class, 'update'])->name('posts.update');
        Route::delete('/posts/{post}', [PostController::class, 'destroy'])->name('posts.destroy');
    });

    // C. ADMIN ONLY ROUTES (Restricted strictly to Admin)
    Route::middleware(['role:admin'])->group(function () {
        Route::get('/admin', [AdminController::class, 'index'])->name('admin.index');
        Route::patch('/admin/users/{user}/role', [AdminController::class, 'updateRole'])->name('admin.users.role');
        Route::patch('/admin/posts/{post}/status/{status}', [AdminController::class, 'updateStatus'])->name('admin.posts.status');
    });
});

require __DIR__ . '/auth.php';
