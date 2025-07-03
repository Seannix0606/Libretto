<?php

namespace App\Http\Controllers;

use App\Models\Author;
use App\Models\Book;
use App\Models\Genre;
use Illuminate\Http\Request;

class BookController extends Controller
{
    public function index()
    {
        $books = Book::with(['author', 'genres', 'reviews'])->orderBy('created_at', 'desc')->paginate(5);
        return view('books.index', compact('books'));
    }

    public function create()
    {
        $authors = Author::all();
        $genres = Genre::all();
        return view('books.create', compact('authors', 'genres'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'author_id' => 'required|exists:authors,id',
            'genres' => 'array',
            'genres.*' => 'exists:genres,id',
        ]);

        $book = Book::create([
            'title' => $request->title,
            'author_id' => $request->author_id,
        ]);

        if ($request->has('genres')) {
            $book->genres()->attach($request->genres);
        }

        return redirect()->route('books.index')
            ->with('success', 'Book created successfully.');
    }

    public function show(Book $book)
    {
        $book->load(['author', 'genres', 'reviews']);
        return view('books.show', compact('book'));
    }

    public function edit(Book $book)
    {
        $authors = Author::all();
        $genres = Genre::all();
        $book->load('genres');
        return view('books.edit', compact('book', 'authors', 'genres'));
    }

    public function update(Request $request, Book $book)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'author_id' => 'required|exists:authors,id',
            'genres' => 'array',
            'genres.*' => 'exists:genres,id',
        ]);

        $book->update([
            'title' => $request->title,
            'author_id' => $request->author_id,
        ]);

        if ($request->has('genres')) {
            $book->genres()->sync($request->genres);
        } else {
            $book->genres()->detach();
        }

        return redirect()->route('books.index')
            ->with('success', 'Book updated successfully.');
    }

    public function destroy(Book $book)
    {
        $book->delete();

        return redirect()->route('books.index')
            ->with('success', 'Book deleted successfully.');
    }

    public function authors()
    {
        $authors = Author::with('books')->get();
        return view('authors.index', compact('authors'));
    }

    public function genres()
    {
        $genres = Genre::with('books')->get();
        return view('genres.index', compact('genres'));
    }

    public function relationships()
    {
        $booksWithRating = Book::with('author')->withAvg('reviews', 'rating')->get();
        $authorsWithBookCount = Author::withCount('books')->get();
        $genresWithBookCount = Genre::withCount('books')->get();
        $topRatedBooks = Book::with('author')->withAvg('reviews', 'rating')->orderByDesc('reviews_avg_rating')->limit(5)->get();
        return view('relationships', compact('booksWithRating', 'authorsWithBookCount', 'genresWithBookCount', 'topRatedBooks'));
    }

    // API methods for JSON responses

    /**
     * API - Get all books with pagination
     */
    public function apiIndex(Request $request)
    {
        $perPage = $request->get('per_page', 10);
        $books = Book::with(['author', 'genres', 'reviews'])
            ->orderBy('created_at', 'desc')
            ->paginate($perPage);

        return response()->json([
            'success' => true,
            'data' => $books,
            'message' => 'Books retrieved successfully'
        ]);
    }

    /**
     * API - Store a new book
     */
    public function apiStore(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'author_id' => 'required|exists:authors,id',
            'genres' => 'array',
            'genres.*' => 'exists:genres,id',
        ]);

        $book = Book::create([
            'title' => $request->title,
            'author_id' => $request->author_id,
        ]);

        if ($request->has('genres')) {
            $book->genres()->attach($request->genres);
        }

        $book->load(['author', 'genres']);

        return response()->json([
            'success' => true,
            'data' => $book,
            'message' => 'Book created successfully'
        ], 201);
    }

    /**
     * API - Get a specific book
     */
    public function apiShow(Book $book)
    {
        $book->load(['author', 'genres', 'reviews']);

        return response()->json([
            'success' => true,
            'data' => $book,
            'message' => 'Book retrieved successfully'
        ]);
    }

    /**
     * API - Update a book
     */
    public function apiUpdate(Request $request, Book $book)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'author_id' => 'required|exists:authors,id',
            'genres' => 'array',
            'genres.*' => 'exists:genres,id',
        ]);

        $book->update([
            'title' => $request->title,
            'author_id' => $request->author_id,
        ]);

        if ($request->has('genres')) {
            $book->genres()->sync($request->genres);
        } else {
            $book->genres()->detach();
        }

        $book->load(['author', 'genres']);

        return response()->json([
            'success' => true,
            'data' => $book,
            'message' => 'Book updated successfully'
        ]);
    }

    /**
     * API - Delete a book
     */
    public function apiDestroy(Book $book)
    {
        $book->delete();

        return response()->json([
            'success' => true,
            'message' => 'Book deleted successfully'
        ]);
    }

    /**
     * API - Get book relationships data
     */
    public function apiRelationships()
    {
        $booksWithRating = Book::with('author')->withAvg('reviews', 'rating')->get();
        $authorsWithBookCount = Author::withCount('books')->get();
        $genresWithBookCount = Genre::withCount('books')->get();
        $topRatedBooks = Book::with('author')->withAvg('reviews', 'rating')
            ->orderByDesc('reviews_avg_rating')
            ->limit(5)
            ->get();

        return response()->json([
            'success' => true,
            'data' => [
                'books_with_rating' => $booksWithRating,
                'authors_with_book_count' => $authorsWithBookCount,
                'genres_with_book_count' => $genresWithBookCount,
                'top_rated_books' => $topRatedBooks
            ],
            'message' => 'Relationships data retrieved successfully'
        ]);
    }
} 