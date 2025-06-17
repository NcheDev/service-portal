<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>View User Profile</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container mt-5">
    <div class="card shadow-sm rounded">
        <div class="card-header bg-white">
            <h3 class="mb-0">{{ $user->name }}’s Profile</h3>
        </div>

        <div class="card-body">
            <div class="row">
                {{-- Sidebar --}}
                <div class="col-md-3">
                    <div class="card bg-light text-center h-100">
                        <div class="card-body">
                            @if($user->personalInformation)
                                <img src="{{ asset('storage/' . $user->personalInfo->profile_picture) }}"
                                     alt="Avatar" class="rounded-circle mb-3" width="100" height="100">
                            @else
                                <img src="{{ asset('images/avatar-placeholder.png') }}"
                                     alt="Avatar" class="rounded-circle mb-3" width="100" height="100">
                            @endif

                            <p><strong>Status:</strong><br>
                                <span class="badge {{ $user->is_active ? 'bg-success' : 'bg-secondary' }}">
                                    {{ $user->is_active ? 'Active' : 'Inactive' }}
                                </span>
                            </p>

                            <p><strong>Certificate:</strong><br>
                                <span class="badge {{ $user->certificate_validated ? 'bg-success' : 'bg-warning text-dark' }}">
                                    {{ $user->certificate_validated ? 'Validated' : 'Not Validated' }}
                                </span>
                            </p>

                            <p><strong>Role(s):</strong><br>
                                @forelse ($user->getRoleNames() as $roleName)
                                    <span class="badge bg-primary mb-1 d-block">{{ $roleName }}</span>
                                @empty
                                    <span class="text-muted">No Role Assigned</span>
                                @endforelse
                            </p>
                        </div>
                    </div>
                </div>

                {{-- Main Tabbed Section --}}
                <div class="col-md-9">
                    <ul class="nav nav-tabs mb-3" id="profileTabs" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" id="personal-tab" data-bs-toggle="tab"
                                    data-bs-target="#personal" type="button" role="tab">Personal Info</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="qualifications-tab" data-bs-toggle="tab"
                                    data-bs-target="#qualifications" type="button" role="tab">Qualifications</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="payments-tab" data-bs-toggle="tab"
                                    data-bs-target="#payments" type="button" role="tab">Payments</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="roles-tab" data-bs-toggle="tab"
                                    data-bs-target="#roles" type="button" role="tab">Roles & Permissions</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="account-tab" data-bs-toggle="tab"
                                    data-bs-target="#account" type="button" role="tab">Account Status</button>
                        </li>
                    </ul>

                    <div class="tab-content" id="profileTabContent">
                        {{-- Personal Info --}}
                        <div class="tab-pane fade show active" id="personal" role="tabpanel">
                            <div class="row">
                                <div class="col-md-6">
                                    <p><strong>Name:</strong> {{ $user->name }}</p>
                                    <p><strong>Email:</strong> {{ $user->email }}</p>
                                    <p><strong>Title:</strong> {{ $user->personalInfo->title ?? 'N/A' }}</p>
                                    <p><strong>Phone Number:</strong> {{ $user->personalInfo->contact_address ?? 'N/A' }}</p>   
                                    <p><strong>Country:</strong> {{ $user->personalInfo->country }}</p>
                                    <p><strong>National ID Number:</strong> {{ $user->personalInfo->national_id_number ?? 'N/A' }}</p>
                                    <p><strong>Gender:</strong> {{ $user->personalInfo->gender ?? 'N/A' }}</p>
                                </div>
                                <div class="col-md-6">
                                    <p><strong>Previous Surnames:</strong> {{ $user->personalInfo->previous_surnames ?? 'N/A' }}</p>
                                    <p><strong>Physical Address:</strong> {{ $user->personalInfo->physical_address ?? 'N/A' }}</p>
                                    <p><strong>Date of Birth:</strong> {{ $user->personalInfo->date_of_birth ?? 'N/A' }}</p>
                                    <p><strong>Next Of Kin Full Name:</strong> {{ $user->personalInfo->next_of_kin ?? 'N/A' }}</p>
                                    <p><strong>Next Of Kin Phone:</strong> {{ $user->personalInfo->kin_contact ?? 'N/A' }}</p>
                                    <p><strong>National ID Path:</strong>
                                        @if($user->personalInfo->national_id_path)
                                            <a href="{{ asset('storage/' . $user->personalInfo->national_id_path) }}" target="_blank">View ID</a>
                                        @else
                                            N/A
                                        @endif
                                    </p>
                                </div>
                            </div>
                        </div>

                        {{-- Qualifications --}}
                        <div class="tab-pane fade" id="qualifications" role="tabpanel">
                            <h5>Qualifications</h5>
                            @forelse($user->qualifications as $qualification)
                                <div class="mb-3 border rounded p-2">
                                    <p><strong>Award:</strong> {{ $qualification->award ?? 'N/A' }}</p>
                                    <p><strong>Year:</strong> {{ $qualification->year_obtained ?? 'N/A' }}</p>
                                    <p><strong>Institution:</strong> {{ $qualification->institution ?? 'N/A' }}</p>
                                    <p><strong>Country:</strong> {{ $qualification->certificate_country ?? 'N/A' }}</p>
                                </div>
                            @empty
                                <p>No qualifications available.</p>
                            @endforelse
                        </div>

                        {{-- Payments --}}
                        <div class="tab-pane fade" id="payments" role="tabpanel">
                            <h5>Payments</h5>
                            @forelse($user->payments as $payment)
                                <div class="mb-3 border rounded p-2">
                                    <p><strong>Processing Type:</strong> {{ $payment->processing_type ?? 'N/A' }}</p>
                                    <p><strong>Fee:</strong> {{ $payment->processing_fee ?? 'N/A' }}</p>
                                    <p><strong>Proof of Payment:</strong>
                                        @if($payment->proof_document)
                                            <a href="{{ asset('storage/' . $payment->proof_document) }}" target="_blank">View Document</a>
                                        @else
                                            N/A
                                        @endif
                                    </p>
                                </div>
                            @empty
                                <p>No payments available.</p>
                            @endforelse
                        </div>

