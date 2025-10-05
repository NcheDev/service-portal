@extends('layouts.user-dashboard')

@section('title', 'Application Details')

@section('content')
<div class="main-card">
    <div class="container py-4">

        <h3 class="mb-4 text-center fw-bold" style="color:#52074f; letter-spacing:1px;">
            📄 Application Details
        </h3>

        {{-- Summary --}}
       <div class="row mb-4 text-center">
    <div class="col-md-3 col-sm-6 mb-2">
        <strong>Processing Type:</strong><br> {{ ucfirst($application->processing_type) }}
    </div>
    <div class="col-md-3 col-sm-6 mb-2">
        <strong>Nationality:</strong><br> {{ $application->nationality }}
    </div>
    <div class="col-md-3 col-sm-6 mb-2">
        <strong>Qualification Status:</strong><br>
        @if($application->status === 'validated')
            <span class="badge rounded-pill" style="background-color:#28a745; color:white;">Recognised</span>
        @elseif($application->status === 'invalid')
            <span class="badge rounded-pill" style="background-color:#dc3545; color:white;">Unrecognised</span>
        @else
            <span class="badge rounded-pill" style="background-color:#ffc107; color:#52074f;">Pending</span>
        @endif
    </div>
    <div class="col-md-3 col-sm-6 mb-2">
        <strong>Payment:</strong><br>
        @if($application->invoice && $application->invoice->proof_path)
            <span class="badge rounded-pill" style="background-color:#52074f; color:white;">Paid</span>
        @else
            <span class="badge rounded-pill" style="background-color:#dd8027; color:white;">Not Paid</span>
        @endif
    </div>
