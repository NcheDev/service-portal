<!DOCTYPE html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>NCHE Admin</title>
    <!-- plugins:css -->
    <link rel="stylesheet" href="assets/vendors/mdi/css/materialdesignicons.min.css">
    <link rel="stylesheet" href="assets/vendors/ti-icons/css/themify-icons.css">
    <link rel="stylesheet" href="assets/vendors/css/vendor.bundle.base.css">
    <link rel="stylesheet" href="assets/vendors/font-awesome/css/font-awesome.min.css">
    <!-- endinject -->
    <!-- Plugin css for this page -->
    <!-- End plugin css for this page -->
    <!-- inject:css -->
    <!-- endinject -->
    <!-- Layout styles -->
    <link rel="stylesheet" href="assets/css/style.css">
    <!-- End layout styles -->
    <link rel="shortcut icon" href="assets/images/logo2.png" />
  </head>
  <body class="page-specificc">
    <div class="container-scroller">
      <nav class="navbar navbar-expand-lg navbar-dark default-layout-navbar fixed-top">

        <div class="container-fluid">
          <!-- Logo -->
          <a class="navbar-brand d-flex align-items-center" href="#">
            <img src="assets/images/logo1.png" alt="NCHE Logo" width="30" height="30" class="me-2">
            <strong>NCHE</strong>
          </a>
      
          <!-- Toggler: visible only on small screens -->
          <button class="navbar-toggler d-lg-none" type="button" data-bs-toggle="collapse" data-bs-target="#navbarContent">
            <span class="mdi mdi-menu text-white"></span>
          </button>
      
          <!-- Collapsible Content -->
          <div class="collapse navbar-collapse justify-content-between" id="navbarContent">
            
            <!-- Nav Links -->
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
              <li class="nav-item">
                <a class="nav-link text-white" href="#">Home</a>
              </li>
              <li class="nav-item">
                <a class="nav-link text-white" href="#">About</a>
              </li>
              <li class="nav-item">
                <a class="nav-link text-white" href="#">Services</a>
              </li>
              <li class="nav-item">
                <a class="nav-link text-white" href="#">Contact Us</a>
              </li>
            </ul>
      
            <!-- Contact Info (wraps neatly on smaller screens) -->
            <ul class="navbar-nav ms-auto flex-wrap">
              <li class="nav-item d-flex align-items-center text-white me-4">
                <i class="mdi mdi-phone me-1"></i> +265 111 755 884
              </li>
              <li class="nav-item d-flex align-items-center text-white me-4">
                <i class="mdi mdi-cellphone me-1"></i> +265 99 450 3329
              </li>
              <li class="nav-item d-flex align-items-center text-white">
                <i class="mdi mdi-email-outline me-1"></i> info@nche.ac.mw
              </li>
            </ul>
      
          </div>
        </div>
      </nav>
 <!-- Main wrapper with background white -->
<div class="auth-wrapper">
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-lg-4">
        <div class="custom-rounded-box text-left p-5">
          <h4 class="mb-3">New here?</h4>
          <h6 class="font-weight-light mb-4">Signing up is easy. It only takes a few steps.</h6>
          @if ($errors->any())
          <div class="alert alert-danger">
              <ul class="mb-0">
                  @foreach ($errors->all() as $error)
                      <li>{{ $error }}</li>
                  @endforeach
              </ul>
          </div>
      @endif
      
          <form method="POST" action="{{ route('register') }}" class="pt-3">
            @csrf
            <div class="form-group">
              <input type="text" name="username" class="form-control form-control-lg" placeholder="Username" value="{{ old('username') }}">
            </div>
            <div class="form-group">
              <input type="email" name="email" class="form-control form-control-lg" placeholder="Email" value="{{ old('email') }}">
            </div>
            <div class="form-group">
              <input type="password" name="password" class="form-control form-control-lg" placeholder="Password">
            </div>
            <div class="form-group">
              <input type="password" name="password_confirmation" class="form-control form-control-lg" placeholder="Confirm Password">
            </div>
            <div class="mb-4">
               <!-- reCAPTCHA -->
               <div class="g-recaptcha mb-3" data-sitekey="{{ config('services.recaptcha.site_key') }}"></div>
               @error('g-recaptcha-response')
                 <span class="text-danger">{{ $message }}</span>
               @enderror
              <div class="form-check">
                <label class="form-check-label text-muted">
                  <input type="checkbox" class="form-check-input" required> I agree to all Terms & Conditions
                </label>
              </div>
            </div>
            <div class="mt-3 d-grid gap-2">
              <button type="submit" class="btn btn-block btn-gradient-primary btn-lg font-weight-medium auth-form-btn">SIGN UP</button>
            </div>
          </form>
        </div> <!-- end of custom-rounded-box -->
      </div>
    </div>
  </div>
</div>


      
        </div>
        <!-- content-wrapper ends -->
      </div>
      <!-- page-body-wrapper ends -->
    </div>
    <!-- container-scroller -->
    <!-- plugins:js -->
    <script src="assets/vendors/js/vendor.bundle.base.js"></script>
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>

    <!-- endinject -->
    <!-- Plugin js for this page -->
    <!-- End plugin js for this page -->
    <!-- inject:js -->
    <script src="assets/js/off-canvas.js"></script>
    <script src="assets/js/misc.js"></script>
    <script src="assets/js/settings.js"></script>
    <script src="assets/js/todolist.js"></script>
    <script src="assets/js/jquery.cookie.js"></script>
    <!-- endinject -->
  </body>


<style>
.custom-rounded-box {
  border-radius: 20px; /* makes the corners more rounded */
  background-color: #ffffff; /* ensures white background */
  box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1); /* soft shadow */
}


  /* Style the entire navbar for consistency */
.navbar-nav .nav-item i {
  color: white; /* Ensure icons are white */
  font-size: 18px; /* Adjust icon size */
  transition: transform 0.3s ease, color 0.3s ease; /* Smooth transition for hover effects */
}

/* Add spacing between the icons */
.navbar-nav .nav-item {
  margin-right: 15px; /* Adds space between icons */
}

/* On hover, scale the icons and change their color */
.navbar-nav .nav-item:hover i {
  transform: scale(1.1); /* Slightly increase the icon size on hover */
  color: #dd8027; /* Change the icon color to a brand color when hovered */
}

/* Add some custom padding to the text */
.navbar-nav .nav-item span {
  padding-left: 5px;
}
.auth-wrapper {
  background: #dd8027; /* solid background color */
  min-height: 100vh;
  display: flex;
  align-items: center;
  justify-content: center;
}

.custom-rounded-box {
  border-radius: 20px;
  background-color: #ffffff;
  box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
}



/* Make sure body has a white background */
body {
  background-color: #ffffff;
  margin-top: 80px; /* Adjust based on the height of your navbar */
}

/* Styling for the container inside the auth-wrapper */
.auth-wrapper {
  background-color: #ffffff;
  min-height: 100vh;
  display: flex;
  justify-content: center;
  align-items: center;
}

/* Custom rounded box */
.custom-rounded-box {
  background-color: #ffffff;
  border-radius: 10px;
  box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
  padding: 40px;
  width: 100%;
}

.auth-form-btn {
  background-color: #dd8027;
  color: white;
}

/* Adjust form input focus color */
.form-control:focus {
  border-color: #52074f;
  box-shadow: 0 0 0 0.2rem rgba(28, 18, 218, 0.25);
}


</style>
</html>