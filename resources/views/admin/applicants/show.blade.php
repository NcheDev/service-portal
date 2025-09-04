<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Application Details</title>
    <!-- Bootstrap CSS -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" 
      rel="stylesheet" 
      integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" 
      crossorigin="anonymous">

<!-- Bootstrap JS Bundle -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" 
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" 
        crossorigin="anonymous"></script>

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

    {{-- Tabs --}}
  {{-- Tabs --}}
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
        </ul>
    </div>
</div>



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
    </div>


    {{-- Recognition Tab --}}
<div class="tab-pane fade" id="recognition" role="tabpanel" aria-labelledby="recognition-tab">
    {{-- Recognition Panel --}}
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

<h5 class="fw-semibold text-primary">
    <i class="bi bi-info-circle me-2"></i> Request Additional Info
</h5>

<form action="{{ route('applications.request-info', $application->id) }}" method="POST">
    @csrf
    <textarea name="message" class="form-control mb-2" rows="3" placeholder="Describe what additional info you need..." required></textarea>
    <button type="submit" class="btn btn-warning">
        <i class="bi bi-envelope-plus"></i> Send Request
    </button>
</form>

<hr class="my-4">

<h5 class="fw-semibold text-primary">
    <i class="bi bi-clock-history me-2"></i> Requests History
</h5>

@forelse($application->additionalInfoRequests as $req)
    <div class="border rounded p-3 mb-3 bg-light">
        <p><strong>Admin:</strong> {{ $req->admin->name }}</p>
        <p><strong>Request:</strong> {{ $req->message }}</p>
        <p><strong>Status:</strong> <span class="badge bg-secondary">{{ ucfirst($req->status) }}</span></p>

          {{-- Applicant Response --}}
        @if($req->response || $req->response_file_path)
            <div class="mt-2">
                <p><strong>Applicant Response:</strong> {{ $req->response ?? 'No text response' }}</p>

                @if($req->response_file_path)<a href="{{ Storage::url($req->response_file_path) }}" target="_blank" class="btn btn-sm btn-outline-primary mt-1">
    View File
</a>

                @endif
            </div>
        @else
            <p class="text-muted mt-2">Awaiting applicant response...</p>
        @endif
    </div>
@empty
    <p class="text-muted">No additional info requests yet.</p>
@endforelse


            {{-- Existing report --}}
            @if ($application->response_report_path)
                <div class="mt-4">
                    <p><strong>Existing Report:</strong></p>
                    <a href="{{ asset('storage/' . $application->response_report_path) }}" target="_blank" class="btn btn-outline-primary btn-sm">
                        <i class="bi bi-eye"></i> View Report
                    </a>
                </div>
            @endif

            {{-- Revert + Generate --}}
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
            alert('Something went wrong. Please check your input.');
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