</div>

        {{-- Tabs --}}
        <ul class="nav nav-tabs mb-3" id="docTab" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link active" id="cert-tab" data-bs-toggle="tab" data-bs-target="#cert" type="button" role="tab" style="color:#52074f; font-weight:500;">
                    Certificate
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="payment-tab" data-bs-toggle="tab" data-bs-target="#payment" type="button" role="tab" style="color:#52074f; font-weight:500;">
                    Proof of Payment
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="consent-tab" data-bs-toggle="tab" data-bs-target="#consent" type="button" role="tab" style="color:#52074f; font-weight:500;">
                    Consent Form
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="feedback-tab" data-bs-toggle="tab" data-bs-target="#feedback" type="button" role="tab" style="color:#52074f; font-weight:500;">
                    Admin Feedback
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="info-tab" data-bs-toggle="tab" data-bs-target="#info" type="button" role="tab" style="color:#52074f; font-weight:500;">
                    Additional Info Requests
                </button>
            </li>
        </ul>

        <div class="tab-content" id="docTabContent">

            {{-- Certificate --}}
            <div class="tab-pane fade show active" id="cert" role="tabpanel">
                <div class="card mb-3 shadow-sm">
                    <div class="card-header" style="background-color:#52074f; color:white;">Certificate to be Verified</div>
                    <div class="card-body row">
                        @if($certificate = $application->documents->where('type', 'certificates')->first())
                            <div class="col-md-3 col-sm-6 mb-2 d-flex align-items-center">
                                <i class="bi bi-file-earmark-pdf-fill text-danger fs-4 me-2"></i>
                                <span class="file-name">{{ basename($certificate->file_path) }}</span>
                            </div>
                            <div class="col-md-3 col-sm-6 mb-2">
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
                <div class="card mb-3 shadow-sm">
                    <div class="card-header" style="background-color:#dd8027; color:white;">Proof of Payment</div>
                    <div class="card-body row">
                        @if($application->invoice && $application->invoice->proof_path)
                            <div class="col-md-3 col-sm-6 mb-2 d-flex align-items-center">
                                <i class="bi bi-file-earmark-pdf-fill text-danger fs-4 me-2"></i>
                                <span class="file-name">{{ basename($application->invoice->proof_path) }}</span>
                            </div>
                            <div class="col-md-3 col-sm-6 mb-2">
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
                <div class="card mb-3 shadow-sm">
                    <div class="card-header" style="background-color:#52074f; color:white;">Consent Form</div>
                    <div class="card-body row">
                        @if($consent = $application->documents->where('type', 'consent_form')->first())
                            <div class="col-md-3 col-sm-6 mb-2 d-flex align-items-center">
                                <i class="bi bi-file-earmark-pdf-fill text-danger fs-4 me-2"></i>
                                <span class="file-name">{{ basename($consent->file_path) }}</span>
                            </div>
                            <div class="col-md-3 col-sm-6 mb-2">
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
                <div class="card mb-3 shadow-sm">
                    <div class="card-header" style="background-color:#6c757d; color:white;">Admin Feedback</div>
                    <div class="card-body row">
                        @if($application->response_report_path)
                            <div class="col-md-3 col-sm-6 mb-2 d-flex align-items-center">
                                <i class="bi bi-file-earmark-arrow-down-fill text-dark fs-4 me-2"></i>
                                <span class="file-name">{{ basename($application->response_report_path) }}</span>
                            </div>
                            <div class="col-md-3 col-sm-6 mb-2">
                                <a href="{{ asset('storage/' . $application->response_report_path) }}" target="_blank" class="btn btn-outline-dark btn-sm w-100 mb-1">View</a>
                                <a href="{{ asset('storage/' . $application->response_report_path) }}" download class="btn btn-outline-secondary btn-sm w-100">Download</a>
                            </div>
                        @else
                            <p class="text-muted">No feedback report available yet.</p>
                        @endif
                    </div>
                </div>
            </div>

            {{-- Additional Info Requests --}}
           <div class="tab-pane fade" id="info" role="tabpanel">
  <div class="card mb-3 shadow-sm">
    <div class="card-header text-white" style="background-color:#dd8027;">
      Additional Information Requests
    </div>

    <div class="card-body p-3" style="background:#f8f9fa;">
      @forelse($application->additionalInfoRequests as $req)
        <div class="chat-thread mb-4 p-3 rounded-4 shadow-sm bg-white">
          {{-- Admin message --}}
          <div class="d-flex mb-2">
            <div class="chat-bubble admin bg-light p-3 rounded-4 me-auto" style="max-width:75%;">
              <div class="small text-muted fw-bold mb-1">Admin</div>
              <p class="mb-2">{{ $req->message }}</p>
              <span class="small text-muted">{{ $req->created_at->format('M d, H:i') }}</span>
            </div>
          </div>

          {{-- User response (if available) --}}
          @if($req->status != 'pending')
            <div class="d-flex justify-content-end mb-2">
              <div class="chat-bubble user p-3 rounded-4 ms-auto" style="background-color:#dcf8c6; max-width:75%;">
                <div class="small text-muted fw-bold mb-1">You</div>
                <p class="mb-2">{{ $req->response ?? 'No response provided.' }}</p>
                @if($req->response_file)
                  <a href="{{ asset('storage/'.$req->response_file) }}" target="_blank" class="btn btn-outline-primary btn-sm">
                    📎 View Uploaded File
                  </a>
                @endif
                <span class="small text-muted d-block mt-1">{{ $req->updated_at->format('M d, H:i') }}</span>
              </div>
            </div>
          @else
            {{-- Response form when pending --}}
            <div class="d-flex justify-content-end mt-2">
              <form action="{{ route('applications.respond-info', $req->id) }}" method="POST" enctype="multipart/form-data"
                    class="p-3 bg-light rounded-4 shadow-sm" style="max-width:75%;">
                @csrf
                @method('PUT')

                <textarea name="response" class="form-control mb-2" rows="2" placeholder="Type your response..."></textarea>
                <input type="file" name="response_file" class="form-control form-control-sm mb-2">
                <button type="submit" class="btn btn-sm text-white" style="background-color:#52074f;">Send</button>
              </form>
            </div>
          @endif
        </div>
      @empty
        <p class="text-muted text-center">No additional information requested by admin.</p>
      @endforelse
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
.nav-tabs .nav-link.active {
    background-color: #52074f !important;
    color: white !important;
    border-radius: 5px 5px 0 0;
}
.nav-tabs .nav-link {
    border: 1px solid #ddd;
    margin-right: 2px;
    border-radius: 5px 5px 0 0;
}
.card-header {
    font-weight: 600;
}
</style>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
@endsection
