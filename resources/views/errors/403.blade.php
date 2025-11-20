{{-- resources/views/errors/403.blade.php --}}
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>403 - Forbidden | NCHE</title>
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
            margin: 0 auto 20px;
            display: block;
        }
        .emoji {
            font-size: 5rem;
            margin-bottom: 20px;
        }
        h1.display-1 {
            color: #714787;
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
            <img src="{{ asset('assets/images/logo1.png') }}" alt="NCHE Logo" class="nche-logo">
            <div class="emoji">🙅‍♂️</div>
            <h1 class="display-1 fw-bold">403</h1>
            <h2 class="fw-bold mb-3">Forbidden</h2>
            <p class="text-muted mb-4">
                Sorry! You don’t have permission to access this page.
            </p>
            <a href="{{ url('/') }}" class="btn btn-lg btn-nche">Go to Home</a>
        </div>
    </div>
</body>
</html>
