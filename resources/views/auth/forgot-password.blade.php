@include('partials.header')

<style>
    .forgot-container {
        max-width: 500px;
        margin: 50px auto;
        background-color: white;
        padding: 2rem;
        border-radius: 1rem;
        border: 2px solid #52074f;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }

    .forgot-container h2 {
        text-align: center;
        color: #52074f;
        margin-bottom: 1.5rem;
    }

    .forgot-container label {
        display: block;
        margin-bottom: 0.5rem;
        font-weight: bold;
        color: #52074f;
    }

    .forgot-container input[type="email"] {
        width: 100%;
        padding: 0.6rem;
        margin-bottom: 1rem;
        border: 1px solid #ccc;
        border-radius: 0.5rem;
    }

    .forgot-container button {
        width: 100%;
        background-color: #dd8027;
        color: white;
        padding: 0.7rem;
        border: none;
        border-radius: 0.5rem;
        font-weight: bold;
        cursor: pointer;
        transition: background-color 0.3s ease;
    }

    .forgot-container button:hover {
        background-color: #c76e20;
    }

    .alert-success {
        background-color: #d4edda;
        border: 1px solid #c3e6cb;
        color: #155724;
        padding: 0.75rem 1rem;
        margin-bottom: 1rem;
        border-radius: 0.5rem;
    }
</style>
<br><br>
<div class="forgot-container">
    <h2>Forgot Password</h2>

    @if (session('status'))
        <div class="alert alert-success">{{ session('status') }}</div>
    @endif

    <form method="POST" action="{{ route('password.email') }}">
        @csrf
        <div>
            <label>Email Address</label>
            <input type="email" name="email" required>
        </div>
        <button type="submit">Send Password Reset Link</button>
    </form>
</div>
