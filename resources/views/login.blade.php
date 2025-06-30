<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>NCHE Admin Login</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Icons -->
    <link href="https://cdn.jsdelivr.net/npm/@mdi/font/css/materialdesignicons.min.css" rel="stylesheet">
    
    <!-- Custom CSS -->
    <style>
        body {
            background: linear-gradient(135deg, #52074f, #dd8027);
            height: 100vh;
            margin: 0;
            font-family: 'Segoe UI', sans-serif;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .login-box {
            background: #fff;
            border-radius: 16px;
            padding: 2.5rem 2rem;
            max-width: 420px;
            width: 100%;
            box-shadow: 0 0 40px rgba(0,0,0,0.1);
        }

        .login-box h4 {
            color: #52074f;
            font-weight: 600;
            margin-bottom: 5px;
        }

        .login-box .form-control {
            border-radius: 10px;
        }

        .login-box .btn-login {
            background-color: #dd8027;
            border: none;
            border-radius: 10px;
            font-weight: 600;
            color: white;
        }

        .login-box .btn-login:hover {
            background-color: #c76d21;
        }

        .auth-links a {
            color: #52074f;
            font-weight: 500;
        }

        .form-check-label {
            font-size: 0.9rem;
            color: #333;
        }

        .text-danger {
            font-size: 0.85rem;
        }

        .logo-icon {
            font-size: 48px;
            color: #dd8027;
        }
    </style>
</head>
<body>

    <div class="login-box shadow">
        <div class="text-center mb-3">
            <i class="mdi mdi-shield-account logo-icon"></i>
        </div>

        <h4 class="text-center">Welcome Back</h4>
        <p class="text-center text-muted mb-4">Sign in to access the NCHE Admin Panel</p>

        <form method="POST" action="{{ route('login') }}">
            @csrf

            <!-- Email -->
            <div class="mb-3">
                <input type="email" name="email" value="{{ old('email') }}"
                       class="form-control form-control-lg @error('email') is-invalid @enderror"
                       placeholder="Email" required autofocus>
                @error('email')
                    <div class="text-danger mt-1">{{ $message }}</div>
                @enderror
            </div>

            <!-- Password -->
            <div class="mb-3">
                <input type="password" name="password"
                       class="form-control form-control-lg @error('password') is-invalid @enderror"
                       placeholder="Password" required>
                @error('password')
                    <div class="text-danger mt-1">{{ $message }}</div>
                @enderror
            </div>

            <!-- reCAPTCHA -->
            <div class="mb-3">
                <div class="g-recaptcha" data-sitekey="{{ config('services.recaptcha.site_key') }}"></div>
                @error('g-recaptcha-response')
                    <div class="text-danger mt-1">{{ $message }}</div>
                @enderror
            </div>

            <!-- Login Button -->
            <div class="d-grid mb-3">
                <button type="submit" class="btn btn-login btn-lg">
                    <i class="mdi mdi-login-variant"></i> Sign In
                </button>
            </div>

            <!-- Remember Me & Forgot Password -->
            <div class="d-flex justify-content-between align-items-center mb-2">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="remember" id="remember">
                    <label class="form-check-label" for="remember">
                        Keep me signed in
                    </label>
                </div>
                <div class="auth-links">
                    <a href="{{ route('password.request') }}">Forgot Password?</a>
                </div>
            </div>

            <!-- Register -->
            <div class="text-center auth-links mt-4">
                Don't have an account? <a href="{{ route('register') }}">Register</a>
            </div>
        </form>
    </div>

    <!-- Scripts -->
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
</body>
</html>
