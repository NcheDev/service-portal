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
    {{-- Big logo - only visible on large screens and up --}}
<a class="navbar-brand d-none d-lg-block" href="{{ url('/') }}">
  <img src="{{ asset('assets/images/logo1.png') }}" alt="Logo" style="height: 50px;">
</a>

{{-- Mini logo - only visible on small and medium screens --}}
<a class="navbar-brand d-lg-none" href="{{ url('/') }}">
  <img src="{{ asset('assets/images/logo1.png') }}" alt="Mini Logo" style="height: 30px;">
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
     
    <!-- Profile Dropdown -->
    <li class="nav-item dropdown">
      <a class="nav-link dropdown-toggle d-flex align-items-center" href="#" id="profileDropdown" role="button" data-bs-toggle="dropdown">
        <span class="text-white fw-semibold">Hello {{ Auth::user()->name }}</span>
      </a>
      <ul class="dropdown-menu dropdown-menu-end bg-dark text-white" aria-labelledby="profileDropdown">
<li>
    <a class="dropdown-item text-white ajax-link" href="#" data-url="{{ route('audit.index') }}">
        <i class="mdi mdi-cached me-2 text-success"></i> Activity Log
    </a>
</li>
        <li><hr class="dropdown-divider"></li>
        <li>
          <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button class="dropdown-item text-white" type="submit"><i class="mdi mdi-logout me-2 text-primary"></i> Sign Out</button>
          </form>
        </li>
      </ul>
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
    <li class="nav-item">
    <a class="nav-link ajax-link" href="#" data-url="{{ route('audit.index') }}" id="activity-log-link">
        <i class="mdi mdi-cached menu-icon text-success"></i>
        <span class="menu-title">Activity Log</span>
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
<div class="row row-cols-1 row-cols-sm-2 row-cols-lg-4 g-4">
  <!-- New Applications -->
  <div class="col">
    <div class="card text-white h-100" style="background-color:#d6a7d9">
      <div class="card-body position-relative">
        <img src="{{ asset('assets/images/dashboard/circle.svg') }}" class="card-img-absolute" alt="circle-image" />
        <h4 class="mb-3">New Applications <i class="mdi mdi-file-document float-end"></i></h4>
        <h2 class="mb-4">{{ $newApplications }}</h2>
        <p class="card-text">Received this week</p>
      </div>
    </div>
  </div>

  <!-- Completed Applications -->
  <div class="col">
    <div class="card bg-gradient-info text-white h-100">
      <div class="card-body position-relative">
        <img src="{{ asset('assets/images/dashboard/circle.svg') }}" class="card-img-absolute" alt="circle-image" />
        <h4 class="mb-3">Completed Applications <i class="mdi mdi-check-circle float-end"></i></h4>
        <h2 class="mb-4">{{ $completedApplications }}</h2>
        <p class="card-text">Processed successfully</p>
      </div>
    </div>
  </div>

  <!-- Approved Applications -->
  <div class="col">
    <div class="card bg-gradient-success text-white h-100">
      <div class="card-body position-relative">
        <img src="{{ asset('assets/images/dashboard/circle.svg') }}" class="card-img-absolute" alt="circle-image" />
        <h4 class="mb-3">Approved Applications <i class="mdi mdi-thumb-up float-end"></i></h4>
        <h2 class="mb-4">{{ $approvedApplications }}</h2>
        <p class="card-text">Approved this month</p>
      </div>
    </div>
  </div>

  <!-- Rejected Applications -->
  <div class="col">
    <div class="card bg-gradient-warning text-white h-100">
      <div class="card-body position-relative">
        <img src="{{ asset('assets/images/dashboard/circle.svg') }}" class="card-img-absolute" alt="circle-image" />
        <h4 class="mb-3">Rejected Applications <i class="mdi mdi-thumb-down float-end"></i></h4>
        <h2 class="mb-4">{{ $rejectedApplications }}</h2>
        <p class="card-text">Rejected this month</p>
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
  
  <!-- Add this spinner element somewhere in your blade, e.g. right inside .main-panel container -->
<div id="loadingSpinner" style="display:none; position:fixed; top:50%; left:50%; transform: translate(-50%, -50%);
     z-index:1050;" class="spinner-border text-primary" role="status">
  <span class="visually-hidden">Loading...</span>
</div>
<script>
document.addEventListener('DOMContentLoaded', function() {
  const csrfToken = document.querySelector('meta[name="csrf-token"]').content;

  document.addEventListener('submit', async function(e) {
    const form = e.target;
    if (!form.classList.contains('ajax-form')) return;

    e.preventDefault();

    // Show a loading state if you like...
    const submitBtn = form.querySelector('button[type="submit"]');
    submitBtn.disabled = true;

    // Build form data
    const data = new FormData(form);

    try {
      const res = await fetch(form.action, {
        method: form.method.toUpperCase(),
        headers: {
          'X-CSRF-TOKEN': csrfToken,
          'X-Requested-With': 'XMLHttpRequest'
        },
        body: data
      });
      if (!res.ok) throw new Error(await res.text());

      const json = await res.json();
      // Replace the dashboard panel with refreshed HTML
      document.querySelector('.main-panel').innerHTML = json.html;

      // Re‑show any toasts in the newly injected HTML
      document.querySelectorAll('.toast').forEach(t => new bootstrap.Toast(t).show());
    } catch (err) {
      console.error(err);
      alert('Failed to update. See console for details.');
    } finally {
      submitBtn.disabled = false;
    }
  });
});
</script>
<script>
$('.ajax-link').on('click', function (e) {
    e.preventDefault();
    let url = $(this).data('url');
    $.get(url, function (data) {
        $('.main-panel').html(data);
    });
});
</script>
<script>
document.addEventListener('DOMContentLoaded', function () {
    document.querySelectorAll('.ajax-link').forEach(link => {
        link.addEventListener('click', function (e) {
            e.preventDefault();
            const url = this.dataset.url;

            fetch(url)
                .then(res => res.text())
                .then(html => {
                    document.querySelector('.main-panel').innerHTML = html;
                    window.history.pushState(null, '', url);
                })
                .catch(err => console.error('Failed to load content:', err));
        });
    });
});
</script>

</body>