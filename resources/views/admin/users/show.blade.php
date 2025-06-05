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
            <div class="row g-4">
                {{-- Profile Picture --}}
             <div class="row">
    <!-- Sidebar with Profile Info -->
    <div class="col-md-3">
        <div class="card text-center bg-light h-100">
            <div class="card-body">
                @if($user->personalInformation)
                    <img src="{{ asset('storage/' . $user->personalInfo->profile_picture) }}"
                         alt="Avatar" class="rounded-circle mb-3" width="100" height="100">
                @else
                    <img src="{{ asset('images/avatar-placeholder.png') }}"
                         alt="Avatar" class="rounded-circle mb-3" width="100" height="100">
                @endif

                <!-- Status -->
                <p>
                    <strong>Status:</strong><br>
                    @if ($user->is_active)
                        <span class="badge bg-success">Active</span>
                    @else
                        <span class="badge bg-secondary">Inactive</span>
                    @endif
                </p>

                <!-- Certificate -->
                <p>
                    <strong>Certificate:</strong><br>
                    @if ($user->certificate_validated ?? false)
                        <span class="badge bg-success">Validated</span>
                    @else
                        <span class="badge bg-warning text-dark">Not Validated</span>
                    @endif
                </p>

                <!-- Roles -->
                <p>
                    <strong>Role(s):</strong><br>
                    @forelse ($user->getRoleNames() as $roleName)
                        <span class="badge bg-primary mb-1 d-block">{{ $roleName }}</span>
                    @empty
                        <span class="text-muted">No Role Assigned</span>
                    @endforelse
                </p>
            </div>
        </div>
    </div>

    <!-- User Details Card -->
    <div class="col-md-9">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <!-- Left Column -->
                    <div class="col-md-6">
                        <p><strong>Name:</strong> {{ $user->name }}</p>
                        <p><strong>Email:</strong> {{ $user->email }}</p>
                        <p><strong>Title:</strong> {{ $user->personalInfo->title ?? 'N/A' }}</p>
                        <p><strong>Phone Number:</strong> {{ $user->personalInfo->contact_address ?? 'N/A' }}</p>   
                        <p><strong>Country:</strong> {{ $user->personalInfo->country }}</p>
                        <p><strong>National ID Number:</strong> {{ $user->personalInfo->national_id_number ?? 'N/A' }}</p>
                                           <p><strong>Gender:</strong> {{ $user->personalInfo->gender ?? 'N/A' }}</p>

                    </div>

                    <!-- Right Column -->
                    <div class="col-md-6">
                        <p><strong>Previous Surnames:</strong> {{ $user->personalInfo->previous_surnames ?? 'N/A' }}</p>
                        <p><strong>Physical Address:</strong> {{ $user->personalInfo->physical_address ?? 'N/A' }}</p>
                        <p><strong>Date of Birth:</strong> {{ $user->personalInfo->date_of_birth ?? 'N/A' }}</p>
                        <p><strong>Next Of Kin Full Name:</strong> {{ $user->personalInfo->next_of_kin ?? 'N/A' }}</p>
                        <p><strong>Next Of Kin Phone Number:</strong> {{ $user->personalInfo->kin_contact ?? 'N/A' }}</p>
                        <p><strong>National ID Path:</strong>
                            @if($user->personalInfo && $user->personalInfo->national_id_path)
                                <a href="{{ asset('storage/' . $user->personalInfo->national_id_path) }}" target="_blank">View ID</a>
                            @else
                                N/A
                            @endif
                        </p>
                    </div>
                </div>

                <!-- Permissions -->
                <p class="mt-3">
                    <strong>Permissions:</strong><br>
                    @forelse ($user->getPermissionNames() as $permName)
                        <span class="badge bg-info text-dark mb-1">{{ $permName }}</span>
                    @empty
                        <span class="text-muted">No Permissions</span>
                    @endforelse
                </p>
            </div>
        </div>
    </div>
</div>

 


{{-- Payments & Management Card --}}
<div class="card mb-4 p-4 shadow-sm bg-white">
    <div class="d-flex flex-column">

        {{-- Qualifications & Payments Side by Side --}}
        <div class="row mb-4">
            {{-- Qualifications --}}
            <div class="col-md-6">
                <h4>Qualifications</h4>
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
            <div class="col-md-6">
                <h4>Payments</h4>
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
        </div>

        {{-- Timestamps --}}
        <div class="mb-4">
            <p class="mb-1"><strong>Created At:</strong> {{ $user->created_at->format('d M Y H:i') }}</p>
            <p class="mb-0"><strong>Last Updated:</strong> {{ $user->updated_at->format('d M Y H:i') }}</p>
        </div>

        <hr class="my-4">

        {{-- Management Actions --}}
        <div class="row gy-3">
            {{-- Activate / Deactivate --}}
            <div class="col-md-6">
                <form method="POST" action="{{ route('admin.users.toggle', $user) }}">
                    @csrf
                    <button type="submit" class="btn {{ $user->is_active ? 'btn-warning' : 'btn-success' }} w-100">
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
                        <button type="submit" class="btn btn-primary">Assign</button>
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
                        <button type="submit" class="btn btn-danger">Remove</button>
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
                        <button type="submit" class="btn btn-secondary">Assign</button>
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
        </div>
</div>
    </div>
     


</body>
<style>
 

body {
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
}

.card-body {
    padding: 2rem;
}

/* Flex container for main user info (picture + details) */
.card-body > .row.g-4 {
    display: flex;
    flex-wrap: wrap;
    align-items: flex-start;
    gap: 2rem;
}

/* Profile Picture container */
.card-body > .row.g-4 > div.col-md-3 {
    flex: 0 0 150px;
    max-width: 150px;
}

/* User Details */
.card-body > .row.g-4 > div.col-md-9 {
    flex: 1 1 60%;
}

/* Split details into two columns */
.card-body > .row.g-4 .col-md-9 > .row > div {
    padding-right: 1rem;
}

/* Badge styling: consistent spacing */
.badge {
    margin-right: 0.35rem;
    margin-bottom: 0.35rem;
}

/* Section headings */
.card-body h4 {
    border-bottom: 5px solid #0d6efd;
    width:150px;
    padding-bottom: 0.5rem;
      font-weight: 600;
    color: #0d6efd;
}

/* Qualifications and Payments: side-by-side details */
.card-body .mb-4 > .row > div {
    padding-right: 1.5rem;
}

 
/* Form input groups - spaced nicely */
.row.gy-3 .input-group {
    gap: 0.5rem;
}

/* Responsive tweaks */
@media (max-width: 767.98px) {
    .card-body > .row.g-4 {
        flex-direction: column;
    }
    .card-body > .row.g-4 > div.col-md-3,
    .card-body > .row.g-4 > div.col-md-9 {
        max-width: 100%;
        flex: 1 1 100%;
    }
}
 

</style>
</html>
