<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>NCHE Admin</title>

    <link rel="stylesheet" href="assets/vendors/mdi/css/materialdesignicons.min.css" />
    <link rel="stylesheet" href="assets/vendors/ti-icons/css/themify-icons.css" />
    <link rel="stylesheet" href="assets/vendors/css/vendor.bundle.base.css" />
    <link rel="stylesheet" href="assets/vendors/font-awesome/css/font-awesome.min.css" />
    <link rel="stylesheet" href="assets/css/style.css" />
    <link rel="shortcut icon" href="assets/images/logo2.png" />

    <!-- Google reCAPTCHA -->
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>

    
  </head>

  <body class="page-specificc">
    <div class="container-scroller">
      @include('partials.header')
<br><br>
      <div class="auth-wrapper">
        <div class="custom-rounded-box">
          <div style="padding: 2rem">
            <h4>New here?</h4>
            <h6>Signing up is easy. It only takes a few steps.</h6>

            @if ($errors->any())
              <div class="alert alert-danger">
                <ul class="mb-0">
                  @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                  @endforeach
                </ul>
              </div>
            @endif

            <form method="POST" action="{{ route('register') }}">
    @csrf
<!-- First Name -->
<div class="mb-3">
    <label for="first_name" class="form-label">First Name</label>
    <input 
        type="text" 
        id="first_name" 
        name="first_name" 
        class="form-control @error('first_name') is-invalid @enderror" 
        placeholder="Enter your first name" 
        value="{{ old('first_name') }}" 
        required
    >
    @error('first_name')
        <div class="text-danger mt-1">{{ $message }}</div>
    @enderror
</div>

<!-- Surname -->
<div class="mb-3">
    <label for="surname" class="form-label">Surname</label>
    <input 
        type="text" 
        id="surname" 
        name="surname" 
        class="form-control @error('surname') is-invalid @enderror" 
        placeholder="Enter your surname" 
        value="{{ old('surname') }}" 
        required
    >
    @error('surname')
        <div class="text-danger mt-1">{{ $message }}</div>
    @enderror
</div>
<!-- Email -->
<div class="mb-3">
    <label for="email" class="form-label">Email Address</label>
    <input 
        type="email" 
        id="email" 
        name="email" 
        class="form-control" 
        placeholder="Enter your email" 
        value="{{ old('email') }}" 
        required
    />
    @error('email')
        <span class="text-danger small">{{ $message }}</span>
    @enderror
</div>
<!-- Password -->
<div class="mb-3">
    <label for="password" class="form-label">
        Password
        <small class="text-muted d-block mt-1">   Minimum 8 characters, include letters, numbers, and at least one symbol.</small>
    </label>

    <input 
        type="password" 
        id="password" 
        name="password" 
        class="form-control" 
        placeholder="Enter your password" 
        required
    />

    @error('password')
        <span class="text-danger small">{{ $message }}</span>
    @enderror
</div>

<!-- Confirm Password -->
<div class="mb-3">
    <label for="password_confirmation" class="form-label">Confirm Password</label>
    <input 
        type="password" 
        id="password_confirmation" 
        name="password_confirmation" 
        class="form-control" 
        placeholder="Re-enter your password" 
        required
    />
</div>

     

    <button type="submit" class="btn-submit">Register</button>
</form>

          </div>
        </div>
      </div>
    </div>
    @include("partials.footer")
  </body>
  <style>
    .recaptcha-wrapper {
transform: scale(1);
transform-origin: 0 0;
}

@media (max-width: 380px) {
.recaptcha-wrapper {
  transform: scale(0.85);
}
}

@media (max-width: 320px) {
.recaptcha-wrapper {
  transform: scale(0.75);
}
}

    body {
      background: #f9f9f9;
      font-family: 'Segoe UI', sans-serif;
    }

    .auth-wrapper {
      min-height: 100vh;
      display: flex;
      align-items: center;
      justify-content: center;
      background: #f0f0f0;
      padding: 2rem;
    }

    .custom-rounded-box {
      background: white;
      border-radius: 1rem;
      box-shadow: 0 0 20px rgba(0, 0, 0, 0.05);
      width: 100%;
      max-width: 420px;
    }

    h4 {
      color: #52074f;
      margin-bottom: 0.5rem;
    }

    h6 {
      color: #555;
      font-weight: 400;
    }

    input[type="text"],
    input[type="email"],
    input[type="password"] {
      width: 100%;
      padding: 0.75rem;
      border: 1px solid #ccc;
      border-radius: 0.5rem;
      margin-bottom: 1rem;
    }

    .form-check-label {
      font-size: 0.9rem;
      color: #333;
    }

    .btn-submit {
      background-color: #dd8027;
      color: white;
      padding: 0.75rem;
      border: none;
      border-radius: 0.5rem;
      width: 100%;
      font-weight: bold;
      cursor: pointer;
    }

    .btn-submit:hover {
      background-color: #c66f1f;
    }

    .alert-danger {
      color: #721c24;
      background-color: #f8d7da;
      padding: 0.75rem;
      border-radius: 0.5rem;
      margin-bottom: 1rem;
    }

    .text-danger {
      color: #dc3545;
      font-size: 0.875rem;
    }
  </style>
</html>
