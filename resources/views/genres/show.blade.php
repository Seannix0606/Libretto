<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $genre->name }} - Genre Details</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; }
        .container { max-width: 800px; margin: 0 auto; }
        .genre-details { background: #f8f9fa; padding: 20px; border-radius: 8px; margin: 20px 0; }
        .genre-name { font-size: 2em; font-weight: bold; color: #333; margin-bottom: 15px; }
        .section { margin: 20px 0; }
        .section-title { font-size: 1.3em; font-weight: bold; color: #333; margin-bottom: 10px; }
        .book-item { background: white; padding: 15px; margin: 10px 0; border-radius: 5px; border-left: 4px solid #007bff; }
        .book-title { font-weight: bold; color: #333; }
        .book-author { color: #666; font-size: 0.9em; }
        .btn { padding: 10px 20px; border: none; border-radius: 4px; cursor: pointer; text-decoration: none; display: inline-block; margin-right: 10px; }
        .btn-primary { background-color: #007bff; color: white; }
        .btn-warning { background-color: #ffc107; color: #212529; }
        .btn-danger { background-color: #dc3545; color: white; }
        .btn-secondary { background-color: #6c757d; color: white; }
        .nav { margin-bottom: 20px; }
        .nav a { margin-right: 15px; }
        .actions { margin-top: 20px; }
    </style>
</head>
<body>
    <div class="container">
        <div class="nav">
            <a href="{{ route('genres.index') }}">← Back to Genres</a>
        </div>

        <div class="genre-details">
            <div class="genre-name">{{ $genre->name }}</div>

            <div class="section">
                <div class="section-title">Books ({{ $genre->books->count() }})</div>
                @if($genre->books->count() > 0)
                    @foreach($genre->books as $book)
                        <div class="book-item">
                            <div class="book-title">{{ $book->title }}</div>
                            <div class="book-author">by {{ $book->author->name }}</div>
                        </div>
                    @endforeach
                @else
                    <p>No books in this genre yet.</p>
                @endif
            </div>

            <div class="actions">
                <a href="{{ route('genres.edit', $genre) }}" class="btn btn-warning">Edit Genre</a>
                <form action="{{ route('genres.destroy', $genre) }}" method="POST" style="display: inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this genre?')">Delete Genre</button>
                </form>
                <a href="{{ route('genres.index') }}" class="btn btn-secondary">Back to List</a>
            </div>
        </div>
    </div>
</body>
</html> 