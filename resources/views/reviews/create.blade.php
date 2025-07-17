<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Review for {{ $book->title }}</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; background: #f8f9fa; }
        .container { max-width: 800px; margin: 0 auto; }
        .form-section { background: white; padding: 20px; border-radius: 8px; box-shadow: 0 2px 8px #eee; }
        .form-group { margin-bottom: 15px; }
        label { display: block; margin-bottom: 5px; font-weight: bold; }
        input, textarea, select { width: 100%; padding: 8px; border: 1px solid #ddd; border-radius: 4px; font-size: 14px; }
        textarea { resize: vertical; min-height: 100px; }
        .btn { padding: 10px 20px; border: none; border-radius: 4px; cursor: pointer; text-decoration: none; display: inline-block; margin-right: 10px; }
        .btn-primary { background-color: #007bff; color: white; }
        .btn-secondary { background-color: #6c757d; color: white; }
        .btn:hover { opacity: 0.9; }
        .error { color: #dc3545; font-size: 12px; margin-top: 5px; }
        .book-info { background: #e9ecef; padding: 15px; border-radius: 5px; margin-bottom: 20px; }
        .book-title { font-size: 1.5em; font-weight: bold; margin-bottom: 5px; }
        .book-author { color: #666; }
        .rating-group { display: flex; gap: 10px; align-items: center; }
        .rating-option { display: flex; align-items: center; gap: 5px; }
        .rating-option input { width: auto; }
        .nav { margin-bottom: 20px; }
        .nav a { color: #007bff; text-decoration: none; }
        .nav a:hover { text-decoration: underline; }
    </style>
</head>
<body>
    <div class="container">
        <div class="nav">
            <a href="{{ route('books.show', $book) }}">← Back to {{ $book->title }}</a>
        </div>

        <h1>Add Review</h1>

        <div class="book-info">
            <div class="book-title">{{ $book->title }}</div>
            <div class="book-author">by {{ $book->author->name }}</div>
        </div>

        <div class="form-section">
            <form action="{{ route('reviews.store', $book) }}" method="POST">
                @csrf
                
                <div class="form-group">
                    <label for="rating">Rating *</label>
                    <div class="rating-group">
                        @for($i = 1; $i <= 5; $i++)
                            <div class="rating-option">
                                <input type="radio" id="rating{{ $i }}" name="rating" value="{{ $i }}" 
                                       {{ old('rating') == $i ? 'checked' : '' }} required>
                                <label for="rating{{ $i }}">{{ $i }} Star{{ $i > 1 ? 's' : '' }}</label>
                            </div>
                        @endfor
                    </div>
                    @error('rating')
                        <div class="error">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="content">Review *</label>
                    <textarea id="content" name="content" placeholder="Write your review here..." required>{{ old('content') }}</textarea>
                    @error('content')
                        <div class="error">{{ $message }}</div>
                    @enderror
                </div>

                <button type="submit" class="btn btn-primary">Submit Review</button>
                <a href="{{ route('books.show', $book) }}" class="btn btn-secondary">Cancel</a>
            </form>
        </div>
    </div>
</body>
</html> 