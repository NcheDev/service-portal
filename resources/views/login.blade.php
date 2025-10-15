<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>NCHE Admin Login</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Material Design Icons -->
    <link href="https://cdn.jsdelivr.net/npm/@mdi/font/css/materialdesignicons.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <style>
        body {
            background: linear-gradient(135deg, #ffffff, #fdf6f0);
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
            box-shadow: 0 8px 30px rgba(0,0,0,0.12);
            border-top: 6px solid #52074f;
        }
        .login-box h4 {
            color: #52074f;
            font-weight: 600;
            margin-bottom: 0.3rem;
        }
        .login-box .form-control {
            border-radius: 10px;
            border: 1px solid #ddd;
        }
        .login-box .form-control:focus {
            border-color: #52074f;
            box-shadow: none;
        }
        .btn-login {
            background-color: #dd8027;
            border: none;
            border-radius: 10px;
            font-weight: 600;
            color: white;
            transition: background 0.3s;
        }
        .btn-login:hover {
            background-color: #c76d21;
        }
        .auth-links a {
            color: #52074f;
            font-weight: 500;
            text-decoration: none;
        }
        .auth-links a:hover { text-decoration: underline; }
        .text-danger { font-size: 0.85rem; }
        .logo-img { max-width: 120px; margin-bottom: 15px; }
        @media(max-width: 480px){
            .login-box { padding: 2rem 1.5rem; }
        }
    </style>
</head>
<body>
    <div class="login-box shadow">
        <div class="text-center mb-3">
            <img src="{{ asset('images/logo1.jpg') }}" alt="NCHE Logo" class="logo-img">
        </div>

        <h4 class="text-center">Welcome</h4>

        <form id="loginForm" method="POST" action="{{ route('login') }}">
            @csrf 

            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @if (session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            <!-- Email -->
            <div class="mb-3">
                <input type="email" name="email" id="email" value="{{ old('email') }}"
                    class="form-control form-control-lg @error('email') is-invalid @enderror"
                    placeholder="Email" required autofocus>
                @error('email')
                    <div class="text-danger mt-1">{{ $message }}</div>
                @enderror
                <div class="text-danger mt-1 js-error" id="emailError"></div>
            </div>

            <!-- Password -->
            <div class="mb-3">
                <input type="password" name="password" id="password"
                    class="form-control form-control-lg @error('password') is-invalid @enderror"
                    placeholder="Password" required>
                @error('password')
                    <div class="text-danger mt-1">{{ $message }}</div>
                @enderror
                <div class="text-danger mt-1 js-error" id="passwordError"></div>
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
                    <label class="form-check-label" for="remember">Keep me signed in</label>
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
    <script>
        document.getElementById('loginForm').addEventListener('submit', function(e) {
            let hasError = false;

            // Clear previous JS errors
            document.getElementById('emailError').textContent = '';
            document.getElementById('passwordError').textContent = '';

            const email = document.getElementById('email').value.trim();
            const password = document.getElementById('password').value.trim();

            // Email validation
            const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            if (email === '') {
                document.getElementById('emailError').textContent = 'Email is required.';
                hasError = true;
            } else if (!emailPattern.test(email)) {
                document.getElementById('emailError').textContent = 'Enter a valid email.';
                hasError = true;
            }

            // Password validation
            const passwordPattern = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[\W_]).{8,}$/;
            if (password === '') {
                document.getElementById('passwordError').textContent = 'Password is required.';
                hasError = true;
            } else if (!passwordPattern.test(password)) {
                document.getElementById('passwordError').textContent = 'Password must be at least 8 characters, include uppercase, lowercase, number, and symbol.';
                hasError = true;
            }

            if (hasError) {
                e.preventDefault(); // Stop form submission
            }
        });
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
