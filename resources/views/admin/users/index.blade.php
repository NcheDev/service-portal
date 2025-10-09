@extends('admin-dashboard')

@section('content')
<div class="container mt-4">

    {{-- Header --}}
    <div class="d-flex flex-column flex-md-row align-items-start align-items-md-center justify-content-between mb-4 gap-2">
        <h4 class="fw-bold text-nche-primary mb-0 d-flex align-items-center gap-2">
            <i class="mdi mdi-account-group text-nche-warning"></i> User Management
        </h4>
        <span class="badge bg-nche-warning px-3 py-2 shadow-sm">
            Total Users: {{ $users->total() }}
        </span>
    </div>

    {{-- Users Table --}}
    <div class="card shadow-sm rounded-4 border-0">
        <div class="card-body p-0 table-responsive">

            <table class="table table-hover align-middle mb-0">
                <thead class="table-nche-dark text-white text-uppercase">
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
                                @if ($user->personalInfo && $user->personalInfo->profile_picture && file_exists(public_path('storage/' . $user->personalInfo->profile_picture)))
                                    <img src="{{ asset('storage/' . $user->personalInfo->profile_picture) }}" 
                                         alt="Avatar" class="rounded-circle border" width="40" height="40">
                                @else
                                    <img src="{{ asset('images/avatar.png') }}" 
                                         alt="Avatar" class="rounded-circle border" width="40" height="40">
                                @endif
                            </td>

                            {{-- Full Name --}}
                            <td>{{ $user->name }}</td>

                            {{-- Status --}}
                            <td>
                                <span class="badge {{ $user->is_active ? 'bg-success' : 'bg-secondary' }}">
                                    {{ $user->is_active ? 'Active' : 'Inactive' }}
                                </span>
                            </td>

                            {{-- Role --}}
                            <td>
                                @php $role = $user->getRoleNames()->first(); @endphp
                                @if ($role)
                                    <span class="badge bg-nche-primary text-uppercase">{{ $role }}</span>
                                @else
                                    <span class="text-muted">—</span>
                                @endif
                            </td>

                            {{-- Actions --}}
                            <td class="text-center">
                                <a href="{{ url('/admin/users/' . $user->id) }}" 
                                   class="btn btn-sm btn-nche-primary">
                                    <i class="mdi mdi-eye me-1"></i> View Profile
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            {{-- Pagination --}}
            <div class="d-flex justify-content-center mt-3">
                {{ $users->links() }}
            </div>

        </div>
    </div>
</div>

{{-- ===================== NCHE STYLES ===================== --}}
<style>
/* Colors */
.text-nche-primary { color: #52074f; }
.text-nche-warning { color: #dd8027; }
.bg-nche-primary { background-color: #52074f !important; color: #fff !important; }
.bg-nche-warning { background-color: #dd8027 !important; color: #fff !important; }
.table-nche-dark { background-color: #52074f !important; }

/* Table */
.table th, .table td { vertical-align: middle; }
.table th { font-size: 0.9rem; letter-spacing: 0.5px; }
.table-hover tbody tr:hover { background-color: #f7e7f7; transition: 0.2s; }

/* Buttons */
.btn-nche-primary {
    background-color: #52074f;
    color: #fff;
    border-radius: 6px;
    transition: all 0.3s;
}
.btn-nche-primary:hover {
    background-color: #dd8027;
    color: #fff;
}

/* Badges */
.badge { font-size: 0.85rem; border-radius: 6px; }

/* Card */
.card { border-radius: 16px; }

/* Pagination */
.pagination { margin: 0; justify-content: center; }
.page-item.active .page-link {
    background-color: #52074f;
    border-color: #52074f;
    color: #fff;
}
.page-link { color: #52074f; border-radius: 5px; padding: 0.35rem 0.7rem; margin: 0 2px; }
.page-link:hover { background-color: #dd8027; color: #fff; border-color: #dd8027; }

/* ===================== RESPONSIVE ===================== */

/* Medium screens (≤ 992px) */
@media (max-width: 992px) {
    .table th, .table td {
        font-size: 0.8rem;
        padding: 0.4rem 0.6rem;
    }
    .btn-sm {
        font-size: 0.75rem;
        padding: 0.25rem 0.5rem;
    }
}

/* Small screens (≤ 576px) */@media (max-width: 576px) {
    h4 { font-size: 0.8rem; }
    .badge { font-size: 0.4rem; }
    .table th, .table td {
        font-size: 0.55rem;
        padding: 0.15rem 0.25rem;
    }
    .btn-sm {
        font-size: 0.4rem;
        padding: 0.15rem 0.3rem;
    }
}



</style>
@endsection
