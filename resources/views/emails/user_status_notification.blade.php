<!DOCTYPE html>
<html>
<head>
    <title>Application Status Update</title>
</head>
<body>
    <p>Dear {{ $name }},</p>

    @if($status === 'validated')
        <p>Your application has been <strong>validated</strong> successfully. 🎉</p>
    @else
        <p>Your application has been <strong>marked as invalid</strong>. Please review the feedback.</p>
    @endif

    <p>
        To view your application results, please log in and check under <strong>My Applications</strong> in your account.
    </p>

    <p>
        <a href="{{ url('/login') }}" style="background-color: #28a745; color: white; padding: 10px 15px; text-decoration: none;">
            Log In
        </a>
    </p>

    <p>Thank you for using our system.</p>

    <p>Best regards,<br>Your Application Team</p>
</body>
</html>
