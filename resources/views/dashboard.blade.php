<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
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
        .options-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 20px; margin-top: 20px; }
        .option-card { background: white; border-radius: 8px; box-shadow: 0 2px 8px #eee; padding: 30px; text-align: center; text-decoration: none; color: #333; transition: transform 0.2s; }
        .option-card:hover { transform: translateY(-5px); text-decoration: none; color: #333; }
        .option-icon { font-size: 3rem; margin-bottom: 15px; color: #007bff; }
        .option-title { font-size: 1.5rem; font-weight: bold; margin-bottom: 10px; }
        .option-description { color: #666; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Dashboard</h1>
            <form action="{{ route('logout') }}" method="POST" style="display: inline;">
                @csrf
                <button type="submit" class="btn btn-secondary">Logout</button>
            </form>
        </div>
        
        <div class="section">
            <div class="options-grid">
                <a href="{{ route('books.index') }}" class="option-card">
                    <div class="option-title">All Books</div>
                    <div class="option-description">Browse and manage your book collection</div>
                </a>
                
                <a href="{{ route('authors.index') }}" class="option-card">
                    <div class="option-title">All Authors</div>
                    <div class="option-description">View and manage author information</div>
                </a>
                
                <a href="{{ route('genres.index') }}" class="option-card">
                    <div class="option-title">All Genres</div>
                    <div class="option-description">Explore different book categories</div>
                </a>
            </div>
        </div>
    </div>
</body>
</html> 