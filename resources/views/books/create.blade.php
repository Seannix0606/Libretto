<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create New Book</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; }
        .container { max-width: 600px; margin: 0 auto; }
        .form-group { margin-bottom: 15px; }
        label { display: block; margin-bottom: 5px; font-weight: bold; }
        input[type="text"], select, textarea { width: 100%; padding: 8px; border: 1px solid #ddd; border-radius: 4px; }
        .checkbox-group { margin-top: 10px; }
        .checkbox-item { margin-bottom: 5px; }
        .btn { padding: 10px 20px; border: none; border-radius: 4px; cursor: pointer; text-decoration: none; display: inline-block; }
        .btn-primary { background-color: #007bff; color: white; }
        .btn-secondary { background-color: #6c757d; color: white; margin-right: 10px; }
        .nav { margin-bottom: 20px; }
        .nav a { margin-right: 15px; }
    </style>
</head>
<body>
    <div class="container">
        <div class="nav">
            <a href="{{ route('books.index') }}">← Back to Books</a>
        </div>

        <h1>Create New Book</h1>

        @if ($errors->any())
            <div style="color: red; margin-bottom: 20px;">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('books.store') }}" method="POST">
            @csrf
            
            <div class="form-group">
                <label for="title">Title:</label>
                <input type="text" id="title" name="title" value="{{ old('title') }}" required>
            </div>

            <div class="form-group">
                <label for="author_id">Author:</label>
                <select id="author_id" name="author_id" required>
                    <option value="">Select an author</option>
                    @foreach($authors as $author)
                        <option value="{{ $author->id }}" {{ old('author_id') == $author->id ? 'selected' : '' }}>
                            {{ $author->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label>Genres:</label>
                <div class="checkbox-group">
                    @foreach($genres as $genre)
                        <div class="checkbox-item">
                            <input type="checkbox" id="genre_{{ $genre->id }}" name="genres[]" value="{{ $genre->id }}" 
                                   {{ in_array($genre->id, old('genres', [])) ? 'checked' : '' }}>
                            <label for="genre_{{ $genre->id }}">{{ $genre->name }}</label>
                        </div>
                    @endforeach
                </div>
            </div>

            <div class="form-group">
                <a href="{{ route('books.index') }}" class="btn btn-secondary">Cancel</a>
                <button type="submit" class="btn btn-primary">Create Book</button>
            </div>
        </form>
    </div>
</body>
</html> 