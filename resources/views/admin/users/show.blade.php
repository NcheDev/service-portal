<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>View User Profile</title>
    <link
      href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css"
      rel="stylesheet"
    >
</head>
<body class="bg-light">

<div class="container mt-5">
    <div class="card shadow-sm rounded">
        <div class="card-header bg-white">
            <h3 class="mb-0">{{ $user->name }}’s Profile</h3>
        </div>

        <div class="card-body">
            <div class="row gy-3">
                {{-- Profile Picture --}}
                <div class="col-md-3 text-center">
                    @if ($user->profile_picture)
                        <img src="{{ asset('storage/' . $user->profile_picture) }}"
                             alt="Avatar"
                             class="rounded-circle mb-3"
                             width="120"
                             height="120">
                    @else
                        <img src="{{ asset('images/avatar-placeholder.png') }}"
                             alt="Avatar"
                             class="rounded-circle mb-3"
                             width="120"
                             height="120">
                    @endif
                </div>

                {{-- User Details --}}
                <div class="col-md-9">
                    <p><strong>Name:</strong> {{ $user->name }}</p>
                    <p><strong>Email:</strong> {{ $user->email }}</p>
                    <p>
                        <strong>Status:</strong>
                        @if ($user->is_active)
                            <span class="badge bg-success">Active</span>
                        @else
                            <span class="badge bg-secondary">Inactive</span>
                        @endif
                    </p>
                    <p>
                        <strong>Role(s):</strong>
                        @foreach ($user->getRoleNames() as $roleName)
                            <span class="badge bg-primary">{{ $roleName }}</span>
                        @endforeach
                        @if ($user->getRoleNames()->isEmpty())
                            <span class="text-muted">No Role Assigned</span>
                        @endif
                    </p>
                    <p>
                        <strong>Permissions:</strong>
                        @foreach ($user->getPermissionNames() as $permName)
                            <span class="badge bg-info text-dark">{{ $permName }}</span>
                        @endforeach
                        @if ($user->getPermissionNames()->isEmpty())
                            <span class="text-muted">No Permissions</span>
                        @endif
                    </p>
                    <p>
                        <strong>Certificate Status:</strong>
                        @if ($user->certificate_validated ?? false)
                            <span class="badge bg-success">Validated</span>
                        @else
                            <span class="badge bg-warning text-dark">Not Validated</span>
                        @endif
                    </p>
                </div>
            </div>

            <hr>

            {{-- Management Actions --}}
            <div class="row gy-3">
                {{-- Activate / Deactivate --}}
                <div class="col-md-6">
                    <form method="POST" action="{{ route('admin.users.toggle', $user) }}">
                        @csrf
                        <button type="submit"
                                class="btn {{ $user->is_active ? 'btn-warning' : 'btn-success' }}">
                            {{ $user->is_active ? 'Deactivate User' : 'Activate User' }}
                        </button>
                    </form>
                </div>

                {{-- Assign Role --}}
                <div class="col-md-6">
                    <form method="POST" action="{{ route('admin.users.assignRole', $user) }}">
                        @csrf
                        <div class="input-group">
                            <select name="role" class="form-select">
                                <option value="">Select Role…</option>
                                @foreach ($roles as $role)
                                    <option value="{{ $role->name }}">{{ ucfirst($role->name) }}</option>
                                @endforeach
                            </select>
                            <button type="submit" class="btn btn-primary">Assign Role</button>
                        </div>
                    </form>
                </div>

                {{-- Remove Role --}}
                <div class="col-md-6">
                    <form method="POST" action="{{ route('admin.users.removeRole', $user) }}">
                        @csrf
                        <div class="input-group">
                            <select name="role" class="form-select">
                                <option value="">Select Role to Remove…</option>
                                @foreach ($user->getRoleNames() as $roleName)
                                    <option value="{{ $roleName }}">{{ ucfirst($roleName) }}</option>
                                @endforeach
                            </select>
                            <button type="submit" class="btn btn-danger">Remove Role</button>
                        </div>
                    </form>
                </div>

                {{-- Assign Permission --}}
                <div class="col-md-6">
                    <form method="POST" action="{{ route('admin.users.givePermission', $user) }}">
                        @csrf
                        <div class="input-group">
                            <select name="permission" class="form-select">
                                <option value="">Select Permission…</option>
                                @foreach ($permissions as $permission)
                                    <option value="{{ $permission->name }}">{{ ucfirst($permission->name) }}</option>
                                @endforeach
                            </select>
                            <button type="submit" class="btn btn-secondary">Assign Permission</button>
                        </div>
                    </form>
                </div>

                {{-- Revoke Permission --}}
                <div class="col-md-6">
                    <form method="POST" action="{{ route('admin.users.revokePermission', $user) }}">
                        @csrf
                        <div class="input-group">
                            <select name="permission" class="form-select">
                                <option value="">Select Permission to Remove…</option>
                                @foreach ($user->getPermissionNames() as $permName)
                                    <option value="{{ $permName }}">{{ ucfirst($permName) }}</option>
                                @endforeach
                            </select>
                            <button type="submit" class="btn btn-danger">Remove Permission</button>
                        </div>
                    </form>
                </div>
            </div>

            <hr>

            {{-- Back to List --}}
            <a href="{{ route('admin.users.index') }}" class="btn btn-link">&larr; Back to User List</a>
        </div>
    </div>
</div>

<!-- Bootstrap JS Bundle (includes Popper) -->
<script
  src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"
></script>
</body>
</html>
