{{-- resources/views/welcome.blade.php --}}
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome | Application System</title>

    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body, html {
            height: 100%;
            margin: 0;
            font-family: 'Segoe UI', sans-serif;
            background-color: #d96c19; /* primary color */
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .welcome-container {
            text-align: center;
            color: white;
        }

        .welcome-container h1 {
            color: #600061; /* secondary color */
            margin-bottom: 20px;
        }

        .btn-login {
            background-color: #600061;
            color: white;
            border: none;
        }

        .btn-login:hover {
            background-color: #d96c19;
            color: white;
        }

        .btn-register {
            background-color: white;
            color: #600061;
            border: 2px solid #600061;
        }

        .btn-register:hover {
            background-color: #600061;
            color: white;
        }

        .btn-group {
            display: flex;
            gap: 15px;
            justify-content: center;
            flex-wrap: wrap;
            margin-top: 20px;
        }

        @media (max-width: 576px) {
            .btn-group {
                flex-direction: column;
            }
        }
    </style>
</head>
<body>

    <div class="welcome-container">
        <h1>Welcome to QES System</h1>
        <p>Start managing your applications easily.</p>

        <div class="btn-group">
            <a href="{{ route('login') }}" class="btn btn-login btn-lg">Login</a>
            <a href="{{ route('register') }}" class="btn btn-register btn-lg">Register</a>
        </div>
    </div>

</body>
</html>
