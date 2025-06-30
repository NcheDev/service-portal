<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>User Management</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
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
               
                <th scope="col" class="text-center">Actions</th>
            </tr>
        </thead>

        <tbody>
        @foreach ($users as $user)
            <tr>
                {{-- Profile Picture --}}
                <td>
                    @if ($user->profile_picture)
                        <img src="{{ asset('storage/' . $user->profile_picture) }}"
                             alt="Avatar" class="rounded-circle" width="40" height="40">
                    @else
                        <img src="{{ asset('images/avatar-placeholder.png') }}"
                             alt="Avatar" class="rounded-circle" width="40" height="40">
                    @endif
                </td>

                {{-- Full Name --}}
                <td>{{ $user->name }}</td>

                {{-- Active / Inactive --}}
                <td>
                    <span class="badge {{ $user->is_active ? 'bg-success' : 'bg-secondary' }}">
                        {{ $user->is_active ? 'Active' : 'Inactive' }}
                    </span>
                </td>

                {{-- Role --}}
                <td>
                    @php $role = $user->getRoleNames()->first(); @endphp
                    @if ($role)
                        <span class="badge bg-primary text-uppercase">{{ $role }}</span>
                    @else
                        <span class="text-muted">—</span>
                    @endif
                </td>

               

                {{-- Actions --}}
                <td class="text-center">
                <a href="#" class="btn btn-sm btn-info btn-view-user" data-user-id="{{ $user->id }}">
    View Profile
</a>


                </td>
            </tr>
        @endforeach
        </tbody>
    </table>

    {{-- Pagination --}}
    <div class="d-flex justify-content-center">
        {{ $users->links() }}
    </div>
</div>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
$(document).ready(function () {
    $('.btn-view-user').on('click', function (e) {
        e.preventDefault();

        var userId = $(this).data('user-id');
        var url = '/admin/users/' + userId;

        $.ajax({
            url: url,
            method: 'GET',
            success: function (response) {
                $('.main-panel').html(response);
            },
            error: function (xhr) {
                alert('Failed to load user profile.');
                console.error(xhr);
            }
        });
    });
});
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
