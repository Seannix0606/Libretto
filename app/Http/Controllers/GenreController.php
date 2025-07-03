<?php

namespace App\Http\Controllers;

use App\Models\Genre;
use Illuminate\Http\Request;

class GenreController extends Controller
{
    public function index()
    {
        $genres = Genre::withCount('books')->orderBy('created_at', 'desc')->paginate(5);
        return view('genres.index', compact('genres'));
    }

    public function create()
    {
        return view('genres.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        Genre::create($request->all());

        return redirect()->route('genres.index')
            ->with('success', 'Genre created successfully.');
    }

    public function show(Genre $genre)
    {
        $genre->load('books');
        return view('genres.show', compact('genre'));
    }

    public function edit(Genre $genre)
    {
        return view('genres.edit', compact('genre'));
    }

    public function update(Request $request, Genre $genre)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $genre->update($request->all());

        return redirect()->route('genres.index')
            ->with('success', 'Genre updated successfully.');
    }

    public function destroy(Genre $genre)
    {
        $genre->delete();

        return redirect()->route('genres.index')
            ->with('success', 'Genre deleted successfully.');
    }

    // API methods for JSON responses

    /**
     * API - Get all genres with pagination
     */
    public function apiIndex(Request $request)
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
    public function apiStore(Request $request)
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
    public function apiShow(Genre $genre)
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
    public function apiUpdate(Request $request, Genre $genre)
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
    public function apiDestroy(Genre $genre)
    {
        $genre->delete();

        return response()->json([
            'success' => true,
            'message' => 'Genre deleted successfully'
        ]);
    }
} 