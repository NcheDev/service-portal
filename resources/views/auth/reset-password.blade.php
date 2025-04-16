@include('partials.header')

<style>
    .reset-container {
        max-width: 500px;
        margin: 50px auto;
        background-color: white;
        padding: 2rem;
        border-radius: 1rem;
        border: 2px solid #52074f;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }

    .reset-container h2 {
        text-align: center;
        color: #52074f;
        margin-bottom: 1.5rem;
    }

    .reset-container label {
        display: block;
        margin-bottom: 0.5rem;
        font-weight: bold;
        color: #52074f;
    }

    .reset-container input {
        width: 100%;
        padding: 0.6rem;
        margin-bottom: 1rem;
        border: 1px solid #ccc;
        border-radius: 0.5rem;
    }

    .reset-container button {
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

    .reset-container button:hover {
        background-color: #c76e20;
    }

    .error {
        color: red;
        font-size: 0.9rem;
        margin-top: -0.5rem;
        margin-bottom: 0.5rem;
    }
</style>

<br><br>
<div class="reset-container">
    <h2>Reset Password</h2>

    {{-- Show general error messages --}}
    @if ($errors->any())
        <div class="error">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('password.update') }}">
        @csrf

        <input type="hidden" name="token" value="{{ $token }}">

        <div>
            <label>Email Address</label>
            <input type="email" name="email"  value="{{ old('email') }}" required>
        </div>

        <div>
            <label>New Password</label>
            <input type="password" name="password" required>
        </div>

        <div>
            <label>Confirm Password</label>
            <input type="password"  name="password_confirmation" required>
        </div>

        <button type="submit">Reset Password</button>
    </form>
</div>
