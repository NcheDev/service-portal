<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>NCHE Admin</title>

  <!-- Material Design Icons -->
  <link href="https://cdn.materialdesignicons.com/5.4.55/css/materialdesignicons.min.css" rel="stylesheet" />
<meta name="csrf-token" content="{{ csrf_token() }}">

  <!-- Custom Styling -->
  <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
<!-- In the <head> -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

  <!-- Favicon -->
  <link rel="shortcut icon" href="{{ asset('assets/images/logo2.png') }}">
  <!-- Bootstrap 5.3 Bundle JS (includes Popper) -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-9ndCyUa6mYbry3Xn7dQWzE7t27Uy2LmM3C0zHNT95+Y9wFZT+Nf76f+Jp1wHg+nG" crossorigin="anonymous"></script>
  <!-- jQuery -->
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  
  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldj6z8e4l9+2b5d5a5e5f5e5f5e5f5e5f5e5f5e5f5e5f5e" crossorigin="anonymous">
</head>
<body class="page-specific">
  <div class="container-scroller">

    <!-- NAVBAR -->
   <nav class="navbar default-layout-navbar fixed-top navbar-expand-lg d-flex align-items-center justify-content-between px-3">
  <div class="d-flex align-items-center gap-3">
    <a class="navbar-brand" href="{{ url('/') }}">
      <img src="{{ asset('assets/images/logo1.png') }}" alt="logo" class="logo-lg">
    </a>
    <a class="navbar-brand d-lg-none" href="{{ url('/') }}">
      <img src="{{ asset('assets/images/logo2.png') }}" alt="logo" class="logo-mini">
    </a>
    <button class="btn text-white d-lg-none" type="button" data-bs-toggle="offcanvas" data-bs-target="#sidebar">
      <i class="mdi mdi-menu mdi-24px"></i>
    </button>
  </div>

  <div class="d-none d-md-flex align-items-center search-field">
    <form class="d-flex" role="search">
      <div class="input-group">
        <span class="input-group-text bg-transparent border-0">
          <i class="mdi mdi-magnify"></i>
        </span>
        <input class="form-control border-0" type="search" placeholder="Search projects">
      </div>
    </form>
  </div>

  <ul class="navbar-nav d-flex align-items-center gap-3 ms-auto">
    <!-- Notifications -->
    <li class="nav-item dropdown">
      <a class="nav-link dropdown-toggle" href="#" id="notificationDropdown" role="button" data-bs-toggle="dropdown">
        <i class="mdi mdi-bell-outline fs-4 text-white position-relative">
          <span class="position-absolute top-0 start-100 translate-middle p-1 bg-danger border border-light rounded-circle"></span>
        </i>
      </a>
      <ul class="dropdown-menu dropdown-menu-end bg-dark text-white" aria-labelledby="notificationDropdown">
        <li class="dropdown-header">Notifications</li>
        <li><hr class="dropdown-divider"></li>
        <li><a class="dropdown-item text-white" href="#"><i class="mdi mdi-calendar text-success me-2"></i> Event today</a></li>
      </ul>
    </li>

    <!-- Profile Dropdown -->
    <li class="nav-item dropdown">
      <a class="nav-link dropdown-toggle d-flex align-items-center" href="#" id="profileDropdown" role="button" data-bs-toggle="dropdown">
        <span class="text-white fw-semibold">Hello {{ Auth::user()->name }}</span>
      </a>
      <ul class="dropdown-menu dropdown-menu-end bg-dark text-white" aria-labelledby="profileDropdown">
        <li><a class="dropdown-item text-white" href="#"><i class="mdi mdi-cached me-2 text-success"></i> Activity Log</a></li>
        <li><hr class="dropdown-divider"></li>
        <li>
          <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button class="dropdown-item text-white" type="submit"><i class="mdi mdi-logout me-2 text-primary"></i> Sign Out</button>
          </form>
        </li>
      </ul>
    </li>

    <!-- Fullscreen Icon -->
    <li class="nav-item d-none d-lg-block">
      <a class="nav-link text-white" href="#"><i class="mdi mdi-fullscreen fs-4"></i></a>
    </li>
  </ul>
</nav>


    <!-- SIDEBAR -->
    <div class="container-fluid page-body-wrapper">
  <nav class="sidebar sidebar-offcanvas" id="sidebar">
  <ul class="nav">
    <li class="nav-item">
      <a class="nav-link" href="{{ route('admin.dashboard') }}">
  <i class="mdi mdi-home menu-icon"></i>
  <span class="menu-title">Dashboard</span>
</a>

    </li>
    <li class="nav-item">
      <a class="nav-link" href="#" id="load-all-apps">
        <i class="mdi mdi-account-multiple menu-icon"></i>
        <span class="menu-title">All Applications</span>
      </a>
    </li>
    <li class="nav-item">
      <a class="nav-link" href="#" id="load-approved">
        <i class="mdi mdi-check-circle menu-icon"></i>
        <span class="menu-title">Approved Applications</span>
      </a>
    </li>
    <li class="nav-item">
      <a class="nav-link" href="#" id="load-pending">
        <i class="mdi mdi-clock menu-icon"></i>
        <span class="menu-title">Pending Applications</span>
      </a>
    </li>
    <li class="nav-item">
      <a class="nav-link" href="#" id="load-invalid">
        <i class="mdi mdi-close-circle menu-icon"></i>
        <span class="menu-title">Unrecognised Applications</span>
      </a>
    </li>
    <li class="nav-item">
      <a class="nav-link" href="#" id="load-users">
        <i class="mdi mdi-account-multiple menu-icon"></i>
        <span class="menu-title">User Management</span>
      </a>
    </li>
  </ul>
