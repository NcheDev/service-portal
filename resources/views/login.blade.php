  <!DOCTYPE html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>NCHE Admin</title>
    <link rel="stylesheet" href="assets/vendors/mdi/css/materialdesignicons.min.css">
    <link rel="stylesheet" href="assets/vendors/ti-icons/css/themify-icons.css">
    <link rel="stylesheet" href="assets/vendors/css/vendor.bundle.base.css">
    <link rel="stylesheet" href="assets/vendors/font-awesome/css/font-awesome.min.css">
    <!-- endinject -->
    <!-- Plugin css for this page -->
    <link rel="stylesheet" href="assets/vendors/font-awesome/css/font-awesome.min.css" />
    <link rel="stylesheet" href="assets/vendors/bootstrap-datepicker/bootstrap-datepicker.min.css">
    <link rel="stylesheet" href="assets/css/style.css">

    <!-- endinject -->
    <!-- Plugin css for this page -->
    <!-- End plugin css for this page -->
    <!-- inject:css -->
    <!-- endinject -->
    <!-- Layout styles -->
    <link rel="stylesheet" href="assets/css/style.css">
    <!-- End layout styles -->
    <link rel="shortcut icon" href="assets/images/favicon.png" />
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
      
      <div class="container-fluid page-body-wrapper full-page-wrapper">
        <div class="content-wrapper d-flex align-items-center auth" style="background-color=white">
          <div class="row flex-grow">
            <div class="col-lg-4 mx-auto">
              <div class="auth-form-light text-left p-5">
                <div class="brand-logo">
                  <img src="assets/images/logo1.png">
                </div>
                <h4>Hello! let's get started</h4>
                <h6 class="font-weight-light">Sign in to continue.</h6>
                <form class="pt-3" method="POST" action="{{ route('login') }}">
                  @csrf
              
                  <!-- Email Field -->
                  <div class="form-group">
                      <input type="email" name="email" class="form-control form-control-lg" placeholder="Email" value="{{ old('email') }}" required>
                      @error('email')
                          <div class="text-danger">{{ $message }}</div>
                      @enderror
                  </div>
              
                  <!-- Password Field -->
                  <div class="form-group">
                      <input type="password" name="password" class="form-control form-control-lg" placeholder="Password" required>
                      @error('password')
                          <div class="text-danger">{{ $message }}</div>
                       @enderror
                  </div>
                  <div class="g-recaptcha" data-sitekey="{{ config('services.recaptcha.site_key') }}"></div>
                  @error('g-recaptcha-response')
                      <span class="text-danger">{{ $message }}</span>
                  @enderror
                  <!-- Submit Button -->
                  <div class="mt-3 d-grid gap-2">
                      <button type="submit" class="btn btn-block btn-gradient-primary btn-lg font-weight-medium auth-form-btn">
                          SIGN IN
                      </button>
                  </div>
              
                  <!-- Remember Me Checkbox & Forgot Password -->
                  <div class="my-2 d-flex justify-content-between align-items-center">
                      <div class="form-check">
                          <label class="form-check-label text-muted">
                              <input type="checkbox" name="remember" class="form-check-input"> <b>Keep me signed in</b>
                          </label>
                      </div>
                      <a href="#" class="auth-link text-primary"><b>Forgot password?</b></a>
                  </div>
              
                  <!-- Register Link -->
                  <div class="text-center mt-4 font-weight-light"><b>
                      Don't have an account? </b><a href="{{ route('register') }}" class="text-primary"><span>Register</span></a>
                  </div>
              </form>
              
              
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
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
  </body>
  <style>

b{

  color:white;
}
span{

  color: blue;
}

  </style>
</html>