{{-- Roles & Permissions --}}
<div class="tab-pane fade" id="roles" role="tabpanel">
    <div class="row">
        <div class="col-12 mb-2">
            <h5>Roles</h5>
            @forelse ($user->getRoleNames() as $roleName)
                <span class="badge bg-primary me-1">{{ $roleName }}</span>
            @empty
                <span class="text-muted">No Role Assigned</span>
            @endforelse
        </div>

        <div class="col-12 mb-2">
            <h5>Permissions</h5>
            @forelse ($user->getPermissionNames() as $permName)
                <span class="badge bg-info text-dark me-1">{{ $permName }}</span>
            @empty
                <span class="text-muted">No Permissions</span>
            @endforelse
        </div>

        {{-- Assign Role --}}
        <div class="col-md-6 mb-3">
            <form method="POST" action="{{ route('admin.users.assignRole', $user) }}">
                @csrf
                <label class="form-label">Assign Role</label>
                <div class="input-group">
                    <select name="role" class="form-select">
                        <option value="">Select Role…</option>
                        @foreach ($roles as $role)
                            <option value="{{ $role->name }}">{{ ucfirst($role->name) }}</option>
                        @endforeach
                    </select>
                    <button type="submit" class="btn btn-primary">Assign</button>
                </div>
            </form>
        </div>

        {{-- Remove Role --}}
        <div class="col-md-6 mb-3">
            <form method="POST" action="{{ route('admin.users.removeRole', $user) }}">
                @csrf
                <label class="form-label">Remove Role</label>
                <div class="input-group">
                    <select name="role" class="form-select">
                        <option value="">Select Role to Remove…</option>
                        @foreach ($user->getRoleNames() as $roleName)
                            <option value="{{ $roleName }}">{{ ucfirst($roleName) }}</option>
                        @endforeach
                    </select>
                    <button type="submit" class="btn btn-danger">Remove</button>
                </div>
            </form>
        </div>

        {{-- Assign Permission --}}
        <div class="col-md-6 mb-3">
            <form method="POST" action="{{ route('admin.users.givePermission', $user) }}">
                @csrf
                <label class="form-label">Assign Permission</label>
                <div class="input-group">
                    <select name="permission" class="form-select">
                        <option value="">Select Permission…</option>
                        @foreach ($permissions as $permission)
                            <option value="{{ $permission->name }}">{{ ucfirst($permission->name) }}</option>
                        @endforeach
                    </select>
                    <button type="submit" class="btn btn-primary">Give</button>
                </div>
            </form>
        </div>

        {{-- Revoke Permission --}}
        <div class="col-md-6 mb-3">
            <form method="POST" action="{{ route('admin.users.revokePermission', $user) }}">
                @csrf
                <label class="form-label">Revoke Permission</label>
                <div class="input-group">
                    <select name="permission" class="form-select">
                        <option value="">Select Permission to Revoke…</option>
                        @foreach ($user->getPermissionNames() as $permName)
                            <option value="{{ $permName }}">{{ ucfirst($permName) }}</option>
                        @endforeach
                    </select>
                    <button type="submit" class="btn btn-danger">Revoke</button>
                </div>
            </form>
        </div>
    </div>
</div>


                        {{-- Account Status --}}
                        <div class="tab-pane fade" id="account" role="tabpanel">
                            <p><strong>Created At:</strong> {{ $user->created_at->format('d M Y H:i') }}</p>
                            <p><strong>Last Updated:</strong> {{ $user->updated_at->format('d M Y H:i') }}</p>

                            <form method="POST" action="{{ route('admin.users.toggle', $user) }}">
                                @csrf
                                <button type="submit" class="btn {{ $user->is_active ? 'btn-warning' : 'btn-success' }} mt-3">
                                    {{ $user->is_active ? 'Deactivate' : 'Activate' }} User
                                </button>
                            </form>
                        </div>
                    </div> {{-- End of tab content --}}
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
