<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>NCHE Admin</title>
    
    <!-- Vendor CSS -->
    <link rel="stylesheet" href="{{ asset('assets/vendors/mdi/css/materialdesignicons.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendors/ti-icons/css/themify-icons.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendors/css/vendor.bundle.base.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendors/font-awesome/css/font-awesome.min.css') }}">

    <!-- Plugin CSS for this page -->
    <link rel="stylesheet" href="{{ asset('assets/vendors/bootstrap-datepicker/bootstrap-datepicker.min.css') }}">

    <!-- Main Style CSS -->
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">

    <!-- Favicon -->
    <link rel="shortcut icon" href="{{ asset('assets/images/favicon.png') }}" />

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark default-layout-navbar fixed-top">
        <div class="container-fluid">
            <!-- Logo -->
            <a class="navbar-brand d-flex align-items-center" href="#">
                <img src="{{ asset('assets/images/logo1.png') }}" alt="Logo" width="30" height="30" class="me-2">
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
                        <a class="nav-link text-white" href="/">Home</a>
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

    <!-- Add Bootstrap JS Bundle (includes Popper.js) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
