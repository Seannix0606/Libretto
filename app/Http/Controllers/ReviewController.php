<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Review;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    /**
     * Show the form for creating a new review.
     */
    public function create(Book $book)
    {
        return view('reviews.create', compact('book'));
    }

    /**
     * Store a newly created review in storage.
     */
    public function store(Request $request, Book $book)
    {
        $request->validate([
            'content' => 'required|string|max:1000',
            'rating' => 'required|integer|between:1,5'
        ]);

        Review::create([
            'book_id' => $book->id,
            'content' => $request->content,
            'rating' => $request->rating
        ]);

        return redirect()->route('books.show', $book)
            ->with('success', 'Review added successfully!');
    }

    /**
     * Remove the specified review from storage.
     */
    public function destroy(Review $review)
    {
        $book = $review->book;
        $review->delete();

        return redirect()->route('books.show', $book)
            ->with('success', 'Review deleted successfully!');
    }
} 