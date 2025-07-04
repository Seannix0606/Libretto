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


} 