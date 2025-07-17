<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create New Book</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; background: #f8f9fa; }
        .container { max-width: 600px; margin: 0 auto; }
        h1 { margin-bottom: 30px; }
        .section { background: white; border-radius: 8px; box-shadow: 0 2px 8px #eee; margin-bottom: 30px; padding: 20px; }
        .section-title { font-size: 1.3em; font-weight: bold; color: #333; margin-bottom: 15px; }
        .btn { padding: 6px 14px; border: none; border-radius: 4px; cursor: pointer; text-decoration: none; display: inline-block; font-size: 0.95em; margin-right: 6px; transition: all 0.15s ease-in-out; }
        .btn-primary { background-color: #007bff; color: white; }
        .btn-primary:hover { background-color: #0056b3; }
        .btn-success { background-color: #28a745; color: white; }
        .btn-success:hover { background-color: #1e7e34; }
        .btn-warning { background-color: #ffc107; color: #212529; }
        .btn-warning:hover { background-color: #e0a800; }
        .btn-danger { background-color: #dc3545; color: white; }
        .btn-danger:hover { background-color: #c82333; }
        .btn-secondary { background-color: #6c757d; color: white; }
        .btn-secondary:hover { background-color: #5a6268; }
        .header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px; }
        .success-message { background: #d4edda; color: #155724; padding: 10px; border-radius: 4px; margin-bottom: 20px; }
        .nav { margin-bottom: 20px; }
        .nav a { color: #007bff; text-decoration: none; }
        .nav a:hover { text-decoration: underline; }
        .form-group { margin-bottom: 20px; }
        label { display: block; margin-bottom: 5px; font-weight: bold; color: #333; }
        input[type="text"], select { width: 100%; padding: 8px 12px; border: 1px solid #ddd; border-radius: 4px; font-size: 14px; }
        input[type="text"]:focus, select:focus { border-color: #007bff; outline: none; box-shadow: 0 0 0 2px rgba(0, 123, 255, 0.25); }
        .checkbox-group { margin-top: 10px; display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 10px; }
        .checkbox-item { margin-bottom: 8px; }
        .checkbox-item input[type="checkbox"] { margin-right: 8px; }
        .checkbox-item label { display: inline; font-weight: normal; margin: 0; cursor: pointer; }
        .button-group { margin-top: 30px; }
        .error-container { background: #f8d7da; color: #721c24; padding: 15px; border-radius: 4px; margin-bottom: 20px; border: 1px solid #f5c6cb; }
        .error-container ul { margin: 0; padding-left: 20px; }
        .error-container li { margin-bottom: 5px; }
    </style>
</head>
<body>
    <div class="container">
        <div class="nav">
            <a href="{{ route('books.index') }}">← Back to Books</a>
        </div>

        <h1>Create New Book</h1>

        @if ($errors->any())
            <div class="error-container">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="section">
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

                <div class="button-group">
                    <a href="{{ route('books.index') }}" class="btn btn-secondary">Cancel</a>
                    <button type="submit" class="btn btn-success">Create Book</button>
                </div>
            </form>
        </div>
    </div>
</body>
</html> 