<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>User Profile</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
  <style>
    body { background-color: #f8f9fa; }

    /* Theme colors */
    .theme-primary { background-color: #52074f; color: #fff; }
    .theme-accent  { background-color: #dd8027; color: #fff; }

    /* Tabs equal width */
    .nav-tabs .nav-item { flex: 1 1 50%; text-align: center; }
    .nav-tabs .nav-link { width: 100%; border-radius: 0; }
    .nav-tabs .nav-link.active { background-color: #52074f; color: #fff; }

    /* Ensure cards fill column height */
    .h-100 { height: 100% !important; }
  </style>
</head>
<body>
  @if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
  @endif

  <div class="container py-5">
    <div class="row gx-4 gy-4 align-items-stretch">
      <!-- Sidebar -->
      <div class="col-12 col-md-3 d-flex">
        <div class="card text-center shadow-sm h-100 w-100">
          <div class="card-body d-flex flex-column">
            <img src="{{ $user->personalInformation ? asset('storage/' . $user->personalInfo->profile_picture) : asset('images/avatar-placeholder.png') }}"
                 class="rounded-circle mb-3 mx-auto" width="100" height="100" alt="Avatar" />
            <h5>{{ $user->name }}</h5>
            <p class="mb-1">
              <span class="badge {{ $user->is_active ? 'bg-success' : 'bg-secondary' }}">
                {{ $user->is_active ? 'Active' : 'Inactive' }}
              </span>
            </p>
            <p><strong>Roles:</strong></p>
            <div class="mt-auto">
              @forelse ($user->getRoleNames() as $role)
                <span class="badge bg-primary mb-1 d-block">{{ $role }}</span>
              @empty
                <span class="text-muted">No Role Assigned</span>
              @endforelse
            </div>
          </div>
        </div>
      </div>

      <!-- Main Content -->
      <div class="col-12 col-md-9 d-flex">
        <div class="card shadow-sm h-100 w-100 d-flex flex-column">
          <!-- Tabs header -->
          <div class="card-header bg-white border-bottom">
            <ul class="nav nav-tabs card-header-tabs" id="profileTabs" role="tablist">
              <li class="nav-item" role="presentation">
                <button class="nav-link active" id="details-tab" data-bs-toggle="tab" data-bs-target="#details"
                        type="button" role="tab" aria-controls="details" aria-selected="true">
                  User Details
                </button>
              </li>
              <li class="nav-item" role="presentation">
                <button class="nav-link" id="roles-tab" data-bs-toggle="tab" data-bs-target="#roles"
                        type="button" role="tab" aria-controls="roles" aria-selected="false">
                  Roles & Permissions
                </button>
              </li>
            </ul>
          </div>

          <!-- Tabs content -->
          <div class="card-body flex-grow-1 tab-content" id="profileTabsContent">
            <!-- User Details Tab -->
            <div class="tab-pane fade show active h-100" id="details" role="tabpanel" aria-labelledby="details-tab">
              <div class="row h-100">
                <div class="col-12 col-md-6">
                  <p><strong>Name:</strong> {{ $user->name }}</p>
                  <p><strong>Email:</strong> {{ $user->email }}</p>
                  <p><strong>Title:</strong> {{ $user->personalInfo->title ?? 'N/A' }}</p>
                  <p><strong>Phone:</strong> {{ $user->personalInfo->contact_address ?? 'N/A' }}</p>
                  <p><strong>Gender:</strong> {{ $user->personalInfo->gender ?? 'N/A' }}</p>
                  <p><strong>Country:</strong> {{ $user->personalInfo->country ?? 'N/A' }}</p>
                </div>
                <div class="col-12 col-md-6">
                  <p><strong>Previous Surnames:</strong> {{ $user->personalInfo->previous_surnames ?? 'N/A' }}</p>
                  <p><strong>Physical Address:</strong> {{ $user->personalInfo->physical_address ?? 'N/A' }}</p>
                  <p><strong>Date of Birth:</strong> {{ $user->personalInfo->date_of_birth ?? 'N/A' }}</p>
                  <p><strong>Next Of Kin:</strong> {{ $user->personalInfo->next_of_kin ?? 'N/A' }}</p>
                  <p><strong>Kin Contact:</strong> {{ $user->personalInfo->kin_contact ?? 'N/A' }}</p>
                  <p><strong>National ID:</strong>
                    @if($user->personalInfo?->national_id_path)
                      <a href="{{ asset('storage/' . $user->personalInfo->national_id_path) }}" target="_blank">View</a>
                    @else
                      N/A
                    @endif
                  </p>
                </div>
              </div>
            </div>

            <!-- Roles & Permissions Tab -->
            <div class="tab-pane fade h-100" id="roles" role="tabpanel" aria-labelledby="roles-tab">
              <div class="row h-100">
                <div class="col-12 mb-3">
                  <h6>Current Roles</h6>
                  @forelse ($user->getRoleNames() as $roleName)
                    <span class="badge bg-primary me-1">{{ $roleName }}</span>
                  @empty
                    <span class="text-muted">No Role Assigned</span>
                  @endforelse
                </div>
                <div class="col-12 mb-3">
                  <h6>Current Permissions</h6>
                  @forelse ($user->getAllPermissions() as $perm)
                    <span class="badge bg-info text-dark me-1">{{ $perm->name }}</span>
                  @empty
                    <span class="text-muted">No Permissions</span>
                  @endforelse
                </div>

                @unless($user->hasRole('admin'))
                  <div class="col-12 col-md-6 mb-3">
                    <form class="ajax-form" method="POST" action="{{ route('admin.users.assignRole', $user) }}">
                      @csrf
                      <label class="form-label">Assign Role</label>
                      <div class="input-group">
                        <select name="role" class="form-select">
                          <option value="">Select Role…</option>
                          @foreach ($roles as $role)
                            <option value="{{ $role->name }}">{{ ucfirst($role->name) }}</option>
                          @endforeach
                        </select>
                        <button type="submit" class="btn btn-success">Assign</button>
                      </div>
                    </form>
                  </div>

                  <div class="col-12 col-md-6 mb-3">
                    <form class="ajax-form" method="POST" action="{{ route('admin.users.removeRole', $user) }}">
                      @csrf
                      <label class="form-label">Remove Role</label>
                      <div class="input-group">
                        <select name="role" class="form-select">
                          <option value="">Select Role…</option>
                          @foreach ($user->getRoleNames() as $roleName)
                            <option value="{{ $roleName }}">{{ ucfirst($roleName) }}</option>
                          @endforeach
                        </select>
                        <button type="submit" class="btn btn-danger">Remove</button>
                      </div>
                    </form>
                  </div>

                  <div class="col-12 col-md-6 mb-3">
                    <form class="ajax-form" method="POST" action="{{ route('admin.users.givePermission', $user) }}">
                      @csrf
                      <label class="form-label">Give Permission</label>
                      <div class="input-group">
                        <select name="permission" class="form-select">
                          <option value="">Select Permission…</option>
                          @foreach ($permissions as $permission)
                            <option value="{{ $permission->name }}">{{ ucfirst($permission->name) }}</option>
                          @endforeach
                        </select>
                        <button type="submit" class="btn btn-success">Give</button>
                      </div>
                    </form>
                  </div>

                  <div class="col-12 col-md-6 mb-3">
                    <form class="ajax-form" method="POST" action="{{ route('admin.users.revokePermission', $user) }}">
                      @csrf
                      <label class="form-label">Revoke Permission</label>
                      <div class="input-group">
                        <select name="permission" class="form-select">
                          <option value="">Select Permission…</option>
                          @foreach ($user->getPermissionNames() as $permName)
                            <option value="{{ $permName }}">{{ ucfirst($permName) }}</option>
                          @endforeach
                        </select>
                        <button type="submit" class="btn btn-danger">Revoke</button>
                      </div>
                    </form>
                  </div>
                @endunless
              </div>
            </div>
          </div>

        </div>
      </div>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
  <!-- Your AJAX script here -->
</body>
</html>
