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
      z-index: 1100;
    }

    .navbar .navbar-brand img {
      height: 60px;
    }

  .sidebar {
  position: fixed;
  top: 70px; /* or match navbar height (e.g., 56px or 60px if your logo is taller) */
  left: 0;
  height: calc(100vh - 70px); /* subtract navbar height */
  width: 250px;
  background-color: #52074f !important;
  color: white;
  overflow-y: auto;
  padding-top: 1rem;
  box-sizing: border-box;
  z-index: 1020; /* lower than navbar, but enough to be on top of content */
}

.sidebar nav, .sidebar > div, .sidebar > a:first-child {
  padding-top: 0.5rem;
}

.main-panel {
  margin-left: 250px;
  padding: 1.5rem;
  margin-top: 70px; /* match navbar height */
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

    /* Responsive Behavior */
    @media (max-width: 992px) {
      .sidebar {
        left: -250px;
      }

      .sidebar.show-sidebar {
        left: 0;
      }

      .main-panel {
        margin-left: 0 !important;
        padding: 1rem;
      }
    }
  </style>
</head>

<body>
  <!-- Navbar -->
<nav class="navbar fixed-top navbar-light bg-black px-3 d-flex align-items-center shadow-sm">
    <!-- Sidebar Toggle Button (small screens) -->
    <button class="btn btn-outline-light d-lg-none me-2" id="toggleSidebar" type="button" aria-label="Toggle sidebar">
        <i class="mdi mdi-menu"></i>
    </button>

    <!-- Logo -->
    <a class="navbar-brand" href="#">
        <img src="/assets/images/logo1.png" alt="NCHE Logo" height="40">
    </a>

    <!-- Right side -->
    <div class="ms-auto d-flex align-items-center">

        <!-- Notifications -->
   <li class="nav-item dropdown"> 
    @php $unread = auth()->user()->unreadNotifications->count(); @endphp
    <a class="nav-link position-relative {{ $unread ? 'ring' : '' }}" href="#" id="notificationsDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
        <i class="bi bi-bell fs-4 text-white"></i>
        @if($unread)
            <span class="badge bg-danger position-absolute top-0 start-100 translate-middle rounded-pill">
                {{ $unread }}
            </span>
        @endif
    </a>

    <ul class="dropdown-menu dropdown-menu-end p-2" aria-labelledby="notificationsDropdown" style="min-width: 300px;">
        @forelse(auth()->user()->unreadNotifications as $notification)
            <li class="border-bottom mb-1">
                <a class="dropdown-item small d-flex flex-column" 
                   href="{{ route('notifications.read', $notification->id) }}">
                    <span class="text-truncate" style="max-width: 250px;">
                        {{ is_array($notification->data['message']) 
                            ? implode(', ', $notification->data['message']) 
                            : $notification->data['message'] }}
                    </span>
                    <small class="text-muted">{{ $notification->created_at->diffForHumans() }}</small>
                </a>
            </li>
        @empty
            <li><span class="dropdown-item small text-muted">No new notifications</span></li>
        @endforelse
    </ul>
    
</li>


        <!-- Profile -->
        @auth
        <div class="dropdown">
            <a class="d-flex align-items-center nav-link dropdown-toggle text-white" id="profileDropdown" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                <img src="{{ Auth::user()->personalInfo?->profile_picture ? Storage::url(Auth::user()->personalInfo->profile_picture) : 'https://via.placeholder.com/180' }}" class="profile-pic rounded-circle" alt="Profile Picture" style="width:40px; height:40px; object-fit:cover; margin-right:10px;">
                <span>Hello, {{ Auth::user()->name }}</span>
            </a>

            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="profileDropdown">
                <li>
                    <a href="#" class="dropdown-item d-flex align-items-center">
                        <i class="mdi mdi-account me-2 text-primary"></i> Profile
                    </a>
                </li>
                <li>
                    <a href="#" class="dropdown-item d-flex align-items-center"
                       onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        <i class="mdi mdi-logout me-2 text-danger"></i> Sign Out
                    </a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                        @csrf
                    </form>
                </li>
            </ul>
        </div>
        @endauth

    </div>
</nav>


<!-- Include MDI and Bootstrap -->
<link href="https://cdn.materialdesignicons.com/6.6.96/css/materialdesignicons.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<style>
    .navbar .profile-pic {
        border: 2px solid #52074f;
    }
</style>


  <!-- Main Layout Wrapper -->
  <div class="d-flex" id="layout" style="padding-top: 56px;">
    <!-- Sidebar -->
    <nav class="sidebar bg-dark text-white d-lg-block position-fixed" id="sidebarMenu" style="width: 250px; height: 100vh; overflow-y: auto; top: 56px; left: 0; transition: left 0.3s ease;">
      <a href="#" class="nav-link load-apply text-white px-3 py-2 d-flex align-items-center">
        <i class="mdi mdi-home menu-icon me-2"></i>Dashboard
      </a>
      <a href="#" class="nav-link load-apply text-white px-3 py-2 d-flex align-items-center">
        <i class="mdi mdi-contacts menu-icon me-2"></i>Personal Info
      </a>
      <a href="{{ route('application.create') }}" class="nav-link ajax-link text-white px-3 py-2 d-flex align-items-center">
        <i class="mdi mdi-school menu-icon me-2"></i>Apply
      </a>
      <a href="{{ route('applications.my') }}" class="nav-link ajax-link text-white px-3 py-2 d-flex align-items-center">
        <i class="mdi mdi-school menu-icon me-2"></i>My Applications
      </a>
      <a href="{{ route('invoices.index') }}" class="nav-link ajax-link text-white px-3 py-2 d-flex align-items-center">
        <i class="mdi mdi-credit-card menu-icon me-2"></i>My Payments
      </a>
      <a href="#" class="nav-link load-documentation text-white px-3 py-2 d-flex align-items-center">
        <i class="mdi mdi-file-document menu-icon me-2"></i>Documentation
      </a>
      <a href="{{ route('faq') }}" class="nav-link ajax-link text-white px-3 py-2 d-flex align-items-center">
        <i class="mdi mdi-help-circle menu-icon me-2"></i>FAQ
      </a>
      <a href="#" class="nav-link nav-link-help text-white px-3 py-2 d-flex align-items-center" id="load-help">
        <i class="mdi mdi-help-circle menu-icon me-2"></i>Help
      </a>
    </nav>

    <!-- Main Panel -->
    <main class="main-panel flex-grow-1" style="margin-left: 250px; padding: 1.5rem;">
      <div class="text-center py-5">
        <div class="spinner-border text-warning" role="status">
          <span class="visually-hidden">Loading...</span>
        </div>
        <p class="mt-3">Loading dashboard...</p>
      </div>
    </main>
  </div>

  <!-- Scripts -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
  <script>
    document.addEventListener('DOMContentLoaded', function () {
      const toggleSidebarBtn = document.getElementById('toggleSidebar');
      const sidebar = document.getElementById('sidebarMenu');
      const mainPanel = document.querySelector('.main-panel');

      toggleSidebarBtn.addEventListener('click', function () {
        if (sidebar.style.left === '0px') {
          sidebar.style.left = '-250px';
          mainPanel.style.marginLeft = '0';
        } else {
          sidebar.style.left = '0px';
          mainPanel.style.marginLeft = '250px';
        }
      });

      // Auto-close sidebar on link click when on small screens
      sidebar.querySelectorAll('a.nav-link').forEach(link => {
        link.addEventListener('click', () => {
          if (window.innerWidth < 992) {
            sidebar.style.left = '-250px';
            mainPanel.style.marginLeft = '0';
          }
        });
      });

      // Optional: on window resize, reset sidebar for large screens
      window.addEventListener('resize', () => {
        if (window.innerWidth >= 992) {
          sidebar.style.left = '0px';
          mainPanel.style.marginLeft = '250px';
        } else {
          sidebar.style.left = '-250px';
          mainPanel.style.marginLeft = '0';
        }
      });

      // Initialize sidebar state on page load
      if (window.innerWidth >= 992) {
        sidebar.style.left = '0px';
        mainPanel.style.marginLeft = '250px';
      } else {
        sidebar.style.left = '-250px';
        mainPanel.style.marginLeft = '0';
      }
    });
  </script>

  <style>
   .sidebar {
  background-color: #52074f !important;  /* Force NCHE purple */
  color: white;
  position: fixed;
  top: 56px;           /* Push below fixed navbar */
  left: 0;
  width: 250px;
  height: calc(100vh - 56px);  /* Full height minus navbar */
  overflow-y: auto;
  box-sizing: border-box;
  transition: left 0.3s ease;
  z-index: 1030; /* below navbar z-index 1040 or 1050 */
}

.sidebar a.nav-link {
  color: white !important;
}

.sidebar a.nav-link:hover {
  background-color: #dd8027 !important;
  color: white !important;
}
.main-panel {
  margin-left: 250px;
  padding: 1.5rem;
  margin-top: 56px;  /* So content doesn’t go under navbar */
  min-height: calc(100vh - 56px);
}

  </style>
</body>

  <!-- Scripts -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

  <script>
    // Sidebar toggle
    document.getElementById('toggleSidebar').addEventListener('click', function () {
      document.getElementById('sidebarMenu').classList.toggle('show-sidebar');
    });
  </script>

  <script>
    $(document).ready(function () {
      function loadPanel(url) {
        $.get(url, function (response) {
          $('.main-panel').html(response);
        }).fail(function () {
          $('.main-panel').html('<div class="alert alert-danger">Failed to load content.</div>');
        });
      }

      // Load personal info on page load
      loadPanel('/personal-info');

      // AJAX load for dashboard or static content
      $('.load-apply').on('click', function (e) {
        e.preventDefault();
        loadPanel('/personal-info');
      });

      $('.load-documentation').on('click', function (e) {
        e.preventDefault();
        loadPanel('/documentation');
      });

      // AJAX links
      $('.ajax-link').on('click', function (e) {
        e.preventDefault();
        const url = $(this).attr('href');

        $('.main-panel').html(`
          <div class="text-center py-5">
            <div class="spinner-border text-warning" role="status">
              <span class="visually-hidden">Loading...</span>
            </div>
            <p class="mt-3">Loading...</p>
          </div>
        `);

        $.get(url, function (response) {
          $('.main-panel').html(response);
        }).fail(function () {
          $('.main-panel').html('<div class="alert alert-danger">Failed to load content.</div>');
        });
      });
    });
  </script>
  <script> 
  const toggleBtn = document.getElementById('toggleTopMenu');
  const topMenu = document.getElementById('topMenu');

  toggleBtn.addEventListener('click', function () {
    topMenu.classList.toggle('show');
  });

  // Auto-close on link click (for mobile top nav)
  document.querySelectorAll('#topMenu .nav-link').forEach(link => {
    link.addEventListener('click', () => {
      if (window.innerWidth < 992) {
        topMenu.classList.remove('show');
      }
    });
  });
</script>
</body>

</html>
