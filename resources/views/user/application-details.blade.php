
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
<div class="main-card">
<div class="container py-5">
    <div class="mb-4">
        <h3 class="mb-3">Application Details</h3>
        <div><strong>Processing Type:</strong> {{ ucfirst($application->processing_type) }}</div>
        <div><strong>Nationality:</strong> {{ $application->nationality }}</div>
        <div><strong>Status:</strong> {{ $application->status ?? 'Pending' }}</div>
    </div>

    <div class="card mb-4">
        <div class="card-header bg-primary text-white">
            Certificate to be Verified
        </div>
        <div class="card-body">
            @if($certificate = $application->documents->where('type', 'certificates')->first())
                <div class="d-flex align-items-center mb-2">
                    <i class="bi bi-file-earmark-pdf-fill text-danger fs-4 me-2"></i>
                    <span class="me-auto">{{ basename($certificate->file_path) }}</span>
                    <a href="{{ asset('storage/' . $certificate->file_path) }}" target="_blank" class="btn btn-outline-primary btn-sm">View</a>
                </div>
            @else
                <p class="text-muted">No certificate uploaded.</p>
            @endif
        </div>
    </div>

    <div class="card mb-4">
        <div class="card-header bg-success text-white">
            Proof of Payment
        </div>
        <div class="card-body">
            @if($application->invoice && $application->invoice->proof_path)
                <div class="d-flex align-items-center mb-2">
                    <i class="bi bi-file-earmark-pdf-fill text-danger fs-4 me-2"></i>
                    <span class="me-auto">{{ basename($application->invoice->proof_path) }}</span>
                    <a href="{{ asset('storage/' . $application->invoice->proof_path) }}" target="_blank" class="btn btn-outline-success btn-sm">View</a>
                </div>
            @else
                <p class="text-muted">No proof of payment available.</p>
            @endif
        </div>
    </div>

    <div class="card mb-4">
        <div class="card-header bg-info text-white">
            Consent Form
        </div>
        <div class="card-body">
            @if($consent = $application->documents->where('type', 'consent_form')->first())
                <div class="d-flex align-items-center mb-2">
                    <i class="bi bi-file-earmark-pdf-fill text-danger fs-4 me-2"></i>
                    <span class="me-auto">{{ basename($consent->file_path) }}</span>
                    <a href="{{ asset('storage/' . $consent->file_path) }}" target="_blank" class="btn btn-outline-info btn-sm">View</a>
                </div>
            @else
                <p class="text-muted">No consent form uploaded.</p>
            @endif
        </div>
    </div>

    <div class="card mb-4">
        <div class="card-header bg-warning text-dark">
            Payment Info
        </div>
        <div class="card-body">
            @if($application->invoice)
                <div><strong>Fee:</strong> MWK {{ number_format($application->invoice->fee) }}</div>
                <div><strong>Payment Type:</strong> {{ $application->invoice->processing_type }}</div>
            @else
                <p class="text-muted">No invoice found.</p>
            @endif
        </div>
    </div>

    <div class="card mb-4">
        <div class="card-header bg-secondary text-white">
            Admin Feedback
        </div>
        <div class="card-body">
            @if($application->response_report_path)
                <a href="{{ asset('storage/' . $application->response_report_path) }}" class="btn btn-success" download>
                    <i class="bi bi-download me-1"></i> Download Response Report
                </a>
            @else
                <p class="text-muted">No feedback report available yet.</p>
            @endif
        </div>
    </div>
</div></div>
<style>
/* application-details.css */

.main-card {
    max-width: 1100px;
    margin: 30px auto;
    border-radius: 10px;
    padding: 25px;
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
    background-color: #fff;
}

.file-card {
    border: 1px solid #dee2e6;
    border-radius: 8px;
    padding: 15px;
    text-align: center;
    transition: all 0.3s ease;
    height: 100%;
    background-color: #f9f9f9;
}

.file-card:hover {
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
    background-color: #ffffff;
}

.file-icon {
    font-size: 2rem;
    color: #dc3545;
    margin-bottom: 10px;
}

.file-name {
    font-size: 0.95rem;
    margin-bottom: 10px;
    word-break: break-word;
}

.file-btn {
    font-size: 0.875rem;
}
</style>