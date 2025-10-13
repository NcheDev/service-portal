<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>@yield('title', 'NCHE Admin Dashboard')</title>

  <!-- Bootstrap 5 & Material Design Icons -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://cdn.materialdesignicons.com/6.6.96/css/materialdesignicons.min.css">
  <link rel="icon" href="{{ asset('assets/images/logo2.png') }}" type="image/png">
<style>
/* Body */
body {
  margin: 0;
  font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
  background-color: #f5f7fa;
}

/* Navbar */
.navbar {
  background-color: #52074f !important;
  z-index: 1100;
  padding: 0.25rem 1rem;
  border-bottom: 5px solid #dd8027;
  display: flex;
  justify-content: space-between;
  align-items: center;
}

/* Navbar Left */
.navbar-left {
  display: flex;
  align-items: center;
  gap: 0.75rem;
}

/* Navbar Right */
.navbar-right {
  display: flex;
  align-items: center;
  gap: 1rem;
}

/* Logo */
.navbar-brand img {
  height: 35px;
}

/* Navbar links */
.navbar .nav-link {
  color: #fff !important;
  display: flex;
  align-items: center;
}


/* Sidebar */
.sidebar {
  background-color: #52074f !important;
  color: white;
  position: fixed;
  top: 58px;
  left: 0;
  width: 250px;
  height: calc(100vh - 56px);
  overflow-y: auto;
  transition: left 0.3s ease;
  z-index: 1030;
  box-shadow: 2px 0 5px rgba(0,0,0,0.1);
}

.sidebar a.nav-link {
  color: white !important;
  padding: 0.9rem 1.25rem;
  display: flex;
  align-items: center;
}

.sidebar a.nav-link:hover {
  background-color: #52074f !important;
  color: white !important;
}

/* Main Panel */
.main-panel {
  margin-left: 250px;
  margin-top: 62px;
  padding: 1.5rem;
  min-height: calc(100vh - 62px);
}

/* Profile Picture */
.profile-pic {
  width: 40px;
  height: 40px;
  border-radius: 50%;
  object-fit: cover;
  margin-right: 8px;
  border: 2px solid #52074f;
}/* Notifications dropdown */
.dropdown-menu {
  max-height: 60vh;
  overflow-y: auto;
  min-width: 260px;
  border-radius: 10px;
  border: none;
  box-shadow: 0 2px 10px rgba(0,0,0,0.15);
}

/* Mobile Adjustments */
@media (max-width: 992px) {
  /* Sidebar behavior */
  .sidebar { 
    left: -250px; 
  }
  .sidebar.show { 
    left: 0; 
  }
  .main-panel { 
    margin-left: 0 !important; 
  }

  /* Navbar adjustments */
  .navbar {
    flex-wrap: wrap;
    padding: 0.4rem 0.8rem;
  }

  .navbar-brand img {
    height: 30px;
  }

  .profile-pic {
    width: 30px;
    height: 30px;
  }

  .navbar .nav-link span {
    display: none; /* hide username on small screens */
  }

  .mdi {
    font-size: 1.2rem;
  }

  /* Notifications dropdown fix */
  .dropdown-menu {
    position: absolute !important;
    right: 10px !important;
    left: auto !important;
    width: 85vw !important;   /* responsive width */
    max-width: 280px !important; /* don’t overflow small screens */
    transform: none !important;
  }
}

@media (max-width: 576px) {
  .sidebar { 
    width: 200px; 
  }
  .main-panel { 
    margin-left: 0 !important; 
  }

  /* Adjust dropdown more tightly for phones */
  .dropdown-menu {
    width: 90vw !important;
    max-width: 250px !important;
    right: 5px !important;
    font-size: 0.7rem;
  }

  /* Smaller elements inside navbar */
  .profile-pic {
    width: 30px;
    height: 30px;
  }

  .navbar-brand img {
    height: 30px;
  }

  .navbar .nav-link span {
    display: none; /* hide username */
  }

  .mdi {
    font-size: 1.3rem;
  }
}


@media (max-width: 576px) {
  .sidebar { width: 200px; }
  .main-panel { margin-left: 0 !important; }
}
</style>
</head>
<body>

 <!-- NAVBAR -->
