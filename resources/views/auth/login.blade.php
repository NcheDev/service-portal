<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome | Application System</title>
    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            background-color: #f9f6f4;
        }

        .login-card {
            background-color: #fff;
            border-radius: 10px;
            padding: 2rem;
            width: 100%;
            max-width: 400px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.2);
        }

        .login-card h2 {
            color: #600061;
            font-weight: bold;
            text-align: center;
            margin-bottom: 1.5rem;
        }

        .btn-theme {
            background-color: #600061;
            color: #fff;
            border: none;
        }

        .btn-theme:hover {
            background-color: #d96c19;
            color: #fff;
        }

        .form-label {
            color: #600061;
        }

        a.register-link {
            color: #600061;
            text-decoration: underline;
        }

        a.register-link:hover {
            color: #d96c19;
            text-decoration: none;
        }
    </style>
</head>
<body>

    <div class="login-card">
        <h2>Welcome Back</h2>

        @if(session('status'))
            <div class="alert alert-success">{{ session('status') }}</div>
        @endif

        @if($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('login') }}">
            @csrf
            <div class="mb-3">
                <label class="form-label" for="email">Email</label>
                <input type="email" name="email" id="email" class="form-control" required autofocus>
            </div>

            <div class="mb-3">
                <label class="form-label" for="password">Password</label>
                <input type="password" name="password" id="password" class="form-control" required>
            </div>

            <div class="mb-3 form-check">
                <input type="checkbox" name="remember" id="remember" class="form-check-input">
                <label class="form-check-label" for="remember">Remember me</label>
            </div>

            <button type="submit" class="btn btn-theme w-100">Log In</button>
        </form>

        <p class="text-center mt-3">
            Don't have an account? 
            <a href="{{ route('register') }}" class="register-link">Register</a>
        </p>

        @if(Route::has('password.request'))
            <p class="text-center mt-2">
                <a href="{{ route('password.request') }}" class="register-link">Forgot your password?</a>
            </p>
        @endif
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
