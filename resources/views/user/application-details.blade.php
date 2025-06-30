<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">

<div class="main-card">
    <div class="container py-4">
        <h4 class="mb-4">Application Details</h4>

        {{-- Summary --}}
        <div class="row mb-4">
            <div class="col-md-3 col-sm-6 col-12 mb-2"><strong>Processing Type:</strong><br> {{ ucfirst($application->processing_type) }}</div>
            <div class="col-md-3 col-sm-6 col-12 mb-2"><strong>Nationality:</strong><br> {{ $application->nationality }}</div>
            <div class="col-md-3 col-sm-6 col-12 mb-2"><strong>Status:</strong><br>
                @if($application->status === 'validated')
                    <span class="badge bg-success">Recognised</span>
                @elseif($application->status === 'invalid')
                    <span class="badge bg-danger">Unrecognised</span>
                @else
                    <span class="badge bg-warning text-dark">Pending</span>
                @endif
            </div>
        </div>

        {{-- Tabs --}}
        <ul class="nav nav-tabs mb-3" id="docTab" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link active" id="cert-tab" data-bs-toggle="tab" data-bs-target="#cert" type="button" role="tab">Certificate</button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="payment-tab" data-bs-toggle="tab" data-bs-target="#payment" type="button" role="tab">Proof of Payment</button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="consent-tab" data-bs-toggle="tab" data-bs-target="#consent" type="button" role="tab">Consent Form</button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="feedback-tab" data-bs-toggle="tab" data-bs-target="#feedback" type="button" role="tab">Admin Feedback</button>
            </li>
        </ul>

        <div class="tab-content" id="docTabContent">

            {{-- Certificate --}}
            <div class="tab-pane fade show active" id="cert" role="tabpanel">
                <div class="card mb-3">
                    <div class="card-header bg-primary text-white">Certificate to be Verified</div>
                    <div class="card-body row">
                        @if($certificate = $application->documents->where('type', 'certificates')->first())
                            <div class="col-md-3 col-sm-6 col-12 d-flex align-items-center mb-2">
                                <i class="bi bi-file-earmark-pdf-fill text-danger fs-4 me-2"></i>
                                <span class="file-name">{{ basename($certificate->file_path) }}</span>
                            </div>
                            <div class="col-md-3 col-sm-6 col-12 mb-2">
                                <a href="{{ asset('storage/' . $certificate->file_path) }}" target="_blank" class="btn btn-outline-primary btn-sm w-100 mb-1">View</a>
                                <a href="{{ asset('storage/' . $certificate->file_path) }}" download class="btn btn-outline-secondary btn-sm w-100">Download</a>
                            </div>
                        @else
                            <p class="text-muted">No certificate uploaded.</p>
                        @endif
                    </div>
                </div>
            </div>

            {{-- Proof of Payment --}}
            <div class="tab-pane fade" id="payment" role="tabpanel">
                <div class="card mb-3">
                    <div class="card-header bg-success text-white">Proof of Payment</div>
                    <div class="card-body row">
                        @if($application->invoice && $application->invoice->proof_path)
                            <div class="col-md-3 col-sm-6 col-12 d-flex align-items-center mb-2">
                                <i class="bi bi-file-earmark-pdf-fill text-danger fs-4 me-2"></i>
                                <span class="file-name">{{ basename($application->invoice->proof_path) }}</span>
                            </div>
                            <div class="col-md-3 col-sm-6 col-12 mb-2">
                                <a href="{{ asset('storage/' . $application->invoice->proof_path) }}" target="_blank" class="btn btn-outline-success btn-sm w-100 mb-1">View</a>
                                <a href="{{ asset('storage/' . $application->invoice->proof_path) }}" download class="btn btn-outline-secondary btn-sm w-100">Download</a>
                            </div>
                        @else
                            <p class="text-muted">No proof of payment available.</p>
                        @endif
                    </div>
                </div>
            </div>

            {{-- Consent Form --}}
            <div class="tab-pane fade" id="consent" role="tabpanel">
                <div class="card mb-3">
                    <div class="card-header bg-info text-white">Consent Form</div>
                    <div class="card-body row">
                        @if($consent = $application->documents->where('type', 'consent_form')->first())
                            <div class="col-md-3 col-sm-6 col-12 d-flex align-items-center mb-2">
                                <i class="bi bi-file-earmark-pdf-fill text-danger fs-4 me-2"></i>
                                <span class="file-name">{{ basename($consent->file_path) }}</span>
                            </div>
                            <div class="col-md-3 col-sm-6 col-12 mb-2">
                                <a href="{{ asset('storage/' . $consent->file_path) }}" target="_blank" class="btn btn-outline-info btn-sm w-100 mb-1">View</a>
                                <a href="{{ asset('storage/' . $consent->file_path) }}" download class="btn btn-outline-secondary btn-sm w-100">Download</a>
                            </div>
                        @else
                            <p class="text-muted">No consent form uploaded.</p>
                        @endif
                    </div>
                </div>
            </div>

            {{-- Admin Feedback --}}
            <div class="tab-pane fade" id="feedback" role="tabpanel">
                <div class="card mb-3">
                    <div class="card-header bg-secondary text-white">Admin Feedback</div>
                    <div class="card-body row">
                        @if($application->response_report_path)
                            <div class="col-md-3 col-sm-6 col-12 d-flex align-items-center mb-2">
                                <i class="bi bi-file-earmark-arrow-down-fill text-dark fs-4 me-2"></i>
                                <span class="file-name">{{ basename($application->response_report_path) }}</span>
                            </div>
                            <div class="col-md-3 col-sm-6 col-12 mb-2">
                                <a href="{{ asset('storage/' . $application->response_report_path) }}" target="_blank" class="btn btn-outline-dark btn-sm w-100 mb-1">View</a>
                                <a href="{{ asset('storage/' . $application->response_report_path) }}" download class="btn btn-outline-secondary btn-sm w-100">Download</a>
                            </div>
                        @else
                            <p class="text-muted">No feedback report available yet.</p>
                        @endif
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

<style>
.main-card {
    max-width: 1100px;
    margin: 30px auto;
    border-radius: 10px;
    padding: 25px;
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.08);
    background-color: #fff;
}
.file-name {
    font-size: 0.95rem;
    word-break: break-word;
}
</style>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