<nav class="navbar fixed-top navbar-dark shadow-sm">
  <!-- LEFT: Logo + Sidebar Toggle -->
  <div class="navbar-left">
    <a class="navbar-brand" href="{{ url('/') }}">
      <img src="{{ asset('assets/images/logo1.png') }}" alt="Logo">
    </a>

    <!-- Mobile Sidebar Toggle -->
    <button class="btn btn-outline-light d-lg-none" id="toggleSidebar">
      <i class="mdi mdi-menu"></i>
    </button>
  </div>

  <!-- RIGHT: Notifications + Profile -->
  <div class="navbar-right">

    <!-- Notifications -->
    <li class="nav-item dropdown list-unstyled">
      @php $unread = auth()->user()->unreadNotifications->count(); @endphp
      <a class="nav-link position-relative" href="#" id="notificationsDropdown" role="button" data-bs-toggle="dropdown">
        <i class="mdi mdi-bell fs-4 text-white"></i>
        @if($unread)
          <span class="badge bg-danger position-absolute top-0 start-100 translate-middle rounded-pill">{{ $unread }}</span>
        @endif
      </a>
      <ul class="dropdown-menu dropdown-menu-end p-2 shadow-sm" aria-labelledby="notificationsDropdown">
        @forelse(auth()->user()->unreadNotifications as $notification)
          @php
            $message = is_array($notification->data['message'] ?? null)
              ? implode(', ', $notification->data['message'])
              : ($notification->data['message'] ?? 'No message');
          @endphp
          <li class="border-bottom mb-1">
            <a href="{{ $notification->data['url'] ?? '#' }}" class="dropdown-item small">
              <span class="text-truncate" style="max-width: 250px;">{{ $message }}</span>
              <small class="text-muted">{{ $notification->created_at->diffForHumans() }}</small>
            </a>
          </li>
        @empty
          <li><span class="dropdown-item small text-muted">No new notifications</span></li>
        @endforelse
      </ul>
    </li>

    <!-- Profile Dropdown -->
    <li class="nav-item dropdown list-unstyled">
      <a class="nav-link dropdown-toggle d-flex align-items-center" href="#" id="profileDropdown" role="button" data-bs-toggle="dropdown">
        <img src="{{ Auth::user()->personalInfo?->profile_picture ? Storage::url(Auth::user()->personalInfo->profile_picture) : 'https://via.placeholder.com/180' }}" class="profile-pic">
        <span class="text-white fw-semibold">Hello {{ Auth::user()->name }}</span>
      </a>
      <ul class="dropdown-menu dropdown-menu-end">
        <li>
          <a class="dropdown-item" href="{{ route('audit.index') }}">
            <i class="mdi mdi-cached me-2 text-success"></i> Activity Log
          </a>
        </li>
        <li><hr class="dropdown-divider"></li>
        <li>
          <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button class="dropdown-item text-danger" type="submit">
              <i class="mdi mdi-logout me-2"></i> Sign Out
            </button>
          </form>
        </li>
      </ul>
    </li>

  </div>
</nav>

  <!-- SIDEBAR -->
  <nav class="sidebar" id="sidebarMenu">
    <ul class="nav flex-column">
      <li class="nav-item">
        <a class="nav-link" href="{{ route('admin.dashboard') }}">
          <i class="mdi mdi-home menu-icon me-2"></i> Dashboard
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="{{ route('admin.applicants.all') }}">
          <i class="mdi mdi-account-multiple menu-icon me-2"></i> All Applications
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="{{ route('admin.applicants.validated') }}">
          <i class="mdi mdi-check-circle menu-icon me-2"></i> Approved Applications
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="{{ route('admin.applicants.pending') }}">
          <i class="mdi mdi-clock menu-icon me-2"></i> Pending Applications
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="{{ route('admin.applicants.invalid') }}">
          <i class="mdi mdi-close-circle menu-icon me-2"></i> Unrecognised Applications
        </a>
      </li> 
      <li class="nav-item">
        <a class="nav-link" href="{{ route('admin.users.index') }}">
          <i class="mdi mdi-account-multiple menu-icon me-2"></i> User Management
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="{{ route('audit.index') }}">
          <i class="mdi mdi-cached menu-icon text-success me-2"></i> Activity Log
        </a>
      </li>
    </ul>
  </nav>

  <!-- MAIN PANEL -->
  <main class="main-panel">
    @yield('content')
  </main>

  <!-- Scripts -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
 <script>
  // Toggle sidebar for mobile
  document.getElementById('toggleSidebar').addEventListener('click', function() {
    document.getElementById('sidebarMenu').classList.toggle('show');
  });
</script>

</body>
</html>
