<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Genre;
use Illuminate\Http\Request;

class GenreController extends Controller
{
    /**
     * API - Get all genres with pagination
     */
    public function index(Request $request)
    {
        $perPage = $request->get('per_page', 10);
        $genres = Genre::withCount('books')
            ->orderBy('created_at', 'desc')
            ->paginate($perPage);

        return response()->json([
            'success' => true,
            'data' => $genres,
            'message' => 'Genres retrieved successfully'
        ]);
    }

    /**
     * API - Store a new genre
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $genre = Genre::create($request->all());

        return response()->json([
            'success' => true,
            'data' => $genre,
            'message' => 'Genre created successfully'
        ], 201);
    }

    /**
     * API - Get a specific genre
     */
    public function show(Genre $genre)
    {
        $genre->load('books');

        return response()->json([
            'success' => true,
            'data' => $genre,
            'message' => 'Genre retrieved successfully'
        ]);
    }

    /**
     * API - Update a genre
     */
    public function update(Request $request, Genre $genre)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $genre->update($request->all());

        return response()->json([
            'success' => true,
            'data' => $genre,
            'message' => 'Genre updated successfully'
        ]);
    }

    /**
     * API - Delete a genre
     */
    public function destroy(Genre $genre)
    {
        $genre->delete();

        return response()->json([
            'success' => true,
            'message' => 'Genre deleted successfully'
        ]);
    }
} 