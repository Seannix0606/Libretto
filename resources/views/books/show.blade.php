<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $book->title }} - Book Details</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; }
        .container { max-width: 800px; margin: 0 auto; }
        .book-details { background: #f8f9fa; padding: 20px; border-radius: 8px; margin: 20px 0; }
        .book-title { font-size: 2em; font-weight: bold; color: #333; margin-bottom: 10px; }
        .book-author { font-size: 1.2em; color: #666; margin-bottom: 15px; }
        .section { margin: 20px 0; }
        .section-title { font-size: 1.3em; font-weight: bold; color: #333; margin-bottom: 10px; }
        .genre-tag { display: inline-block; background: #007bff; color: white; padding: 4px 12px; margin: 4px; border-radius: 20px; font-size: 0.9em; }
        .review { background: white; padding: 15px; margin: 10px 0; border-radius: 5px; border-left: 4px solid #007bff; }
        .rating { color: #28a745; font-weight: bold; }
        .btn { padding: 10px 20px; border: none; border-radius: 4px; cursor: pointer; text-decoration: none; display: inline-block; margin-right: 10px; }
        .btn-primary { background-color: #007bff; color: white; }
        .btn-warning { background-color: #ffc107; color: #212529; }
        .btn-danger { background-color: #dc3545; color: white; }
        .btn-secondary { background-color: #6c757d; color: white; }
        .nav { margin-bottom: 20px; }
        .nav a { margin-right: 15px; }
        .actions { margin-top: 20px; }
        .success-message { background: #d4edda; color: #155724; padding: 10px; border-radius: 4px; margin-bottom: 20px; }
    </style>
</head>
<body>
    <div class="container">
        <div class="nav">
            <a href="{{ route('books.index') }}">← Back to Books</a>
        </div>
        
        @if(session('success'))
            <div class="success-message">
                {{ session('success') }}
            </div>
        @endif

        <div class="book-details">
            <div class="book-title">{{ $book->title }}</div>
            <div class="book-author">by {{ $book->author->name }}</div>

            <div class="section">
                <div class="section-title">Genres</div>
                @if($book->genres->count() > 0)
                    @foreach($book->genres as $genre)
                        <span class="genre-tag">{{ $genre->name }}</span>
                    @endforeach
                @else
                    <p>No genres assigned</p>
                @endif
            </div>

            <div class="section">
                <div class="section-title">Reviews ({{ $book->reviews->count() }})</div>
                <div style="margin-bottom: 15px;">
                    <a href="{{ route('reviews.create', $book) }}" class="btn btn-primary">Add Review</a>
                </div>
                @if($book->reviews->count() > 0)
                    @foreach($book->reviews as $review)
                        <div class="review">
                            <div class="rating">Rating: {{ $review->rating }}/5 ⭐</div>
                            <div>{{ $review->content }}</div>
                            <small style="color: #666;">{{ $review->created_at->diffForHumans() }}</small>
                        </div>
                    @endforeach
                @else
                    <p>No reviews yet. Be the first to add a review!</p>
                @endif
            </div>

            <div class="actions">
                <a href="{{ route('books.edit', $book) }}" class="btn btn-warning">Edit Book</a>
                <form action="{{ route('books.destroy', $book) }}" method="POST" style="display: inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this book?')">Delete Book</button>
                </form>
                <a href="{{ route('books.index') }}" class="btn btn-secondary">Back to List</a>
            </div>
        </div>
    </div>
</body>
</html> 