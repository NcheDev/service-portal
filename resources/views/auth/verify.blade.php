@extends('layouts.app') {{-- Or replace with your actual layout --}}

@section('content')
<div class="container">
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

    <form method="POST" action="{{ route('logout') }}" style="margin-top: 10px;">
        @csrf
        <button type="submit" class="btn btn-secondary">Logout</button>
    </form>
</div>
@endsection
