<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register | Application System</title>
    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            background-color: #ffffff; /* White background */
        }

        .register-card {
            background-color: #fff;
            border-radius: 10px;
            padding: 2rem;
            width: 100%;
            max-width: 450px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.2);
        }

        .register-card h2 {
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

        a.login-link {
            color: #600061;
            text-decoration: underline;
        }

        a.login-link:hover {
            color: #d96c19;
            text-decoration: none;
        }
    </style>
</head>
<body>

    <div class="register-card">
        <h2>Create Account</h2>

        @if($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('register') }}">
            @csrf

            <div class="mb-3">
                <label class="form-label" for="name">Name</label>
                <input type="text" name="name" id="name" class="form-control" value="{{ old('name') }}" required autofocus>
            </div>

            <div class="mb-3">
                <label class="form-label" for="email">Email</label>
                <input type="email" name="email" id="email" class="form-control" value="{{ old('email') }}" required>
            </div>

            <div class="mb-3">
                <label class="form-label" for="password">Password</label>
                <input type="password" name="password" id="password" class="form-control" required>
            </div>

            <div class="mb-3">
                <label class="form-label" for="password_confirmation">Confirm Password</label>
                <input type="password" name="password_confirmation" id="password_confirmation" class="form-control" required>
            </div>

            <button type="submit" class="btn btn-theme w-100 mb-3">Register</button>

            <p class="text-center">
                Already registered? 
                <a href="{{ route('login') }}" class="login-link">Log in</a>
            </p>
        </form>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
