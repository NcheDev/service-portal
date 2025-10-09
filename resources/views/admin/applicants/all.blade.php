@extends('admin-dashboard')

@section('content')
<div class="container mt-5">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="text-nche-primary fw-bold mb-0">All Applications</h2>
            <div class="underline-accent mt-1"></div>
        </div>
        <span class="badge bg-nche-secondary fs-6 px-3 py-2">
            Total: {{ $users->sum(fn($u) => $u->applications->count()) }}
        </span>
    </div>

    @php
        // Filter users: Only those with applications and without the 'admin' role
        $filteredUsers = $users->filter(function ($user) {
            return $user->applications->count() > 0 && !$user->hasRole('admin');
        });
    @endphp

    @if($filteredUsers->count() > 0)
        <div class="table-responsive shadow-sm rounded-3 overflow-hidden">
            <table class="table table-bordered table-striped table-hover align-middle mb-0">
                <thead class="table-nche-dark text-white">
                    <tr>
                        <th>#</th>
                        <th>Full Name</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($filteredUsers as $user)
                        @foreach($user->applications as $app)
                            <tr>
                                <td>{{ $loop->parent->iteration }}.{{ $loop->iteration }}</td>
                                <td>{{ $user->name }}</td>
                                <td>
                                    <span class="badge 
                                        {{ $app->status === 'validated' ? 'bg-success' : 
                                           ($app->status === 'pending' ? 'bg-warning text-dark' : 
                                           ($app->status === 'invalid' ? 'bg-danger' : 'bg-secondary')) }}">
                                        {{ $app->status === 'validated' ? 'Recognised' : 
                                           ($app->status === 'invalid' ? 'Unrecognised' : ucfirst($app->status)) }}
                                    </span>
                                </td>
                                <td>
                                    <a href="{{ route('admin.applicants.viewApplication', [$user->id, $app->id]) }}"
                                       class="btn btn-sm btn-nche-primary btn-view-application"
                                       data-url="{{ route('admin.applicants.viewApplication', [$user->id, $app->id]) }}">
                                       <i class="mdi mdi-eye"></i> View
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    @endforeach
                </tbody>
            </table>
        </div>
    @else
        <div class="alert alert-info mt-4 shadow-sm border-0 rounded-3">
            No applications available.
        </div>
    @endif
</div>

{{-- NCHE-themed CSS --}}
<style>
/* === NCHE THEME COLORS === */
.text-nche-primary {
    color: #52074f;
}
.bg-nche-secondary {
    background-color: #dd8027;
}
.btn-nche-primary {
    background-color: #52074f;
    color: #fff;
    border: none;
    border-radius: 6px;
    transition: 0.3s ease;
}
.btn-nche-primary:hover {
    background-color: #dd8027;
    color: #fff;
}
.table-nche-dark {
    background-color: #52074f;
}

/* === TABLE STYLING === */
.table {
    border-color: #e0d0e8 !important;
}
.table-striped > tbody > tr:nth-of-type(odd) {
    background-color: #f8f3fa;
}
.table-hover tbody tr:hover {
    background-color: #f1e6f7;
    transition: 0.2s;
}
.table thead th {
    text-transform: uppercase;
    font-size: 0.85rem;
    letter-spacing: 0.5px;
}

/* === TITLE UNDERLINE === */
.underline-accent {
    width: 80px;
    height: 3px;
    background-color: #dd8027;
    border-radius: 5px;
}

/* === RESPONSIVE === */
@media (max-width: 768px) {
    h2 {
        font-size: 1.3rem;
    }
    .table {
        font-size: 0.85rem;
    }
    .btn-nche-primary {
        font-size: 0.75rem;
        padding: 4px 8px;
    }
}

@media (max-width: 576px) {
    h2 { font-size: 0.9rem; }
    .badge { font-size: 0.55rem; }
    .table th, .table td {
        font-size: 0.55rem;
        padding: 0.2rem 0.25rem;
    }
    .btn-sm {
        font-size: 0.45rem;
        padding: 0.2rem 0.35rem;
    }
    .table-responsive-sm {
        margin-bottom: 1rem;
    }
</style>
@endsection
