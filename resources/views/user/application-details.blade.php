@extends('layouts.user-dashboard')

@section('title', 'Application Details')

@section('content')
<div class="main-card">
    <div class="container py-4">
        <h3 class="mb-4 text-center fw-bold" style="color:#52074f; letter-spacing:1px;">
            <span>📄 Application Details</span>
            <hr>
        </h3>

        {{-- ===== Application Summary ===== --}}
        <form class="p-3 border rounded shadow-sm bg-white">

            <div class="row mb-4">
                <div class="col-md-4">
                    <label class="form-label fw-bold text-secondary">Processing Type</label>
                    <input type="text" class="form-control" value="{{ ucfirst($application->processing_type) }}" readonly>
                </div>

                <div class="col-md-4">
                    <label class="form-label fw-bold text-secondary">Qualification Status</label>
                    <div class="pt-1">
                        @if($application->status === 'validated')
                            <span class="badge bg-success rounded-pill px-3 py-2">Recognised</span>
                        @elseif($application->status === 'invalid')
                            <span class="badge bg-danger rounded-pill px-3 py-2">Unrecognised</span>
                        @else
                            <span class="badge bg-warning text-dark rounded-pill px-3 py-2">Pending</span>
                        @endif
                    </div>
                </div>

                <div class="col-md-4">
                    <label class="form-label fw-bold text-secondary">Payment Status</label>
                    <div class="pt-1">
                        @if($application->invoice && $application->invoice->proof_path)
                            <span class="badge rounded-pill px-3 py-2" style="background-color:#52074f;">Paid</span>
                        @else
                            <span class="badge rounded-pill px-3 py-2" style="background-color:#dd8027;">Not Paid</span>
                        @endif
                    </div>
                </div>
            </div>

            {{-- ===== Certificate Section ===== --}}
            <div class="document-section p-3 mb-4 border rounded shadow-sm">
                <div class="d-flex align-items-center mb-3">
                    <i class="bi bi-mortarboard-fill fs-4 me-2" style="color:#52074f;"></i>
                    <h5 class="fw-bold text-uppercase mb-0" style="color:#52074f;">Certificate to be Verified</h5>
                </div>

                @if($certificate = $application->documents->where('type', 'certificates')->first())
                    <div class="document-card d-flex flex-wrap align-items-center justify-content-between border rounded p-3 mb-2 shadow-sm bg-light">
                        <div class="d-flex align-items-center mb-2 mb-md-0">
                            <i class="bi bi-file-earmark-pdf-fill text-danger fs-3 me-3"></i>
                            <div>
                                <p class="mb-0 fw-bold text-dark">{{ basename($certificate->file_path) }}</p>
                                <small class="text-muted">Uploaded certificate document</small>
                            </div>
                        </div>
                        <div class="d-flex gap-2">
                            <a href="{{ asset('storage/' . $certificate->file_path) }}" target="_blank" class="btn btn-sm text-white" style="background-color:#52074f;">View</a>
                            <a href="{{ asset('storage/' . $certificate->file_path) }}" download class="btn btn-sm btn-outline-secondary">Download</a>
                        </div>
                    </div>
                @else
                    <p class="text-muted">No certificate uploaded.</p>
                @endif
            </div>

            {{-- ===== Admin Feedback ===== --}}
            <div class="document-section p-3 mb-4 border rounded shadow-sm">
                <div class="d-flex align-items-center mb-3">
                    <i class="bi bi-chat-left-text-fill fs-4 me-2 text-secondary"></i>
                    <h5 class="fw-bold text-uppercase mb-0" style="color:#52074f;">Admin Feedback Report</h5>
                </div>

                @if($application->response_report_path)
                    <div class="document-card d-flex flex-wrap align-items-center justify-content-between border rounded p-3 shadow-sm bg-light">
                        <div class="d-flex align-items-center mb-2 mb-md-0">
                            <i class="bi bi-file-earmark-arrow-down-fill text-dark fs-3 me-3"></i>
                            <div>
                                <p class="mb-0 fw-bold text-dark">{{ basename($application->response_report_path) }}</p>
                                <small class="text-muted">Feedback report file</small>
                            </div>
                        </div>
                        <div class="d-flex gap-2">
                            <a href="{{ asset('storage/' . $application->response_report_path) }}" target="_blank" class="btn btn-sm text-white" style="background-color:#52074f;">View</a>
                            <a href="{{ asset('storage/' . $application->response_report_path) }}" download class="btn btn-sm btn-outline-secondary">Download</a>
                        </div>
                    </div>
                @else
                    <p class="text-muted">No feedback report available yet.</p>
                @endif
            </div>

            {{-- ===== Additional Info Requests ===== --}}
            <div class="document-section p-3 mb-3 border rounded shadow-sm">
                <div class="d-flex align-items-center mb-3">
                    <i class="bi bi-info-circle-fill fs-4 me-2" style="color:#dd8027;"></i>
                    <h5 class="fw-bold text-uppercase mb-0" style="color:#52074f;">Additional Information Requests</h5>
                </div>

                <div class="p-3 border rounded-4" style="background:#f8f9fa; max-height:400px; overflow-y:auto;">
                    @forelse($application->additionalInfoRequests as $req)
                        <div class="mb-4 p-3 bg-white rounded-4 shadow-sm">
                            <p><strong style="color:#dd8027;">Admin:</strong> {{ $req->message }}</p>
                            <small class="text-muted">{{ $req->created_at->format('M d, H:i') }}</small>

                            @if($req->status != 'pending')
                                <div class="mt-3 p-2 bg-light border rounded">
                                    <strong style="color:#52074f;">Your Response:</strong>
                                    <p>{{ $req->response ?? 'No response provided.' }}</p>

                                    @if($req->response_file_path)
                                        <a href="{{ asset('storage/'.$req->response_file_path) }}" target="_blank" class="btn btn-sm btn-outline-primary mt-1">📎 View Uploaded File</a>
                                    @endif
                                </div>
                            @else
                                <form action="{{ route('applications.respond-info', $req->id) }}" method="POST" enctype="multipart/form-data" class="mt-3">
                                    @csrf
                                    @method('PUT')
                                    <div class="mb-2">
                                        <textarea name="response" class="form-control" rows="2" placeholder="Type your response..."></textarea>
                                    </div>
                                    <div class="mb-2">
                                        <input type="file" name="response_file" class="form-control form-control-sm">
                                    </div>
                                    <button type="submit" class="btn btn-sm text-white" style="background-color:#52074f;">Send Response</button>
                                </form>
                            @endif
                        </div>
                    @empty
                        <p class="text-muted text-center">No additional information requested by admin.</p>
                    @endforelse
                </div>
            </div>

        </form>
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
form {
    background-color: #fff !important;
}
.document-section {
    background-color: #fff;
    transition: all 0.2s ease-in-out;
}
.document-section:hover {
    box-shadow: 0 3px 10px rgba(82, 7, 79, 0.08);
}
.document-card {
    transition: background 0.2s ease;
}
.document-card:hover {
    background-color: #faf5fc;
}
form label {
    color: #52074f;
}
.btn-outline-secondary:hover,
.btn-outline-primary:hover {
    background-color: #52074f;
    color: #fff;
    border-color: #52074f;
}
 span {
    border-bottom: 5px solid #dd8027;
    width: max-content;
 }
</style>
@endsection
