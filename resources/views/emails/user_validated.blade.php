<!DOCTYPE html>
<html>
<head>
    <title>Verification Complete</title>
</head>
<body>
    <p>Hi {{ $name }},</p>

    <p>We're happy to inform you that your verification is complete 🎉</p>

    <p>You can now log in to your account to view your results:</p>

    <p>
        <a href="{{ $url }}" style="background-color: #28a745; color: white; padding: 10px 15px; text-decoration: none;">
            Log In
        </a>
    </p>

    <p>Thank you for using our service!</p>
</body>
</html>
