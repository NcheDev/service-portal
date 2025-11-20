<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>404 - Page Not Found | NCHE</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(to bottom, #f7f2fa, #e9dff5);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: 'Segoe UI', sans-serif;
        }

        .card {
            border-radius: 15px;
            padding: 40px 30px;
        }

        .nche-logo {
            width: 120px;
            height: auto;
            display: block;
            margin: 0 auto 20px auto;
        }

        .crying-emoji {
            font-size: 5rem;
            margin-bottom: 20px;
        }

        h1.display-1 {
            color: #714787; /* NCHE purple */
        }

        .btn-nche {
            background-color: #52074f;
            color: white;
        }

        .btn-nche:hover {
            background-color: #714787;
            color: white;
        }
    </style>
</head>
<body>
    <div class="container text-center">
        <div class="card shadow-sm mx-auto" style="max-width: 600px;">
            
            <!-- Logo -->
            <img src="{{ asset('assets/images/logo1.png') }}" alt="NCHE Logo" class="nche-logo">

            <!-- Crying emoji -->
            <div class="crying-emoji">😭</div>

            <h1 class="display-1 fw-bold">404</h1>
            <h2 class="fw-bold mb-3">Page Not Found</h2>
            <p class="text-muted mb-4">
                Oops! The page you are looking for does not exist or has been moved.
            </p>

            <a href="{{ url('/') }}" class="btn btn-lg btn-nche">
                Go to Home
            </a>
        </div>
    </div>
</body>
</html>
