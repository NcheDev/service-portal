<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>NCHE User Dashboard</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://cdn.materialdesignicons.com/5.4.55/css/materialdesignicons.min.css">
  <style>
    
    body {
      margin: 0;
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      background-color: #f5f7fa;
    }

    .navbar {
      background-color: #fff;
      box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
      z-index: 1000;
    }

    .navbar .navbar-brand img {
      height: 60px;
    }

    .sidebar {
      width: 250px;
      background-color: #52074f;
      height: 100vh;
      position: fixed;
      top: 0;
      left: 0;
      overflow-y: auto;
      padding-top: 80px;
    }

    .sidebar .nav-link {
      color: #fff;
      padding: 0.9rem 1.25rem;
      display: flex;
      align-items: center;
    }

    .sidebar .nav-link:hover {
      background-color: #dd8027;
      color: #fff;
    }

    .sidebar .menu-icon {
      margin-right: 10px;
    }

    .main-panel {
      margin-left: 250px;
      padding: 2rem;
    }

    .dropdown-menu {
      right: 0;
      left: auto;
    }

    .profile-pic {
      width: 40px;
      height: 40px;
      object-fit: cover;
      border-radius: 50%;
      margin-right: 10px;
    }
  </style>
</head>

<body>
  <!-- Navbar -->
  <nav class="navbar fixed-top navbar-light bg-white px-3">
    <a class="navbar-brand" href="#">
      <img src="/assets/images/logo1.png" alt="NCHE Logo">
    </a>
    <div class="d-flex align-items-center ms-auto">
      <div class="dropdown">
        <a class="d-flex align-items-center nav-link dropdown-toggle" id="profileDropdown" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
          <img src="{{ Auth::user()->personalInfo?->profile_picture ? Storage::url(Auth::user()->personalInfo->profile_picture) : 'https://via.placeholder.com/180' }}" class="profile-pic" alt="">
          <span>Hello {{ Auth::user()->name }}</span>
        </a>
        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="profileDropdown">
          <li>
            <form id="logout-form" action="{{ route('logout') }}" method="POST">
              @csrf
              <button class="dropdown-item" type="submit">
                <i class="mdi mdi-logout me-2 text-primary"></i> Sign Out
              </button>
            </form>
          </li>
        </ul>
      </div>
    </div>
  </nav>

  <!-- Sidebar -->
  <nav class="sidebar d-flex flex-column">
   <a href="#" class="nav-link load-apply">
  <i class="mdi mdi-home menu-icon"></i>
  Dashboard
</a>

<a href="#" class="nav-link load-apply">
  <i class="mdi mdi-contacts menu-icon"></i>
  Personal Info
</a>

   <a href="{{ route('application.create') }}" class="nav-link ajax-link">
  <i class="mdi mdi-school menu-icon"></i>
  Apply
</a>
<a href="{{ route('applications.my') }}" class="nav-link ajax-link">
  <i class="mdi mdi-school menu-icon"></i>
  My Applications
</a>

<a href="{{ route('invoices.index') }}" class="nav-link ajax-link">
  <i class="mdi mdi-credit-card menu-icon"></i>
  My Payments
</a>

   <a href="#" class="nav-link load-documentation">
  <i class="mdi mdi-file-document menu-icon"></i>
  Documentation
</a>
    <a href="{{ route('faq') }}" class="nav-link ajax-link">
  <i class="mdi mdi-help-circle menu-icon"></i>
  FAQ
</a>

    <a class="nav-link nav-link-help" href="#" id="load-help">
  <i class="mdi mdi-help-circle menu-icon"></i>
  Help
</a>

  </nav>

  <!-- Main Panel -->
  <main class="main-panel">
    <div class="text-center py-5">
      <div class="spinner-border text-warning" role="status">
        <span class="visually-hidden">Loading...</span>
      </div>
      <p class="mt-3">Loading dashboard...</p>
    </div>
  </main>

  <!-- Scripts -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script>
  $(document).ready(function () {
    function loadPanel(url) {
      $.get(url, function (response) {
        $('.main-panel').html(response);
      }).fail(function () {
        alert('Failed to load content.');
      });
    }

    // For Personal Info (class-based)
    $('.load-apply').on('click', function (e) {
      e.preventDefault();
      loadPanel('/personal-info');
    });

    // For Documentation (class-based)
    $('.load-documentation').on('click', function (e) {
      e.preventDefault();
      loadPanel('/documentation');
    });

    // Optional: Load default panel on page load
    loadPanel('/personal-info');
  });
</script>

  <script>
  $(document).ready(function() {
    // Intercept clicks on links with class .ajax-link
    $('.ajax-link').on('click', function(e) {
      e.preventDefault(); // Prevent full page reload
      
      let url = $(this).attr('href');
      
      // Optionally: Show a loading indicator in .main-panel
      $('.main-panel').html('<p>Loading...</p>');

      // Load content via AJAX
      $.ajax({
        url: url,
        method: 'GET',
        success: function(response) {
          $('.main-panel').html(response);
        },
        error: function() {
          alert('Failed to load content.');
        }
      });
    });
  });
</script>
<script>


  function loadPanel(url) {
    $.get(url, function(response) {
        $('.main-panel').html(response);
        initProcessingFeeScript(); // Initialize your script here
    }).fail(function() {
        alert('Failed to load content.');
    });
}

</script>

<script>
$(document).ready(function () {
    // Load AJAX content into .main-panel
    $(document).on('click', '.ajax-link', function (e) {
        e.preventDefault();

        const url = $(this).attr('href');

        // Show loading spinner or message
        $('.main-panel').html(`
            <div class="text-center py-5">
                <div class="spinner-border text-warning" role="status">
                    <span class="visually-hidden">Loading...</span>
                </div>
                <p class="mt-3">Loading...</p>
            </div>
        `);

        // Load the content
        $.get(url, function (response) {
            $('.main-panel').html(response);
        }).fail(function () {
            $('.main-panel').html('<div class="alert alert-danger">Failed to load content.</div>');
        });
    });
});
</script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(document).ready(function () {
  function loadPanel(url) {
    $.get(url, function (response) {
      $('.main-panel').html(response);
    }).fail(function () {
      alert('Failed to load content.');
    });
  }

  // Attach click event for all links with class ajax-link
  $('.ajax-link').on('click', function (e) {
    e.preventDefault();
    const url = $(this).attr('href');
    loadPanel(url);
  });

  // Optionally, load a default panel on page load
  loadPanel('/personal-info');
});
</script>
<script>
$(document).ready(function () {
    function loadPanel(url) {
        $.get(url, function(response) {
            $('.main-panel').html(response);
        }).fail(function () {
            alert('Failed to load content.');
        });
    }

  

    // Handle all ajax-link clicks
    $('.ajax-link').on('click', function (e) {
        e.preventDefault();
        const url = $(this).attr('href');
        loadPanel(url);
    });
});
</script>

<script>
  $('.nav-link-help').on('click', function (e) {
    e.preventDefault();
    $.get('/help', function (response) {
        $('.main-panel').html(response);
    });
});

</script>
</body>

</html>
