<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>View User Profile</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
@if(session('success'))
    <div class="position-fixed top-0 end-0 p-3" style="z-index: 1055;">
        <div class="toast align-items-center text-white bg-success border-0 show" role="alert">
            <div class="d-flex">
                <div class="toast-body">
                    {{ session('success') }}
                </div>
                <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
        </div>
    </div>
@endif



 

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
                            <button class="nav-link" id="applications"  data-bs-toggle="tab"
                                    data-bs-target="#account" type="button" role="tab">Recognition Panel</button>
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
    <h5 class="mb-3">Qualifications</h5>

    @forelse($user->qualifications as $qualification)
        <div class="card mb-4 shadow-sm">
            <div class="card-body">

                {{-- Qualification Info --}}
                <div class="row mb-3 align-items-center text-sm">
                    <div class="col-md-3">
                        <strong>Award:</strong> {{ $qualification->name ?? 'N/A' }}
                    </div>
                    <div class="col-md-3">
                        <strong>Institution:</strong> {{ $qualification->institution ?? 'N/A' }}
                    </div>
                    <div class="col-md-3">
                        <strong>Year:</strong> {{ $qualification->year ?? 'N/A' }}
                    </div>
                    <div class="col-md-3">
                        <strong>Country:</strong> {{ $qualification->country ?? 'N/A' }}
                    </div>
                </div>

                {{-- Related Documents --}}
                @php
                    $qualDocs = $user->applications->flatMap->documents->whereIn('type', [
                        'certificates', 'academic_records', 'previous_evaluations', 'syllabi'
                    ]);
                @endphp

                @if($qualDocs->isNotEmpty())
                    <h6 class="mb-2">Attached Documents</h6>
                    <div class="row mb-3">
                        @foreach ($qualDocs as $doc)
                            <div class="col-md-4 mb-2">
                                <div class="border rounded p-2 h-100">
                                    <p class="mb-1"><strong>{{ ucfirst(str_replace('_', ' ', $doc->type)) }}</strong></p>
                                    <a href="{{ asset('storage/' . $doc->file_path) }}" target="_blank" class="btn btn-sm btn-outline-primary w-100 mb-1">
                                        <i class="bi bi-eye"></i> View
                                    </a>
                                    <a href="{{ asset('storage/' . $doc->file_path) }}" download class="btn btn-sm btn-outline-secondary w-100">
                                        <i class="bi bi-download"></i> Download
                                    </a>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif

                {{-- Consent Form --}}
                @php
                    $consentDoc = $user->applications->flatMap->documents->where('type', 'consent_form')->first();
                @endphp

                @if($consentDoc)
                    <h6 class="mt-3">Consent Form</h6>
                    <div class="d-flex align-items-center gap-3">
                        <i class="bi bi-file-earmark-check text-success fs-4"></i>
                        <span class="flex-grow-1">Consent form is available.</span>
                        <a href="{{ asset('storage/' . $consentDoc->file_path) }}" target="_blank" class="btn btn-sm btn-outline-success">
                            View
                        </a>
                    </div>
                @endif

            </div>
        </div>
    @empty
        <p class="text-muted">No qualifications available.</p>
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
    <h5 class="mb-3">User Applications</h5>

    @if($user->applications->isEmpty())
        <p>No applications found for this user.</p>
    @else
        <div style="max-height: 600px; overflow-y: auto;">
            @foreach ($user->applications as $application)
                <div class="card mb-4 shadow-sm border">
                    <div class="card-body">
                        <div class="row mb-2">
                            <div class="col-md-4">
                                <p><strong>Application ID:</strong> {{ $application->id }}</p>
                            </div>
                            <div class="col-md-4">
                                <p><strong>Processing Type:</strong> {{ ucfirst($application->processing_type) }}</p>
                            </div>
                            <div class="col-md-4">
                                <p><strong>Status:</strong>
                                    @if ($application->status === 'validated')
                                        <span class="badge bg-success">Recognised</span>
                                    @elseif ($application->status === 'invalid')
                                        <span class="badge bg-danger">Unrecognised</span>
                                    @else
                                        <span class="badge bg-warning text-dark">Pending</span>
                                    @endif
                                </p>
                            </div>
                        </div>

                        {{-- Action Form Row --}}
                        <div class="row align-items-end">
                            {{-- Validation Form --}}
                            <div class="col-md-4">
                                <form class="validation-form" data-id="{{ $application->id }}" enctype="multipart/form-data">
                                    @csrf
                                    <label class="form-label">Validation Report (PDF)</label>
                                    <input type="file" name="validation_report" class="form-control form-control-sm mb-2" accept="application/pdf" required>

                                    <div class="mb-2">
                                        <label class="form-label">Validation Comment</label>
                                        <textarea name="validation_comment" class="form-control form-control-sm" rows="2" placeholder="Add reason..." required></textarea>
                                    </div>

                                    <div class="d-flex gap-2">
                                        <button type="submit" name="action" value="validated" class="btn btn-success btn-sm w-50">Recognize</button>
                                        <button type="submit" name="action" value="invalid" class="btn btn-danger btn-sm w-50">Unrecognize</button>
                                    </div>
                                </form>
                            </div>

                            {{-- Existing File --}}
                            <div class="col-md-4">
                                @if($application->response_report_path)
                                    <label class="form-label">Existing Report</label><br>
                                    <a href="{{ asset('storage/' . $application->response_report_path) }}" target="_blank" class="btn btn-outline-primary btn-sm">View File</a>
                                @else
                                    <p class="text-muted mt-4">No Report Uploaded</p>
                                @endif
                            </div>

                            {{-- Revert & Generate --}}
                            <div class="col-md-4">
                                <form class="revert-form" data-id="{{ $application->id }}">
                                    @csrf
                                    <label class="form-label">Change Decision</label><br>
                                    <button type="submit" class="btn btn-secondary btn-sm">Revert Status</button>
                                </form>

                                <a href="{{ route('applications.generateLetter', $application->id) }}" target="_blank" class="btn btn-success mt-2">
                                    <i class="bi bi-file-earmark-pdf"></i> Generate Validation Letter
                                </a>
                            </div>
                        </div> <!-- End row -->
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>



                    </div> {{-- End of tab content --}}
                </div>
            </div>
        </div>
    </div>
