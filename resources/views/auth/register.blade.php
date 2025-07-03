<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; background: #f8f9fa; }
        .container { max-width: 400px; margin: 100px auto; }
        .register-form { background: white; border-radius: 8px; box-shadow: 0 2px 8px #eee; padding: 30px; }
        .form-title { text-align: center; margin-bottom: 30px; font-size: 1.8em; color: #333; }
        .form-group { margin-bottom: 20px; }
        .form-label { display: block; margin-bottom: 5px; font-weight: bold; color: #333; }
        .form-control { width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 4px; font-size: 1em; }
        .form-control:focus { outline: none; border-color: #007bff; }
        .btn { width: 100%; padding: 12px; border: none; border-radius: 4px; cursor: pointer; font-size: 1em; }
        .btn-primary { background-color: #007bff; color: white; }
        .btn-primary:hover { background-color: #0056b3; }
        .error { color: #dc3545; font-size: 0.9em; margin-top: 5px; }
        .login-link { text-align: center; margin-top: 20px; }
        .login-link a { color: #007bff; text-decoration: none; }
        .login-link a:hover { text-decoration: underline; }
    </style>
</head>
<body>
    <div class="container">
        <div class="register-form">
            <h2 class="form-title">Register</h2>
            
            @if($errors->any())
                <div class="error" style="margin-bottom: 20px;">
                    @foreach($errors->all() as $error)
                        <div>{{ $error }}</div>
                    @endforeach
                </div>
            @endif

            <form method="POST" action="{{ route('register') }}">
                @csrf
                
                <div class="form-group">
                    <label for="name" class="form-label">Name</label>
                    <input type="text" id="name" name="name" class="form-control" value="{{ old('name') }}" required>
                </div>

                <div class="form-group">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" id="email" name="email" class="form-control" value="{{ old('email') }}" required>
                </div>

                <div class="form-group">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" id="password" name="password" class="form-control" required>
                    <small style="color: #666; font-size: 0.9em;">Password must be at least 8 characters long.</small>
                </div>

                <div class="form-group">
                    <label for="password_confirmation" class="form-label">Confirm Password</label>
                    <input type="password" id="password_confirmation" name="password_confirmation" class="form-control" required>
                </div>

                <button type="submit" class="btn btn-primary">Register</button>
            </form>

            <div class="login-link">
                Already have an account? <a href="{{ route('login') }}">Login here</a>
            </div>
        </div>
    </div>
</body>
</html> 