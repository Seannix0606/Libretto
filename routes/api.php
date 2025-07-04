<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\BookController;
use App\Http\Controllers\Api\AuthorController;
use App\Http\Controllers\Api\GenreController;

// Public API routes for authentication
Route::post('/login', [AuthController::class, 'login']);
Route::post('/register', [AuthController::class, 'register']);

// Protected API routes (require Sanctum authentication)
Route::middleware('auth:sanctum')->group(function () {
    // User and authentication endpoints
    Route::get('/user', [AuthController::class, 'user']);
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::post('/refresh-token', [AuthController::class, 'refreshToken']);
    
    // API CRUD routes for books
    Route::get('/books', [BookController::class, 'index']);
    Route::post('/books', [BookController::class, 'store']);
    Route::get('/books/{book}', [BookController::class, 'show']);
    Route::put('/books/{book}', [BookController::class, 'update']);
    Route::delete('/books/{book}', [BookController::class, 'destroy']);
    
    // API CRUD routes for authors
    Route::get('/authors', [AuthorController::class, 'index']);
    Route::post('/authors', [AuthorController::class, 'store']);
    Route::get('/authors/{author}', [AuthorController::class, 'show']);
    Route::put('/authors/{author}', [AuthorController::class, 'update']);
    Route::delete('/authors/{author}', [AuthorController::class, 'destroy']);
    
    // API CRUD routes for genres
    Route::get('/genres', [GenreController::class, 'index']);
    Route::post('/genres', [GenreController::class, 'store']);
    Route::get('/genres/{genre}', [GenreController::class, 'show']);
    Route::put('/genres/{genre}', [GenreController::class, 'update']);
    Route::delete('/genres/{genre}', [GenreController::class, 'destroy']);
    
    // Additional endpoints
    Route::get('/relationships', [BookController::class, 'relationships']);
}); 