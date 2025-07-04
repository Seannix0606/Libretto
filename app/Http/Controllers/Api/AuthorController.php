<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Author;
use Illuminate\Http\Request;

class AuthorController extends Controller
{
    /**
     * API - Get all authors with pagination
     */
    public function index(Request $request)
    {
        $perPage = $request->get('per_page', 10);
        $authors = Author::withCount('books')
            ->orderBy('created_at', 'desc')
            ->paginate($perPage);

        return response()->json([
            'success' => true,
            'data' => $authors,
            'message' => 'Authors retrieved successfully'
        ]);
    }

    /**
     * API - Store a new author
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $author = Author::create($request->all());

        return response()->json([
            'success' => true,
            'data' => $author,
            'message' => 'Author created successfully'
        ], 201);
    }

    /**
     * API - Get a specific author
     */
    public function show(Author $author)
    {
        $author->load('books');

        return response()->json([
            'success' => true,
            'data' => $author,
            'message' => 'Author retrieved successfully'
        ]);
    }

    /**
     * API - Update an author
     */
    public function update(Request $request, Author $author)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $author->update($request->all());

        return response()->json([
            'success' => true,
            'data' => $author,
            'message' => 'Author updated successfully'
        ]);
    }

    /**
     * API - Delete an author
     */
    public function destroy(Author $author)
    {
        $author->delete();

        return response()->json([
            'success' => true,
            'message' => 'Author deleted successfully'
        ]);
    }
} 