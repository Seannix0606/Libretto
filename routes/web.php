<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BookController;
use App\Http\Controllers\AuthorController;
use App\Http\Controllers\GenreController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ReviewController;

// Authentication routes (public)
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Redirect root to dashboard
Route::get('/', function () {
    return redirect('/dashboard');
});

// Protected routes (require authentication)
Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::resource('books', BookController::class);
    Route::resource('authors', AuthorController::class);
    Route::resource('genres', GenreController::class);
    Route::get('/relationships', [BookController::class, 'relationships'])->name('relationships');
    
    // Review routes
    Route::get('/books/{book}/reviews/create', [ReviewController::class, 'create'])->name('reviews.create');
    Route::post('/books/{book}/reviews', [ReviewController::class, 'store'])->name('reviews.store');
    Route::delete('/reviews/{review}', [ReviewController::class, 'destroy'])->name('reviews.destroy');
});
