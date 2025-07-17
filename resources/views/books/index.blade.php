<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>All Books</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; background: #f8f9fa; }
        .container { max-width: 1200px; margin: 0 auto; }
        h1 { margin-bottom: 30px; }
        .section { background: white; border-radius: 8px; box-shadow: 0 2px 8px #eee; margin-bottom: 30px; padding: 20px; }
        .section-title { font-size: 1.3em; font-weight: bold; color: #333; margin-bottom: 15px; }
        .btn { padding: 6px 14px; border: none; border-radius: 4px; cursor: pointer; text-decoration: none; display: inline-block; font-size: 0.95em; margin-right: 6px; }
        .btn-primary { background-color: #007bff; color: white; }
        .btn-success { background-color: #28a745; color: white; }
        .btn-warning { background-color: #ffc107; color: #212529; }
        .btn-danger { background-color: #dc3545; color: white; }
        .btn-secondary { background-color: #6c757d; color: white; }
        .header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px; }
        .success-message { background: #d4edda; color: #155724; padding: 10px; border-radius: 4px; margin-bottom: 20px; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>All Books</h1>
            <div>
                <a href="{{ route('dashboard') }}" class="btn btn-secondary">← Back to Dashboard</a>
                <a href="{{ route('books.create') }}" class="btn btn-success">Add Book</a>
            </div>
        </div>
        @if(session('success'))
            <div class="success-message">
                {{ session('success') }}
            </div>
        @endif
        <div class="section">
            <table class="table">
                <thead>
                    <tr>
                        <th>Title</th>
                        <th>Author</th>
                        <th>Genres</th>
                        <th>Rating</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                @foreach($books as $book)
                    <tr>
                        <td>{{ $book->title }}</td>
                        <td>{{ $book->author->name ?? '-' }}</td>
                        <td>
                            @foreach($book->genres as $genre)
                                <span class="badge bg-primary">{{ $genre->name }}</span>
                            @endforeach
                        </td>
                        <td>
                            @if($book->reviews->count() > 0)
                                {{ number_format($book->reviews->avg('rating'), 1) }}/5 ⭐
                                <small>({{ $book->reviews->count() }} reviews)</small>
                            @else
                                <span style="color: #666;">No reviews</span>
                            @endif
                        </td>
                        <td>
                            <a href="{{ route('books.show', $book) }}" class="btn btn-primary">View</a>
                            <a href="{{ route('reviews.create', $book) }}" class="btn btn-success">Add Review</a>
                            <a href="{{ route('books.edit', $book) }}" class="btn btn-warning">Edit</a>
                            <form action="{{ route('books.destroy', $book) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger" onclick="return confirm('Delete this book?')">Delete</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
            {{ $books->links() }}
        </div>
    </div>
</body>
</html> 