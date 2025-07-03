<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Genre - {{ $genre->name }}</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; }
        .container { max-width: 600px; margin: 0 auto; }
        .form-group { margin-bottom: 15px; }
        label { display: block; margin-bottom: 5px; font-weight: bold; }
        input[type="text"] { width: 100%; padding: 8px; border: 1px solid #ddd; border-radius: 4px; }
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
            <a href="{{ route('genres.show', $genre) }}">← Back to Genre Details</a>
        </div>

        <h1>Edit Genre: {{ $genre->name }}</h1>

        @if ($errors->any())
            <div style="color: red; margin-bottom: 20px;">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('genres.update', $genre) }}" method="POST">
            @csrf
            @method('PUT')
            
            <div class="form-group">
                <label for="name">Genre Name:</label>
                <input type="text" id="name" name="name" value="{{ old('name', $genre->name) }}" required>
            </div>

            <div class="form-group">
                <a href="{{ route('genres.show', $genre) }}" class="btn btn-secondary">Cancel</a>
                <button type="submit" class="btn btn-primary">Update Genre</button>
            </div>
        </form>
    </div>
</body>
</html> 