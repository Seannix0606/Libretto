<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>All Genres</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; background: #f8f9fa; }
        .container { max-width: 1200px; margin: 0 auto; }
        h1 { margin-bottom: 30px; }
        .section { background: white; border-radius: 8px; box-shadow: 0 2px 8px #eee; margin-bottom: 30px; padding: 20px; }
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
            <h1>All Genres</h1>
            <div>
                <a href="{{ route('dashboard') }}" class="btn btn-secondary">← Back to Dashboard</a>
                <a href="{{ route('genres.create') }}" class="btn btn-success">Add Genre</a>
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
                        <th>Name</th>
                        <th>Books</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                @foreach($genres as $genre)
                    <tr>
                        <td>{{ $genre->name }}</td>
                        <td>{{ $genre->books_count }}</td>
                        <td>
                            <a href="{{ route('genres.show', $genre) }}" class="btn btn-primary">View</a>
                            <a href="{{ route('genres.edit', $genre) }}" class="btn btn-warning">Edit</a>
                            <form action="{{ route('genres.destroy', $genre) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger" onclick="return confirm('Delete this genre?')">Delete</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
            {{ $genres->links() }}
        </div>
    </div>
</body>
</html> 