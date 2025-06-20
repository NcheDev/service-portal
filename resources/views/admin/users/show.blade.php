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
                            <p><strong>Certificate Evaluation Results:</strong><br>
                                @if ($user->status === 'validated')
                                    <span class="badge bg-success">Recognised</span>
                                @elseif ($user->status === 'invalid')
                                    <span class="badge bg-danger">Unrecognised</span>
                                @else
                                    <span class="badge bg-warning text-dark">Pending</span>
                                @endif
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

                {{-- Admin Profile Overview --}}
                @if ($user->hasRole('admin'))
                <div class="col-md-9">
                    <div class="card shadow-sm p-4 mb-4 border-0 rounded-3 h-100">
                        <h4 class="mb-4">🛡️ Admin Profile Overview</h4>

                        <div class="mb-3">
                            <p class="mb-1"><strong>Name:</strong> {{ $user->name }}</p>
                            <p class="mb-1"><strong>Email:</strong> {{ $user->email }}</p>
                        </div>

                        <div class="mb-3">
                            <strong>Roles:</strong><br>
                            @foreach ($user->getRoleNames() as $role)
                                <span class="badge bg-primary me-1">{{ ucfirst($role) }}</span>
                            @endforeach
                        </div>

                        <div class="mb-3">
                            <strong>Permissions:</strong><br>
                            @forelse ($user->getAllPermissions() as $perm)
                                <span class="badge bg-info text-dark me-1">{{ $perm->name }}</span>
                            @empty
                                <span class="text-muted">No permissions assigned.</span>
                            @endforelse
                        </div>

                        <div class="row">
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
                                        <button type="submit" class="btn btn-outline-primary">Assign</button>
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
                                            @foreach ($user->getRoleNames() as $role)
                                                <option value="{{ $role }}">{{ ucfirst($role) }}</option>
                                            @endforeach
                                        </select>
                                        <button type="submit" class="btn btn-outline-danger">Remove</button>
                                    </div>
                                </form>
                            </div>
                        </div>

                        {{-- Activate/Deactivate --}}
                        <form method="POST" action="{{ route('admin.users.toggle', $user) }}">
                            @csrf
                            <button type="submit" class="btn {{ $user->is_active ? 'btn-warning' : 'btn-success' }} w-100 mt-2">
                                {{ $user->is_active ? 'Deactivate Admin' : 'Activate Admin' }}
                            </button>
                        </form>
                    </div>
                </div>
               
            </div> {{-- End row --}}
        </div> {{-- End card-body --}}
    </div> {{-- End outer card --}}
</div> {{-- End container --}}

@else
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
                                    <p><strong>Country:</strong> {{ $user->personalInfo->country ?? 'N/A'}}</p>
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
                                      @if($user->personalInfo?->national_id_path)
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
        <div class="mb-3 border rounded p-3">
            <div class="row mb-2">
                <div class="col-md-6">
                    <p><strong>Award:</strong> {{ $qualification->name ?? 'N/A' }}</p>
                    <p><strong>Institution:</strong> {{ $qualification->institution ?? 'N/A' }}</p>
                </div>
                <div class="col-md-6">
                    <p><strong>Year Obtained:</strong> {{ $qualification->year ?? 'N/A' }}</p>
                    <p><strong>Country:</strong> {{ $qualification->country ?? 'N/A' }}</p>
                </div>
            </div>

            {{-- Fetch and display qualification-related documents --}}
           @php
    $qualificationDocs = $user->applications->flatMap->documents->whereIn('type', [
        'certificates', 'academic_records', 'previous_evaluations', 'syllabi'
    ]);
@endphp
@php
    // Flatten all documents from all user's applications
    $allDocs = $user->applications->flatMap->documents;

    // Filter only qualification-related documents
    $qualDocs = $allDocs->whereIn('type', [
        'certificates', 'academic_records', 'previous_evaluations', 'syllabi'
    ]);
@endphp

            @if($qualDocs->isNotEmpty())
                <hr>
                <div class="mt-2">
                    <h6>Attached Documents</h6>
                    <div class="row">
                    @foreach ($user->applications->flatMap->documents as $doc)
        <div class="mb-3 p-2 border rounded">
            <p><strong>Type:</strong> {{ ucfirst(str_replace('_', ' ', $doc->type)) }}</p>
            <a href="{{ asset('storage/' . $doc->file_path) }}" class="btn btn-sm btn-outline-primary" target="_blank">
                <i class="mdi mdi-file-document"></i> View Document
            </a>
        </div>
    @endforeach
                    </div>
                </div>
            @endif

            {{-- Consent Form --}}
            @php
                $consentDoc = $user->applications->flatMap->documents->where('type', 'consent_form')->first();
            @endphp

            @if($consentDoc)
                <hr>
                <div class="mt-2">
                    <h6>Consent Form</h6>
                    <div class="d-flex align-items-center">
                        <i class="mdi mdi-file-document-outline me-2 text-success fs-5"></i>
                        <span class="me-2">Consent Form:</span>
                        <a href="{{ asset('storage/' . $consentDoc->file_path) }}" class="btn btn-sm btn-outline-success ms-auto" target="_blank">
                            View
                        </a>
                    </div>
                </div>
            @endif
        </div>
    @empty
        <p>No qualifications available.</p>
    @endforelse
