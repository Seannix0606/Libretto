<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $author->name }} - Author Details</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; }
        .container { max-width: 800px; margin: 0 auto; }
        .author-details { background: #f8f9fa; padding: 20px; border-radius: 8px; margin: 20px 0; }
        .author-name { font-size: 2em; font-weight: bold; color: #333; margin-bottom: 15px; }
        .section { margin: 20px 0; }
        .section-title { font-size: 1.3em; font-weight: bold; color: #333; margin-bottom: 10px; }
        .book-item { background: white; padding: 15px; margin: 10px 0; border-radius: 5px; border-left: 4px solid #007bff; }
        .book-title { font-weight: bold; color: #333; }
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
            <a href="{{ route('authors.index') }}">← Back to Authors</a>
        </div>

        <div class="author-details">
            <div class="author-name">{{ $author->name }}</div>

            <div class="section">
                <div class="section-title">Books ({{ $author->books->count() }})</div>
                @if($author->books->count() > 0)
                    @foreach($author->books as $book)
                        <div class="book-item">
                            <div class="book-title">{{ $book->title }}</div>
                        </div>
                    @endforeach
                @else
                    <p>No books by this author yet.</p>
                @endif
            </div>

            <div class="actions">
                <a href="{{ route('authors.edit', $author) }}" class="btn btn-warning">Edit Author</a>
                <form action="{{ route('authors.destroy', $author) }}" method="POST" style="display: inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this author?')">Delete Author</button>
                </form>
                <a href="{{ route('authors.index') }}" class="btn btn-secondary">Back to List</a>
            </div>
        </div>
    </div>
</body>
</html> 