</nav>


      <!-- MAIN PANEL -->
      <div class="main-panel">
        <div class="content-wrapper">
          <div class="page-header">
            <h3 class="page-title">
              <span class="page-title-icon text-white me-2" style="background-color:#8c0378;">
                <i class="mdi mdi-home"></i>
              </span>
              Dashboard
            </h3>
          </div>

          <div class="row">
            <!-- New Applications -->
            <div class="col-md-3 stretch-card grid-margin">
              <div class="card card-img-holder text-white" style="background-color:#d6a7d9">
                <div class="card-body">
                  <img src="{{ asset('assets/images/dashboard/circle.svg') }}" class="card-img-absolute" alt="circle-image" />
                  <h4 class="font-weight-normal mb-3">New Applications <i class="mdi mdi-file-document mdi-24px float-end"></i></h4>
                  <h2 class="mb-5">{{ $newApplications }}</h2>
                  <h6 class="card-text">Received this week</h6>
                </div>
              </div>
            </div>

            <!-- Completed Applications -->
            <div class="col-md-3 stretch-card grid-margin">
              <div class="card bg-gradient-info card-img-holder text-white">
                <div class="card-body">
                  <img src="{{ asset('assets/images/dashboard/circle.svg') }}" class="card-img-absolute" alt="circle-image" />
                  <h4 class="font-weight-normal mb-3">Completed Applications <i class="mdi mdi-check-circle mdi-24px float-end"></i></h4>
                  <h2 class="mb-5">{{ $completedApplications }}</h2>
                  <h6 class="card-text">Processed successfully</h6>
                </div>
              </div>
            </div>

            <!-- Approved Applications -->
            <div class="col-md-3 stretch-card grid-margin">
              <div class="card bg-gradient-success card-img-holder text-white">
                <div class="card-body">
                  <img src="{{ asset('assets/images/dashboard/circle.svg') }}" class="card-img-absolute" alt="circle-image" />
                  <h4 class="font-weight-normal mb-3">Approved Applications <i class="mdi mdi-thumb-up mdi-24px float-end"></i></h4>
                  <h2 class="mb-5">{{ $approvedApplications }}</h2>
                  <h6 class="card-text">Approved this month</h6>
                </div>
              </div>
            </div>

            <!-- Rejected Applications -->
            <div class="col-md-3 stretch-card grid-margin">
              <div class="card bg-gradient-warning card-img-holder text-white">
                <div class="card-body">
                  <img src="{{ asset('assets/images/dashboard/circle.svg') }}" class="card-img-absolute" alt="circle-image" />
                  <h4 class="font-weight-normal mb-3">Rejected Applications <i class="mdi mdi-thumb-down mdi-24px float-end"></i></h4>
                  <h2 class="mb-5">{{ $rejectedApplications }}</h2>
                  <h6 class="card-text">Rejected this month</h6>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div> <!-- End main panel -->
    </div> <!-- End page-body-wrapper -->
  </div> <!-- End container-scroller -->

  <!-- JavaScript -->
  <script src="{{ asset('assets/vendors/js/vendor.bundle.base.js') }}"></script>
  <script src="{{ asset('assets/vendors/chart.js/chart.umd.js') }}"></script>
  <script src="{{ asset('assets/js/dashboard.js') }}"></script>
  <script src="{{ asset('assets/vendors/bootstrap-datepicker/bootstrap-datepicker.min.js') }}"></script>

  @include('partials.footer')
  <!-- Before </body> -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<!-- Bootstrap 5.3 Bundle JS (includes Popper) -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-9ndCyUa6mYbry3Xn7dQWzE7t27Uy2LmM3C0zHNT95+Y9wFZT+Nf76f+Jp1wHg+nG" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="..." crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.min.js" integrity="..." crossorigin="anonymous"></script>
<script>
$(document).ready(function () {
    function loadToMainPanel(route) {
        $.ajax({
            url: route,
            method: 'GET',
            success: function (response) {
                $('.main-panel').html(response);
            },
            error: function (xhr) {
                alert('Failed to load content.');
                console.error(xhr.responseText);
            }
        });
    }

    $('#load-dashboard').click(function (e) {
        e.preventDefault();
        loadToMainPanel('/admin/dashboard');
    });

    $('#load-all-apps').click(function (e) {
        e.preventDefault();
        loadToMainPanel('/applicants');
    });

    $('#load-approved').click(function (e) {
        e.preventDefault();
        loadToMainPanel('/applicants/validated');
    });

    $('#load-pending').click(function (e) {
        e.preventDefault();
        loadToMainPanel('/applicants/pending');
    });

    $('#load-invalid').click(function (e) {
        e.preventDefault();
        loadToMainPanel('/applicants/invalid');
    });

    $('#load-users').click(function (e) {
        e.preventDefault();
        loadToMainPanel('/admin/users');
    });
});
</script>




  <script>


  $('#load-apply').on('click', function (e) {
          e.preventDefault();
  
          $.ajax({
              url: '/personal-info',
              method: 'GET',
              success: function (response) {
                  $('.main-panel').html(response);
              },
              error: function (xhr) {
                  alert('Error loading personal info.');
                  console.error(xhr.responseText);
              }
          });
      });
  
  </script>
</body>