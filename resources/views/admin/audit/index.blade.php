@extends('admin-dashboard')

@section('content')
<div class="container mt-4">

    {{-- Header --}}
    <div class="d-flex align-items-center justify-content-between mb-4">
        <h4 class="fw-bold text-nche-primary mb-0">
            <i class="mdi mdi-history text-nche-warning me-2"></i> Audit Trail
        </h4>
        <span class="badge bg-nche-warning px-3 py-2 shadow-sm">
            Total Logs: {{ $logs->total() }}
        </span>
    </div>

    {{-- Card --}}
    <div class="card shadow-sm rounded-4 border-0">
        <div class="card-body p-0 table-responsive">

            <table class="table table-hover align-middle mb-0">
                <thead class="table-nche-dark text-white text-uppercase">
                    <tr>
                        <th>#</th>
                        <th>User</th>
                        <th>Event</th>
                        <th>Model</th>
                        <th>Old Values</th>
                        <th>New Values</th>
                        <th>IP</th>
                        <th>Device</th>
                        <th>Time</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($logs as $log)
                        <tr>
                            <td class="fw-semibold text-nche-primary">
                                {{ $loop->iteration + ($logs->currentPage() - 1) * $logs->perPage() }}
                            </td>
                            <td>{{ $log->user?->name ?? 'System' }}</td>
                            <td class="text-nche-warning fw-medium">{{ ucfirst($log->action) }}</td>
                            <td class="text-muted">{{ class_basename($log->auditable_type) }} #{{ $log->auditable_id }}</td>
                            <td><pre class="text-wrap text-break small bg-light p-2 rounded">{{ json_encode($log->old_values, JSON_PRETTY_PRINT) }}</pre></td>
                            <td><pre class="text-wrap text-break small bg-light p-2 rounded">{{ json_encode($log->new_values, JSON_PRETTY_PRINT) }}</pre></td>
                            <td>{{ $log->ip_address }}</td>
                            <td style="max-width: 160px;">{{ Str::limit($log->user_agent, 60) }}</td>
                            <td>{{ $log->created_at->diffForHumans() }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="9" class="text-center text-muted py-4">No audit logs found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

            {{-- NCHE-styled pagination --}}
            @if ($logs->hasPages())
                <div class="d-flex justify-content-center mt-3 mb-2">
                    <nav>
                        <ul class="pagination pagination-sm">
                            {{-- Previous Page Link --}}
                            @if ($logs->onFirstPage())
                                <li class="page-item disabled"><span class="page-link">Prev</span></li>
                            @else
                                <li class="page-item">
                                    <a class="page-link" href="{{ $logs->previousPageUrl() }}">Prev</a>
                                </li>
                            @endif

                            {{-- Page Numbers --}}
                            @foreach ($logs->getUrlRange(1, $logs->lastPage()) as $page => $url)
                                <li class="page-item {{ $logs->currentPage() == $page ? 'active' : '' }}">
                                    <a class="page-link" href="{{ $url }}">{{ $page }}</a>
                                </li>
                            @endforeach

                            {{-- Next Page Link --}}
                            @if ($logs->hasMorePages())
                                <li class="page-item">
                                    <a class="page-link" href="{{ $logs->nextPageUrl() }}">Next</a>
                                </li>
                            @else
                                <li class="page-item disabled"><span class="page-link">Next</span></li>
                            @endif
                        </ul>
                    </nav>
                </div>
            @endif

        </div>
    </div>
</div>

<style>
/* Colors */
.text-nche-primary { color: #52074f; }
.text-nche-warning { color: #dd8027; }
.bg-nche-warning { background-color: #dd8027 !important; }
.table-nche-dark { background-color: #52074f; }

/* Table Styling */
.table-hover tbody tr:hover { background-color: #f7e7f7; transition: 0.2s; }
.table th, .table td { vertical-align: middle; }
.table th { font-size: 0.85rem; letter-spacing: 0.5px; }

/* Preformatted JSON */
pre {
    font-family: 'Courier New', Courier, monospace;
    font-size: 0.75rem;
    max-height: 150px;
    overflow: auto;
}

/* Card */
.card { border-radius: 15px; }

/* Badges */
.badge { font-size: 0.85rem; }

/* Pagination */
.pagination { margin: 0; justify-content: center; }
.pagination .page-link {
    color: #52074f;
    border-radius: 5px;
    margin: 0 2px;
    padding: 0.35rem 0.7rem;
    transition: 0.2s;
}
.pagination .page-item.active .page-link {
    background-color: #52074f;
    border-color: #52074f;
    color: #fff;
}
.pagination .page-link:hover {
    background-color: #dd8027;
    border-color: #dd8027;
    color: #fff;
}
.pagination .page-item.disabled .page-link { color: #6c757d; cursor: not-allowed; }

/* Responsive */
@media (max-width: 992px) {
    .table-responsive { overflow-x: auto; }
    pre { font-size: 0.65rem; max-height: 120px; }
}
@media (max-width: 576px) {
    h4 { font-size: 1.1rem; }
    .badge { font-size: 0.75rem; }
    table th, table td { font-size: 0.7rem; padding: 0.3rem; }
}
@media (max-width: 576px) {
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
