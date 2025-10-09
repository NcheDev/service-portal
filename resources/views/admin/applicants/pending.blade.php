@extends('admin-dashboard')

@section('content')
<div class="container-fluid py-4">
  <div class="card shadow-sm border-0">
    <div class="card-header d-flex justify-content-between align-items-center" 
         style="background-color:#52074f; color:white;">
      <h4 class="mb-0">Pending Applications</h4>
      <span class="badge rounded-pill" style="background-color:#dd8027;">
        {{ $users->count() }} Applicants
      </span>
    </div>

    <div class="card-body bg-light">
      @if($users->count() > 0)
        <div class="table-responsive">
          <table class="table table-hover align-middle">
            <thead style="background-color:#52074f; color:white;">
              <tr>
                <th>#</th>
                <th>Full Name</th>
                <th>Email</th>
                <th>Status</th>
                <th>Action</th>
              </tr>
            </thead>
            <tbody>
              @foreach($users as $user)
                @if($user->applications->count())
                  @foreach($user->applications as $app)
                    <tr>
                      <td>{{ $loop->parent->iteration }}.{{ $loop->iteration }}</td>
                      <td class="fw-semibold">{{ $user->name }}</td>
                      <td>{{ $user->email }}</td>
                      <td>
                        <span class="badge 
                          @if($app->status === 'validated') bg-success
                          @elseif($app->status === 'pending') bg-warning text-dark
                          @elseif($app->status === 'invalid') bg-danger
                          @else bg-secondary @endif">
                          {{ ucfirst($app->status) }}
                        </span>
                      </td>
                      <td>
                        <a href="{{ route('admin.applicants.viewApplication', [$user->id, $app->id]) }}"
                           class="btn btn-sm text-white"
                           style="background-color:#dd8027; border:none;"
                           data-url="{{ route('admin.applicants.viewApplication', [$user->id, $app->id]) }}">
                           <i class="mdi mdi-eye me-1"></i> View
                        </a>
                      </td>
                    </tr>
                  @endforeach
                @else
                  <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->email }}</td>
                    <td><span class="badge bg-secondary">No Applications</span></td>
                    <td><button class="btn btn-sm btn-secondary" disabled>N/A</button></td>
                  </tr>
                @endif
              @endforeach
            </tbody>
          </table>
        </div>

        <!-- Pagination -->
        <div class="d-flex justify-content-center mt-3">
          {{ $users->links() }}
        </div>
      @else
        <div class="alert alert-info text-center mb-0">No applicants found.</div>
      @endif
    </div>
  </div>
</div>

<!-- Internal Style for NCHE Theme -->
<style>
.card {
  border-radius: 10px;
  overflow: hidden;
}

.table th {
  font-weight: 600;
  text-transform: uppercase;
  letter-spacing: 0.03em;
}

.table-hover tbody tr:hover {
  background-color: rgba(221,128,39,0.08);
  transition: background 0.2s ease;
}

.btn:hover {
  opacity: 0.9;
  transform: scale(1.02);
  transition: all 0.2s ease;
}

/* Pagination Styling */
.pagination .page-link {
  color: #52074f;
}
.pagination .page-item.active .page-link {
  background-color: #dd8027;
  border-color: #dd8027;
}
.pagination .page-link:hover {
  background-color: #52074f;
  color: #fff;
}

/* Responsive */
@media (max-width: 768px) {
  .table th, .table td {
    font-size: 0.85rem;
  }
  .btn {
    font-size: 0.8rem;
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
  }
</style>
 
@endsection
