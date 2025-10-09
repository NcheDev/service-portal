@extends('admin-dashboard')

@section('content')

<div class="container mt-5">

    {{-- Header --}}
    <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
        <div>
            <h2 class="text-nche-primary fw-bold mb-0">Unrecognised Applications</h2>
            <div class="underline-danger mt-1"></div>
        </div>
        <span class="badge bg-danger fs-6 px-3 py-2 shadow-sm">
            Total: {{ $users->sum(fn($u) => $u->applications->where('status', 'invalid')->count()) }}
        </span>
    </div>

    @if($users->count() > 0)
        <div class="card border-0 shadow-sm rounded-4">
            <div class="card-body p-0">
                <div class="table-responsive-sm">
                    <table class="table table-bordered table-striped table-hover align-middle mb-0 w-100">
                        <thead class="table-nche-dark text-white">
                            <tr>
                                <th>#</th>
                                <th>Full Name</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($users as $user)
                                @if($user->applications->count())
                                    @foreach($user->applications as $app)
                                        @if($app->status === 'invalid')
                                            <tr>
                                                <td>{{ $loop->parent->iteration }}.{{ $loop->iteration }}</td>
                                                <td>{{ $user->name }}</td>
                                                <td>
                                                    <span class="badge bg-danger">Unrecognised</span>
                                                </td>
                                                <td>
                                                    <a href="{{ route('admin.applicants.viewApplication', [$user->id, $app->id]) }}" 
                                                       class="btn btn-sm btn-nche-primary">
                                                       <i class="mdi mdi-eye"></i> View
                                                    </a>
                                                </td>
                                            </tr>
                                        @endif
                                    @endforeach
                                @endif
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        {{-- Pagination --}}
        <div class="d-flex justify-content-center mt-3">
            {{ $users->links() }}
        </div>
    @else
        <div class="alert alert-info mt-4 shadow-sm border-0 rounded-3">
            No unrecognised applications found.
        </div>
    @endif
</div>

{{-- ======================= NCHE-THEMED INTERNAL CSS ======================= --}}
<style>
/* === COLOR VARIABLES === */
.text-nche-primary { color: #52074f; }
.table-nche-dark { background-color: #52074f; }
.btn-nche-primary {
    background-color: #52074f;
    color: #fff;
    border: none;
    border-radius: 6px;
    transition: background-color 0.3s ease;
}
.btn-nche-primary:hover {
    background-color: #dd8027;
    color: #fff;
}

/* === UNDERLINES === */
.underline-danger {
    width: 80px;
    height: 3px;
    background-color: #dd8027;
    border-radius: 5px;
}

/* === TABLE STYLES === */
.table { border-color: #e0d0e8 !important; }
.table-striped > tbody > tr:nth-of-type(odd) { background-color: #f8f3fa; }
.table-hover tbody tr:hover { background-color: #f7e7eb; transition: 0.2s; }
.table thead th {
    text-transform: uppercase;
    font-size: 0.85rem;
    letter-spacing: 0.5px;
}
.table td { white-space: nowrap; } /* Prevent wrapping */

/* === BADGES === */
.badge.bg-danger {
    background-color: #d9534f !important;
    font-size: 0.85rem;
}

/* === RESPONSIVE === */
.table-responsive-sm {
    overflow-x: auto;
    -webkit-overflow-scrolling: touch;
    width: 100%;
}

/* Medium screens */
@media (max-width: 768px) {
    h2 { font-size: 1.1rem; }
    .table { font-size: 0.75rem; }
    .btn-nche-primary { font-size: 0.65rem; padding: 3px 6px; }
}

/* Small screens */
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
}

/* === Status column shrink on small screens === */
@media (max-width: 576px) {
    table td:nth-child(3) { /* 3rd column is Status */
        width: 1%;            /* shrink to fit content */
        white-space: nowrap;  /* prevent wrapping */
    }
    table td:nth-child(3) .badge {
        font-size: 0.45rem;   /* smaller badge text */
        padding: 0.15rem 0.25rem; /* smaller padding */
    }
}

</style>

@endsection
