<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="csrf-token" content="{{ csrf_token() }}">

  <title>@yield('title', 'NCHE User Dashboard')</title>

  <!-- Bootstrap & Icons -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://cdn.materialdesignicons.com/6.6.96/css/materialdesignicons.min.css">
  <link rel="icon" type="image/png" href="/assets/images/logo1.png" />

  <style>
    body {
      margin: 0;
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      background-color: #f5f7fa;
    }

    /* Navbar */
    .navbar {
      background-color: #52074f !important;
      z-index: 1100;
    }

    .navbar-brand img {
      height: 40px;
    }

    /* Sidebar */
    .sidebar {
      background-color:#dd8027 !important;
      color: white;
      position: fixed;
      top: 56px;
      left: 0;
      width: 250px;
      height: calc(100vh - 56px);
      overflow-y: auto;
      transition: left 0.3s ease;
      z-index: 1030;
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

    /* Main Content */
    .main-panel {
      margin-left: 250px;
      padding: 1.5rem;
      margin-top: 56px;
      min-height: calc(100vh - 56px);
    }

    .profile-pic {
      width: 40px;
      height: 40px;
      border-radius: 50%;
      object-fit: cover;
      margin-right: 10px;
      border: 2px solid #52074f;
    }

    /* Responsive */
    @media (max-width: 992px) {
      .sidebar {
        left: -250px;
      }
      .sidebar.show {
        left: 0;
      }
      .main-panel {
        margin-left: 0 !important;
      }
    }
    @media (max-width: 576px) {
  .dropdown-menu {
    right: -150px !important;  /* 👈 pushes it a little inward from the right edge */
    left: auto !important;   /* disable left alignment */
    width: 70vw !important;  /* narrower than full width */
    max-width: 320px;        /* optional: cap max width */
    transform: none !important; /* remove centering transforms */
  }

  .dropdown-menu a.dropdown-item {
    white-space: normal; /* allow text wrapping */
  }
}

  </style>
</head>

<body>
  <!-- Navbar -->
  <nav class="navbar fixed-top navbar-dark bg-black px-3 shadow-sm">
    <button class="btn btn-outline-light d-lg-none me-2" id="toggleSidebar">
      <i class="mdi mdi-menu"></i>
    </button>

    <a class="navbar-brand" href="{{ route('user.dashboard') }}">
      <img src="/assets/images/logo1.png" alt="NCHE Logo">
    </a>

    <div class="ms-auto d-flex align-items-center">
      <!-- Notifications -->
   <li class="nav-item dropdown list-unstyled me-2 me-lg-3">
  @php $unread = auth()->user()->unreadNotifications->count(); @endphp

  <a class="nav-link position-relative" href="#" id="notificationsDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
    <i class="mdi mdi-bell text-white fs-4"></i>
    @if($unread)
      <span class="badge bg-danger position-absolute top-0 start-100 translate-middle rounded-pill">
        {{ $unread }}
      </span>
    @endif
  </a>

  <ul class="dropdown-menu dropdown-menu-end p-2 shadow-sm"
      aria-labelledby="notificationsDropdown"
      style="max-height: 60vh; overflow-y: auto; width: 90vw; max-width: 320px;">
      
    @forelse(auth()->user()->unreadNotifications as $note)
      <li>
        <a href="#" 
           class="dropdown-item small" 
           data-id="{{ $note->id }}" 
           data-url="{{ $note->data['url'] ?? '/' }}">
          {{ is_array($note->data['message']) ? implode(', ', $note->data['message']) : $note->data['message'] }}
          <br><small class="text-muted">{{ $note->created_at->diffForHumans() }}</small>
        </a>
      </li>
    @empty
      <li><span class="dropdown-item small text-muted text-center">No new notifications</span></li>
    @endforelse
  </ul>
</li>

      <!-- Profile -->
      @auth
      <div class="dropdown">
        <a class="d-flex align-items-center nav-link dropdown-toggle text-white" id="profileDropdown" href="#" data-bs-toggle="dropdown">
          <img src="{{ Auth::user()->personalInfo?->profile_picture ? Storage::url(Auth::user()->personalInfo->profile_picture) : 'https://via.placeholder.com/180' }}" class="profile-pic">
          <span>{{ Auth::user()->name }}</span>
        </a>
        <ul class="dropdown-menu dropdown-menu-end">
          <li><a href="{{ route('user.profile') }}" class="dropdown-item"><i class="mdi mdi-account me-2 text-primary"></i> Profile</a></li>
          <li>
            <a href="#" class="dropdown-item text-danger" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
              <i class="mdi mdi-logout me-2"></i> Sign Out
            </a>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">@csrf</form>
          </li>
        </ul>
      </div>
      @endauth
    </div>
  </nav>

  <!-- Sidebar -->
  <nav class="sidebar" id="sidebarMenu">
    <a href="{{ route('user.dashboard') }}" class="nav-link"><i class="mdi mdi-home menu-icon me-2"></i>Dashboard</a>
    <a href="{{ route('user.personal-info') }}" class="nav-link"><i class="mdi mdi-contacts menu-icon me-2"></i>Applicant Details</a>
    <a href="{{ route('application.create') }}" class="nav-link"><i class="mdi mdi-school menu-icon me-2"></i>Apply</a> 
    <a href="{{ route('faq') }}" class="nav-link"><i class="mdi mdi-help-circle menu-icon me-2"></i>FAQ</a>
  </nav>

  <!-- Main Content -->
  <main class="main-panel">
    @yield('content')
  </main>

  <!-- Scripts -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
  <script>
    document.getElementById('toggleSidebar').addEventListener('click', function () {
      document.getElementById('sidebarMenu').classList.toggle('show');
    });
  </script>

 <script>
document.addEventListener('DOMContentLoaded', function () {
    const token = document.querySelector('meta[name="csrf-token"]')?.content;

    // Select all notification items
    document.querySelectorAll('.dropdown-item[data-id]').forEach(item => {
        item.addEventListener('click', function (e) {
            e.preventDefault();
            const noteId = this.getAttribute('data-id');
            const url = this.getAttribute('data-url') || '/';

            fetch(`/notifications/read/${noteId}`, {
                headers: { 
                    'X-Requested-With': 'XMLHttpRequest',
                    'X-CSRF-TOKEN': token
                },
                method: 'GET'
            })
            .then(res => res.json())
            .then(() => {
                // Optionally hide the notification or decrement badge
                this.remove(); // remove clicked notification from dropdown

                // Redirect to notification link
                window.location.href = url;
            })
            .catch(err => console.error('Error marking notification as read:', err));
        });
    });
});
</script>


</body>
</html>
