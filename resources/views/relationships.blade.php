<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Eloquent Relationships Demo</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; }
        .section { margin-bottom: 30px; padding: 20px; border: 1px solid #ddd; border-radius: 5px; }
        .book { margin: 10px 0; padding: 10px; background: #f9f9f9; border-radius: 3px; }
        .author { margin: 10px 0; padding: 10px; background: #e9f7ef; border-radius: 3px; }
        .genre { margin: 10px 0; padding: 10px; background: #fff3cd; border-radius: 3px; }
        .rating { color: #28a745; font-weight: bold; }
        .count { color: #007bff; font-weight: bold; }
    </style>
</head>
<body>
    <h1>Eloquent Relationships Demonstration</h1>
    
    <div class="section">
        <h2>Books with Average Ratings</h2>
        @foreach($booksWithRating as $book)
            <div class="book">
                <strong>{{ $book->title }}</strong> by {{ $book->author->name }}
                @if($book->reviews_avg_rating)
                    <span class="rating">(Avg Rating: {{ number_format($book->reviews_avg_rating, 1) }})</span>
                @else
                    <span>(No reviews yet)</span>
                @endif
            </div>
        @endforeach
    </div>

    <div class="section">
        <h2>Authors with Book Count</h2>
        @foreach($authorsWithBookCount as $author)
            <div class="author">
                <strong>{{ $author->name }}</strong>
                <span class="count">({{ $author->books_count }} books)</span>
            </div>
        @endforeach
    </div>

    <div class="section">
        <h2>Genres with Book Count</h2>
        @foreach($genresWithBookCount as $genre)
            <div class="genre">
                <strong>{{ $genre->name }}</strong>
                <span class="count">({{ $genre->books_count }} books)</span>
            </div>
        @endforeach
    </div>

    <div class="section">
        <h2>Top Rated Books</h2>
        @foreach($topRatedBooks as $book)
            <div class="book">
                <strong>{{ $book->title }}</strong> by {{ $book->author->name }}
                <span class="rating">(Rating: {{ number_format($book->reviews_avg_rating, 1) }})</span>
            </div>
        @endforeach
    </div>

    <div class="section">
        <h2>Navigation</h2>
        <p><a href="{{ route('books.index') }}">View All Books</a></p>
        <p><a href="{{ route('authors.index') }}">View All Authors</a></p>
        <p><a href="{{ route('genres.index') }}">View All Genres</a></p>
    </div>
</body>
</html> 