</div>
@endif

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
<script>
    // Store active tab in localStorage
    document.addEventListener('DOMContentLoaded', function () {
        const tabLinks = document.querySelectorAll('button[data-bs-toggle="tab"]');

        tabLinks.forEach(function (tab) {
            tab.addEventListener('shown.bs.tab', function (event) {
                localStorage.setItem('activeTab', event.target.getAttribute('data-bs-target'));
            });
        });

        // Reopen last active tab after reload
        const lastTab = localStorage.getItem('activeTab');
        if (lastTab) {
            const triggerEl = document.querySelector(`button[data-bs-target="${lastTab}"]`);
            if (triggerEl) new bootstrap.Tab(triggerEl).show();
        }
    });
    const toastElList = [].slice.call(document.querySelectorAll('.toast'))
toastElList.map(function (toastEl) {
    return new bootstrap.Toast(toastEl).show();
})

</script>
<script>
$(document).ready(function () {
    // Validation Form
    $('.validation-form').on('submit', function (e) {
        e.preventDefault();
        const form = $(this);
        const appId = form.data('id');
        const formData = new FormData(this);
        const action = form.find('button[type=submit][clicked=true]').val();

        formData.append('action', action);

        $.ajax({
            url: '/users/' + appId + '/validate',
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function () {
                reloadCurrentUserPanel();
            },
            error: function (xhr) {
                alert('Validation failed');
                console.error(xhr.responseText);
            }
        });
    });

    // Detect clicked button
    $('.validation-form button[type=submit]').click(function () {
        $(this).closest('form').find('button[type=submit]').removeAttr('clicked');
        $(this).attr('clicked', 'true');
    });

    // Revert Form
    $('.revert-form').on('submit', function (e) {
        e.preventDefault();
        const form = $(this);
        const appId = form.data('id');

        $.ajax({
            url: '/users/' + appId + '/revert',
            type: 'PATCH',
            data: form.serialize(),
            success: function () {
                reloadCurrentUserPanel();
            },
            error: function (xhr) {
                alert('Revert failed');
                console.error(xhr.responseText);
            }
        });
    });

    function reloadCurrentUserPanel() {
        const userId = '{{ $user->id }}';
        $.get('/admin/users/' + userId, function (html) {
            $('.main-panel').html(html);
        });
    }
});
</script>
<script>
$(document).ready(function () {
    // Setup CSRF Token
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    // Submit Validation Form via AJAX
    $('.validation-form').on('submit', function (e) {
        e.preventDefault();

        const form = $(this)[0];
        const $form = $(this);
        const appId = $form.data('id');
        const formData = new FormData(form);

        const actionValue = $form.find('button[type=submit][clicked=true]').val();
        formData.append('action', actionValue);

        $.ajax({
            url: `/users/${appId}/validate`, // Must match your route
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function () {
                reloadUserPanel();
            },
            error: function (xhr) {
                console.error(xhr.responseText);
                alert('Validation failed.');
            }
        });
    });

    // Track which button was clicked
    $('.validation-form button[type=submit]').click(function () {
        $(this).closest('form').find('button[type=submit]').removeAttr('clicked');
        $(this).attr('clicked', 'true');
    });

    // Submit Revert Form via AJAX
    $('.revert-form').on('submit', function (e) {
        e.preventDefault();

        const $form = $(this);
        const appId = $form.data('id');

        $.ajax({
            url: `/users/${appId}/revert`,
            type: 'POST',
            data: $form.serialize() + '&_method=PATCH',
            success: function () {
                reloadUserPanel();
            },
            error: function (xhr) {
                console.error(xhr.responseText);
                alert('Revert failed.');
            }
        });
    });

    // Reload user profile panel
    function reloadUserPanel() {
        const userId = '{{ $user->id }}';
        $.get(`/admin/users/${userId}`, function (html) {
            $('.main-panel').html(html);
        });
    }
});
<script><script>
$('.validation-form').on('submit', function (e) {
    e.preventDefault();

    const form = $(this);
    const formData = new FormData(this);
    const appId = form.data('id');
    const action = form.find('button[type="submit"][clicked=true]').val();

    formData.append('action', action);

    $.ajax({
        url: `/users/${appId}/validate`,
        method: 'POST',
        data: formData,
        processData: false,
        contentType: false,
        success: function (res) {
            alert('Application updated!');
            $('#account').load(window.location.href + " #account > *");
        },
        error: function (xhr) {
            alert('Failed to update application.');
            console.error(xhr.responseText);
        }
    });
});
$('.revert-form').on('submit', function (e) {
    e.preventDefault();

    const form = $(this);
    const appId = form.data('id');

    $.ajax({
        url: `/users/${appId}/revert`,
        method: 'PATCH',
        data: {},
        success: function (res) {
            alert('Status reverted.');
            $('#account').load(window.location.href + " #account > *");
        },
        error: function (xhr) {
            alert('Failed to revert status.');
            console.error(xhr.responseText);
        }
    });
});
$('#account').fadeOut(100, function () {
    $(this).load(window.location.href + " #account > *", function () {
        $(this).fadeIn(100);
    });
});
</script>
<script>
    $(document).ready(function () {
        // Submit validation (recognize/unrecognize)
        $('.validation-form').on('submit', function (e) {
            e.preventDefault();

            let form = $(this)[0];
            let formData = new FormData(form);
            let appId = $(this).data('id');
            let action = $(this).find('[type="submit"][clicked=true]').val();

            formData.append('action', action);

            $.ajax({
                url: '/users/' + appId + '/validate',
                method: 'POST',
                data: formData,
                contentType: false,
                processData: false,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function (res) {
                    // Dynamically reload only the tab pane
                    $('#account').load(window.location.href + " #account > *");
                },
                error: function (xhr) {
                    alert('Error: ' + xhr.responseText);
                }
            });
        });

        // Capture which button was clicked
        $('.validation-form button[type="submit"]').on('click', function () {
            $('[type="submit"]', $(this).closest('form')).removeAttr('clicked');
            $(this).attr('clicked', 'true');
        });

        // Submit revert form
        $('.revert-form').on('submit', function (e) {
            e.preventDefault();

            let appId = $(this).data('id');

            $.ajax({
                url: '/users/' + appId + '/revert',
                method: 'POST',
                data: {
                    _token: $('meta[name="csrf-token"]').attr('content'),
                    _method: 'PATCH'
                },
                success: function () {
                    $('#account').load(window.location.href + " #account > *");
                },
                error: function (xhr) {
                    alert('Error: ' + xhr.responseText);
                }
            });
        });
    });
</script>

</body>
</html>
