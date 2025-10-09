@extends('admin-dashboard')
@section('content')
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Application Details</title> 
<script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        body { background-color: #f8f9fa; }
        .theme-primary { background-color: #52074f; color: #fff; }
        .nav-tabs .nav-item { flex: 1 1 33%; text-align: center; }
        .nav-tabs .nav-link { width: 100%; border-radius: 0; }
        .nav-tabs .nav-link.active { background-color: #52074f; color: #fff; }
        .h-100 { height: 100% !important; }
    </style>
</head>
<body>
<div class="container mt-4">
    <div class="d-flex align-items-center justify-content-between mb-4">
        <h4 class="fw-bold text-dark mb-0">
            <i class="bi bi-folder-check text-primary me-2"></i>
            Application #{{ $application->id }} Details
        </h4>
    </div>

@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show mt-3" role="alert">
        <i class="bi bi-check-circle me-2"></i>
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif  {{-- Tabs --}}
<div class="row">
    <div class="col-12">
        <ul class="nav nav-tabs d-flex flex-wrap justify-content-between text-center mb-4" role="tablist" style="gap: 0.25rem;">
            <li class="nav-item flex-fill" role="presentation">
                <button class="nav-link active" id="summary-tab" data-bs-toggle="tab" data-bs-target="#summary" type="button" role="tab">
                    Summary
                </button>
            </li>
            <li class="nav-item flex-fill" role="presentation">
                <button class="nav-link" id="payments-tab" data-bs-toggle="tab" data-bs-target="#payments" type="button" role="tab">
                    Payments
                </button>
            </li>
            <li class="nav-item flex-fill" role="presentation">
                <button class="nav-link" id="docs-tab" data-bs-toggle="tab" data-bs-target="#documents" type="button" role="tab">
                    Documents
                </button>
            </li>
            <li class="nav-item flex-fill" role="presentation">
                <button class="nav-link" id="recognition-tab" data-bs-toggle="tab" data-bs-target="#recognition" type="button" role="tab">
                    Recognition
                </button>
            </li>
       
<li class="nav-item flex-fill" role="presentation">
                <button class="nav-link" id="additionalinfo-tab" data-bs-toggle="tab" data-bs-target="#additionalinfo" type="button" role="tab">
                    Additional Info
                </button>
            </li>
        </ul>
    </div>
</div>
 @php
    $activeTab = request('tab', 'details');
@endphp


<div class="tab-content">

    {{-- Summary --}}
    <div class="tab-pane fade show active" id="summary" role="tabpanel">
        {{-- Application Summary --}}
        <div class="card shadow-sm border-0 mb-4">
            <div class="card-header bg-white border-bottom">
                <h5 class="mb-0 text-primary fw-semibold">
                    <i class="bi bi-person-badge me-2"></i>Application Summary
                </h5>
            </div>
            <div class="card-body">
                <div class="row gy-4">
                    <div class="col-md-3">
                        <small class="text-muted">Processing Type</small>
                        <div class="fw-semibold text-dark">{{ ucfirst($application->processing_type) }}</div>
                    </div>
                    <div class="col-md-3">
                        <small class="text-muted">Nationality</small>
                        <div class="fw-semibold text-dark">{{ ucfirst($application->nationality) }}</div>
                    </div>
                    <div class="col-md-3">
                        <small class="text-muted">Status</small>
                        <div>
                            @if ($application->status === 'validated')
                                <span class="badge bg-success px-3 py-2">Recognised</span>
                            @elseif($application->status === 'invalid')
                                <span class="badge bg-danger px-3 py-2">Unrecognised</span>
                            @else
                                <span class="badge bg-warning text-dark px-3 py-2">Pending</span>
                            @endif
                        </div>
                    </div>
                    @if($application->status !== 'pending' && $application->validation_comment)
                        <div class="col-md-3">
                            <small class="text-muted">Review Comment</small>
                            <div class="alert alert-info p-2 mt-1" style="font-size:0.9rem;">
                                {{ $application->validation_comment }}
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        {{-- Qualifications --}}
        <div class="card shadow-sm border-0 mb-4">
            <div class="card-header bg-white border-bottom">
                <h5 class="mb-0 text-primary fw-semibold">
                    <i class="bi bi-award me-2"></i>Qualifications to Assess
                </h5>
            </div>
            <div class="card-body">
                @forelse($application->qualifications as $q)
                    <div class="border rounded p-3 mb-3 bg-light">
                        <div class="row">
                            <div class="col-md-3"><strong>Award:</strong> {{ $q->name }}</div>
                            <div class="col-md-3"><strong>Program:</strong> {{ $q->program_name }}</div>
                            <div class="col-md-3"><strong>Institution:</strong> {{ $q->institution }}</div>
                            <div class="col-md-3"><strong>Year:</strong> {{ $q->year }}</div>
                        </div>
                    </div>
                @empty
                    <p class="text-muted">No qualifications available.</p>
                @endforelse
            </div>
        </div>

        {{-- Education History --}}
        <div class="card shadow-sm border-0 mb-4">
            <div class="card-header bg-white border-bottom">
                <h5 class="mb-0 text-primary fw-semibold">
                    <i class="bi bi-journal-bookmark me-2"></i>Education History
                </h5>
            </div>
            <div class="card-body">
                @forelse($application->educationHistories as $history)
                    <div class="border rounded p-3 mb-3 bg-light">
                        <div class="row">
                            <div class="col-md-3"><strong>Qualification:</strong> {{ $history->name }}</div>
                            <div class="col-md-3"><strong>Year:</strong> {{ $history->year }}</div>
                            <div class="col-md-3"><strong>Institution:</strong> {{ $history->institution }}</div>
                            <div class="col-md-3"><strong>Country:</strong> {{ $history->country }}</div>
                        </div>
                    </div>
                @empty
                    <p class="text-muted">No education history available.</p>
                @endforelse
            </div>
        </div>
    </div>

    {{-- Payments --}}
    <div class="tab-pane fade" id="payments" role="tabpanel">
        @if(!$user->hasRole('admin'))
            <table class="table table-bordered table-striped">
                <thead class="theme-primary">
                    <tr>
                        <th>#</th>
                        <th>Processing Type</th>
                        <th>Fee (MWK)</th>
                        <th>Proof</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $applicationInvoices = $user->invoices->where('application_id', $application->id);
                    @endphp

                    @forelse($applicationInvoices as $i)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $i->processing_type ?? 'N/A' }}</td>
                            <td>{{ number_format($i->fee ?? 0) }}</td>
                            <td>
                                @if($i->proof_path)
                                    <a href="{{ asset('storage/' . $i->proof_path) }}" target="_blank" class="btn btn-sm btn-outline-primary">View</a>
                                @else
                                    <span class="text-muted">N/A</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="text-center text-muted">No payments found for this application.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        @endif
    </div>

    {{-- Documents --}}
    <div class="tab-pane fade" id="documents" role="tabpanel">
        <div class="row">
            @forelse($application->documents as $doc)
                <div class="col-md-4 mb-4">
                    <div class="border rounded h-100 p-3 d-flex flex-column justify-content-between bg-light">
                        <h6 class="fw-semibold"><i class="bi bi-file-earmark me-2"></i>{{ ucfirst(str_replace('_',' ',$doc->type)) }}</h6>
                        <div>
                            <a href="{{ asset('storage/'.$doc->file_path) }}" target="_blank" class="btn btn-sm btn-outline-primary mb-2 w-100">View</a>
                            <a href="{{ asset('storage/'.$doc->file_path) }}" download class="btn btn-sm btn-outline-secondary w-100">Download</a>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12"><p class="text-muted">No documents uploaded.</p></div>
            @endforelse
        </div>
    </div>

    {{-- Recognition --}}
    <div class="tab-pane fade" id="recognition" role="tabpanel" aria-labelledby="recognition-tab">
        <div class="card shadow-sm border-0 mb-4">
            <div class="card-header bg-white border-bottom d-flex justify-content-between align-items-center">
                <h5 class="mb-0 text-primary fw-semibold">
                    <i class="bi bi-check2-square me-2"></i>Validation Action
                </h5>
                <div id="loadingSpinner" style="display: none;">
                    <div class="spinner-border text-primary" role="status" style="width: 1.5rem; height: 1.5rem;"></div>
                </div>
            </div>

            <div class="card-body">
                <form id="recognitionForm" enctype="multipart/form-data">
                    @csrf

                    <div class="mb-3">
                        <label class="form-label">Upload Validation Report (PDF)</label>
                        <input type="file" name="validation_report" class="form-control" accept="application/pdf" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Comment</label>
                        <textarea name="validation_comment" class="form-control" rows="3" placeholder="Add validation feedback" required></textarea>
                    </div>

                    <div class="d-flex gap-2">
                        <button type="button" onclick="submitRecognition('validated')" class="btn btn-success w-50">
                            <i class="bi bi-check-circle"></i> Recognise
                        </button>
                        <button type="button" onclick="submitRecognition('invalid')" class="btn btn-danger w-50">
                            <i class="bi bi-x-circle"></i> Unrecognise
                        </button>
                    </div>
                </form>

                <hr class="my-4">

                @if ($application->response_report_path)
                    <div class="mt-4">
                        <p><strong>Existing Report:</strong></p>
                        <a href="{{ asset('storage/' . $application->response_report_path) }}" target="_blank" class="btn btn-outline-primary btn-sm">
                            <i class="bi bi-eye"></i> View Report
                        </a>
                    </div>
                @endif

                <div class="mt-3">
                    <form id="revertForm">
                        @csrf
                        <button type="button" onclick="submitRevert()" class="btn btn-secondary btn-sm">
                            <i class="bi bi-arrow-counterclockwise"></i> Revert to Pending
                        </button>
                    </form>

                    <a href="{{ route('applications.generateLetter', $application->id) }}" target="_blank" class="btn btn-outline-success btn-sm mt-2">
                        <i class="bi bi-file-earmark-pdf"></i> Generate Validation Letter
                    </a>
                </div>
            </div>
        </div>
    </div>

    {{-- Additional Info --}}
   <div class="tab-pane fade" id="additionalinfo" role="tabpanel" aria-labelledby="additionalinfo-tab">

    <style>
        /* ===== WhatsApp-Like Chat Style (NCHE Theme) ===== */
        .chat-container {
            background: #f7f7f7;
            border-radius: 12px;
            padding: 20px;
            max-height: 500px;
            overflow-y: auto;
            box-shadow: 0 2px 6px rgba(0,0,0,0.1);
        }

        .chat-message {
            display: flex;
            margin-bottom: 15px;
        }

        .chat-message.admin {
            justify-content: flex-start;
        }

        .chat-message.applicant {
            justify-content: flex-end;
        }

        .message-bubble {
            max-width: 75%;
            padding: 10px 15px;
            border-radius: 16px;
            position: relative;
            font-size: 0.95rem;
            line-height: 1.4;
        }

        .admin .message-bubble {
            background-color: #52074f;
            color: #fff;
            border-bottom-left-radius: 4px;
        }

        .applicant .message-bubble {
            background-color: #dd8027;
            color: #fff;
            border-bottom-right-radius: 4px;
        }

        .chat-message small {
            display: block;
            margin-top: 4px;
            font-size: 0.75rem;
            opacity: 0.8;
        }

        .chat-input-box {
            border-top: 1px solid #ddd;
            padding-top: 10px;
        }

        .chat-input-box textarea {
            resize: none;
            border-radius: 10px;
        }

        .chat-input-box button {
            background-color: #dd8027;
            border: none;
            color: white;
            border-radius: 50%;
            width: 45px;
            height: 45px;
            margin-left: 8px;
            transition: 0.3s;
        }

        .chat-input-box button:hover {
            background-color: #52074f;
        }

        .chat-header {
            color: #52074f;
            font-weight: 600;
            margin-bottom: 10px;
            display: flex;
            align-items: center;
        }

        .chat-header i {
            color: #dd8027;
            margin-right: 8px;
        }

        .file-btn {
            display: inline-block;
            font-size: 0.85rem;
            margin-top: 5px;
            color: #fff;
            background: #52074f;
            border: none;
            padding: 4px 10px;
            border-radius: 8px;
            text-decoration: none;
        }

        .file-btn:hover {
            background: #dd8027;
            color: #fff;
        }
    </style>

    <!-- Header -->
    <div class="chat-header">
        <i class="bi bi-info-circle"></i> Request Additional Info
    </div>

    <!-- Chat History -->
    <div class="chat-container mb-3">
        @forelse($application->additionalInfoRequests as $req)
            <div class="chat-message admin">
                <div class="message-bubble">
                    <strong><i class="bi bi-person-badge"></i> {{ $req->admin->name }}</strong><br>
                    {{ $req->message }}
                    <small>Status: {{ ucfirst($req->status) }}</small>
                </div>
            </div>

            @if($req->response || $req->response_file_path)
                <div class="chat-message applicant">
                    <div class="message-bubble">
                        <strong><i class="bi bi-person-circle"></i> Applicant</strong><br>
                        {{ $req->response ?? 'No text response' }}
                        @if($req->response_file_path)
                            <br><a href="{{ Storage::url($req->response_file_path) }}" target="_blank" class="file-btn">
                                <i class="bi bi-paperclip"></i> View File
                            </a>
                        @endif
                    </div>
                </div>
            @endif
        @empty
            <p class="text-muted text-center mt-3">No additional info requests yet.</p>
        @endforelse
    </div>

    <!-- Input Box -->
    <form action="{{ route('applications.request-info', $application->id) }}" method="POST" class="chat-input-box d-flex align-items-center">
        @csrf
        <textarea name="message" class="form-control" rows="2" placeholder="Type your request..." required></textarea>
        <button type="submit"><i class="bi bi-send"></i></button>
    </form>
</div>


</div>


<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
 
<script>
function submitRecognition(action) {
    var form = $('#recognitionForm')[0];
    var formData = new FormData(form);
    formData.append('action', action);

    // Show spinner before AJAX
    $('#loadingSpinner').show();

    $.ajax({
        url: "{{ route('admin.applicants.validateUser', $application->id) }}",
        method: "POST",
        data: formData,
        processData: false,
        contentType: false,
        success: function(response) {
            $('#loadingSpinner').hide();
            alert('Action completed successfully!');

            // Reload the application details view into main panel
            $.get("{{ route('admin.applicants.viewApplication', [$user->id, $application->id]) }}", function(data) {
                $('.main-panel').html(data);
            });
        },
        error: function(xhr) {
            $('#loadingSpinner').hide();
            alert('Something went wrong. Please Fill the comment section.');
            console.error(xhr);
        }
    });
}

function submitRevert() {
    // Show spinner before AJAX
    $('#loadingSpinner').show();

    $.ajax({
        url: "{{ route('admin.applicants.revertStatus', $application->id) }}",
        method: "POST",
        data: $('#revertForm').serialize(),
        success: function(response) {
            $('#loadingSpinner').hide();
            alert('Status reverted to pending!');

            $.get("{{ route('admin.applicants.viewApplication', [$user->id, $application->id]) }}", function(data) {
                $('.main-panel').html(data);
            });
        },
        error: function(xhr) {
            $('#loadingSpinner').hide();
            alert('Failed to revert status.');
            console.error(xhr);
        }
    });
}
</script>
 
<style>

    .nav-tabs .nav-link {
    border-radius: 0;
    font-weight: 500;
}

</style>
</body>
</html>
@endsection