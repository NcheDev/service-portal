<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') | Application System</title>

    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css" rel="stylesheet">

    <style>
        body {
            min-height: 100vh;
            display: flex;
            background-color: #f8f9fa;
        }

        /* SIDEBAR */
        .sidebar {
            width: 260px;
            background-color: #d96c19; /* ORANGE */
            color: #fff;
        }

        .sidebar .brand {
            font-size: 1.25rem;
            font-weight: 700;
        }

        .sidebar .nav-link {
            color: #fff;
            padding: 10px 15px;
            border-radius: 6px;
            margin-bottom: 4px;
        }

        .sidebar .nav-link:hover,
        .sidebar .nav-link.active {
            background-color: #600061; /* PURPLE */
            color: #fff;
        }

        .sidebar .dropdown-menu {
            background-color: #d96c19;
            border: none;
        }

        .sidebar .dropdown-item {
            color: #fff;
        }

        .sidebar .dropdown-item:hover {
            background-color: #600061;
            color: #fff;
        }

        /* CONTENT */
        .content {
            flex-grow: 1;
            padding: 20px;
        }

        /* TOPBAR */
        .topbar {
            background: #fff;
            padding: 12px 20px;
            border-radius: 8px;
            border: 1px solid #e0e0e0;
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }

        .logout-btn {
            color: #d96c19;
        }

        .logout-btn:hover {
            color: #600061;
        }
    </style>
</head>
<body>

<!-- SIDEBAR -->
<aside class="sidebar p-3 d-flex flex-column">
    <a href="{{ route('dashboard') }}" class="text-white text-decoration-none mb-4">
        <div class="brand">
            <i class="bi bi-layers me-2"></i> Application System
        </div>
    </a>

    <ul class="nav nav-pills flex-column">

        <!-- Dashboard -->
        <li class="nav-item">
            <a href="{{ route('dashboard') }}"
               class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                <i class="bi bi-speedometer2 me-2"></i> Dashboard
            </a>
        </li>

        <!-- Profile -->
        <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle {{ request()->routeIs('profile.*') ? 'active' : '' }}"
               data-bs-toggle="dropdown" href="#">
                <i class="bi bi-person-circle me-2"></i> My Profile
            </a>
            <ul class="dropdown-menu">
                <li>
                    <a class="dropdown-item" href="{{ route('profile.show') }}">
                        View Profile
                    </a>
                </li>
                <li>
                    <a class="dropdown-item" href="{{ route('profile.create') }}">
                        Edit Profile
                    </a>
                </li>
            </ul>
        </li>

        <!-- Applications -->
        <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle {{ request()->routeIs('applications.*') ? 'active' : '' }}"
               data-bs-toggle="dropdown" href="#">
                <i class="bi bi-file-earmark-text me-2"></i> Applications
            </a>
            <ul class="dropdown-menu">
                <li>
                    <a class="dropdown-item" href="{{ route('applications.create') }}">
                        Start New Application
                    </a>
                </li>
                <li>
                    <a class="dropdown-item" href="{{ route('applications.individual.index') }}">
                        Individual Applications
                    </a>
                </li>
                <li>
                    <a class="dropdown-item" href="{{ route('applications.institution.index') }}">
                        Institution Applications
                    </a>
                </li>
            </ul>
        </li>

    </ul>

    <div class="mt-auto">
        <hr class="text-white">
        <small class="text-white-50">
            &copy; {{ date('Y') }} Application System
        </small>
    </div>
</aside>

<!-- MAIN CONTENT -->
<main class="content">

    <!-- TOPBAR -->
    <div class="topbar">
        <div>
            Hello, <strong>{{ auth()->user()->name ?? auth()->user()->email }}</strong>
        </div>

        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="btn btn-sm btn-outline-danger logout-btn">
                <i class="bi bi-box-arrow-right"></i> Logout
            </button>
        </form>
    </div>

    <!-- PAGE CONTENT -->
    @yield('content')

</main>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
