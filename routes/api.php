<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\AuthorController;
use App\Http\Controllers\GenreController;

// Public API routes for authentication
Route::post('/login', [AuthController::class, 'apiLogin']);
Route::post('/register', [AuthController::class, 'apiRegister']);

// Protected API routes (require Sanctum authentication)
Route::middleware('auth:sanctum')->group(function () {
    Route::get('/user', function (Request $request) {
        return $request->user();
    });
    
    Route::post('/logout', [AuthController::class, 'apiLogout']);
    Route::post('/refresh-token', [AuthController::class, 'refreshToken']);
    
    // API CRUD routes for books
    Route::get('/books', [BookController::class, 'apiIndex']);
    Route::post('/books', [BookController::class, 'apiStore']);
    Route::get('/books/{book}', [BookController::class, 'apiShow']);
    Route::put('/books/{book}', [BookController::class, 'apiUpdate']);
    Route::delete('/books/{book}', [BookController::class, 'apiDestroy']);
    Route::get('/books/{book}/relationships', [BookController::class, 'apiRelationships']);
    
    // API CRUD routes for authors
    Route::get('/authors', [AuthorController::class, 'apiIndex']);
    Route::post('/authors', [AuthorController::class, 'apiStore']);
    Route::get('/authors/{author}', [AuthorController::class, 'apiShow']);
    Route::put('/authors/{author}', [AuthorController::class, 'apiUpdate']);
    Route::delete('/authors/{author}', [AuthorController::class, 'apiDestroy']);
    
    // API CRUD routes for genres
    Route::get('/genres', [GenreController::class, 'apiIndex']);
    Route::post('/genres', [GenreController::class, 'apiStore']);
    Route::get('/genres/{genre}', [GenreController::class, 'apiShow']);
    Route::put('/genres/{genre}', [GenreController::class, 'apiUpdate']);
    Route::delete('/genres/{genre}', [GenreController::class, 'apiDestroy']);
    
    // Additional endpoints
    Route::get('/relationships', [BookController::class, 'apiRelationships']);
}); 