<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>User Management</title>
    <link
      href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css"
      rel="stylesheet"
    >
</head>
<body class="bg-light">

<div class="container mt-5">
    <h2 class="mb-4">User Management</h2>

    <table class="table table-hover align-middle bg-white shadow-sm rounded">
        <thead class="table-light">
            <tr>
                <th scope="col">Profile</th>
                <th scope="col">Full Name</th>
                <th scope="col">Status</th>
                <th scope="col">Role</th>
                <th scope="col">Certificate</th>
                <th scope="col" class="text-center">Actions</th>
            </tr>
        </thead>

        <tbody>
        @foreach ($users as $user)
            <tr>
                {{-- Profile Picture (use a placeholder if none) --}}
                <td>
                    @if ($user->profile_picture)
                        <img src="{{ asset('storage/' . $user->profile_picture) }}"
                             alt="Avatar"
                             class="rounded-circle"
                             width="40"
                             height="40">
                    @else
                        <img src="{{ asset('images/avatar-placeholder.png') }}"
                             alt="Avatar"
                             class="rounded-circle"
                             width="40"
                             height="40">
                    @endif
                </td>

                {{-- Full Name --}}
                <td>{{ $user->name }}</td>

                {{-- Active / Inactive Status Badge --}}
                <td>
                    @if ($user->is_active)
                        <span class="badge bg-success">Active</span>
                    @else
                        <span class="badge bg-secondary">Inactive</span>
                    @endif
                </td>

                {{-- Primary Role (first one) --}}
                <td>
                    @php $primaryRole = $user->getRoleNames()->first(); @endphp
                    @if ($primaryRole)
                        <span class="badge bg-primary text-uppercase">{{ $primaryRole }}</span>
                    @else
                        <span class="text-muted">—</span>
                    @endif
                </td>

                {{-- Certificate Status Badge --}}
                <td>
                    @if ($user->certificate_validated ?? false)
                        <span class="badge bg-success">Validated</span>
                    @else
                        <span class="badge bg-warning text-dark">Not Validated</span>
                    @endif
                </td>

                {{-- Actions: View Profile --}}
                <td class="text-center">
                    <a href="{{ route('admin.users.show', $user->id) }}"
                       class="btn btn-sm btn-info">
                        View Profile
                    </a>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>

    {{-- Pagination Links --}}
    <div class="d-flex justify-content-center">
        {{ $users->links() }}
    </div>
</div>

<!-- Bootstrap JS Bundle (includes Popper) -->
<script
  src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"
></script>
</body>
</html>
