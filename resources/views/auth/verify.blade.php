. 

<div class="email-verification-container">
    <h2>Please Verify Your Email Address</h2>

    @if (session('resent'))
        <div class="alert alert-success" role="alert">
            A new verification link has been sent to your email address.
        </div>
    @endif

    <p>Before proceeding, please check your email for a verification link.</p>
    <p>If you did not receive the email, you can request another:</p>

    <form method="POST" action="{{ route('verification.send') }}">
        @csrf
        <button type="submit" class="btn btn-primary">Resend Verification Email</button>
    </form>

    <form method="POST" action="{{ route('logout') }}">
        @csrf
        <button type="submit" class="btn btn-secondary">Log In</button>
    </form>
</div>
<style>
    body {
background-color: #f4f4f4; 
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        min-height: 100vh;
        display: flex;
        justify-content: center;
        align-items: center;
        margin: 0;
        padding: 20px;
    }

    .email-verification-container {
        background-color: #fff;
        border-radius: 20px;
        padding: 2rem 2.5rem;
        max-width: 500px;
        width: 100%;
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.15);
        text-align: center;
    }

    .email-verification-container h2 {
        color: #52074f;
        margin-bottom: 1.5rem;
    }

    .email-verification-container p {
        color: #333;
        margin-bottom: 1rem;
    }

    .alert-success {
        background-color: #dd80274d;
        color: #52074f;
        padding: 10px 15px;
        border-radius: 8px;
        margin-bottom: 1rem;
        border-left: 5px solid #dd8027;
    }

    .email-verification-container button {
        width: 100%;
        padding: 0.75rem;
        font-size: 1rem;
        border: none;
        border-radius: 8px;
        margin-top: 10px;
        cursor: pointer;
        transition: background-color 0.3s ease;
    }

    .btn-primary {
        background-color: #52074f;
        color: #fff;
    }

    .btn-primary:hover {
        background-color: #3e053c;
    }

    .btn-secondary {
        background-color: #dd8027;
        color: #fff;
    }

    .btn-secondary:hover {
        background-color: #c56e1f;
    }
</style>
 