</div>


                       {{-- Payments --}}
@if(!$user->hasRole('admin'))
    <div class="tab-pane fade" id="payments" role="tabpanel">
        <h5>Payments</h5>
        @forelse($user->invoices as $invoice)
            <div class="mb-3 border rounded p-3 shadow-sm bg-light">
                <p><strong>Processing Type:</strong> {{ $invoice->processing_type ?? 'N/A' }}</p>
                <p><strong>Fee:</strong> MWK {{ number_format($invoice->fee ?? 0) }}</p>
                <p><strong>Proof of Payment:</strong>
                    @if($invoice->proof_path)
                        <a href="{{ asset('storage/' . $invoice->proof_path) }}" target="_blank" class="btn btn-sm btn-outline-primary">
                            View Document
                        </a>
                    @else
                        <span class="text-muted">N/A</span>
                    @endif
                </p>
            </div>
        @empty
            <p class="text-muted">No invoices available.</p>
        @endforelse
    </div>
@endif


{{-- Roles & Permissions --}}
<div class="tab-pane fade" id="roles" role="tabpanel">
    <div class="row">
        {{-- Roles --}}
        <div class="col-12 mb-2">
            <h5>Roles</h5>
            @forelse ($user->getRoleNames() as $roleName)
                <span class="badge bg-primary me-1">{{ $roleName }}</span>
            @empty
                <span class="text-muted">No Role Assigned</span>
            @endforelse
        </div>

        {{-- Permissions --}}
        <div class="col-12 mb-2">
            <h5>Permissions</h5>
            @forelse ($user->getAllPermissions() as $perm)
                <span class="badge bg-info text-dark me-1">{{ $perm->name }}</span>
            @empty
                <span class="text-muted">No Permissions</span>
            @endforelse
        </div>

        @if(!$user->hasRole('admin'))
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
        @endif
    </div>
</div>



                      <div class="tab-pane fade" id="account" role="tabpanel">
    <p><strong>Created At:</strong> {{ $user->created_at->format('d M Y H:i') }}</p>
    <p><strong>Last Updated:</strong> {{ $user->updated_at->format('d M Y H:i') }}</p>

    {{-- Activate/Deactivate --}}
    <form method="POST" action="{{ route('admin.users.toggle', $user) }}">
        @csrf
        <button type="submit" class="btn {{ $user->is_active ? 'btn-warning' : 'btn-success' }} mt-3">
            {{ $user->is_active ? 'Deactivate' : 'Activate' }} User
        </button>
    </form>

 {{-- Validation Section --}}
@if($user->status === 'pending')
    <hr>
    <form method="POST" action="{{ route('admin.users.validate', $user) }}" enctype="multipart/form-data" class="mt-3">
        @csrf
        <div class="mb-3">
            <label class="form-label">Validation Report (PDF)</label>
            <input type="file" name="validation_report" class="form-control" accept="application/pdf" required>
        </div>
        <div class="d-flex gap-2">
            <button type="submit" name="action" value="validated" class="btn btn-success">
                Recognize (Approve)
            </button>
            <button type="submit" name="action" value="invalid" class="btn btn-danger">
                Unrecognize (Reject)
            </button>
        </div>
    </form>

@else
    <p><strong>Status:</strong> 
        <span class="badge 
            @if($user->status === 'validated') bg-success 
            @elseif($user->status === 'invalid') bg-danger 
            @endif">
            {{ ucfirst($user->status) }}
        </span>

        @if($user->response_report_path)
            <a href="{{ asset('storage/' . $user->response_report_path) }}" target="_blank" class="btn btn-sm btn-outline-secondary ms-2">
                View Validation Report
            </a>
        @endif
    </p>

    {{-- Revert Button --}}
    <form method="POST" action="{{ route('admin.users.revertStatus', $user) }}" class="mt-2">
        @csrf
        @method('PATCH')
        <button class="btn btn-outline-secondary btn-sm">
            Undo (Revert to Pending)
        </button>
    </form>
@endif


                    </div> {{-- End of tab content --}}
                </div>
            </div>
        </div>
    </div>
</div>
@endif
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
