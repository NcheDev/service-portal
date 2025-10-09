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
    <button class="nav-link position-relative" 
        id="info-tab" 
        data-bs-toggle="tab" 
        data-bs-target="#info" 
        type="button" 
        role="tab" 
        style="color:#52074f; font-weight:500;">

        Additional Info Requests

        @php 
            // Check if there are any pending requests
            $hasPending = $application->additionalInfoRequests->where('status', 'pending')->count() > 0;
        @endphp

        @if($hasPending)
            <!-- Red dot for pending notifications -->
            <span class="position-absolute top-0 start-100 translate-middle p-1 bg-danger rounded-circle"></span>
        @endif
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
  <div class="card-header text-white fw-bold" style="background-color:#dd8027;">
    Additional Information Requests
  </div>

  {{-- Scrollable chat area --}}
  <div class="card-body p-3" style="background:#f8f9fa; max-height:400px; overflow-y:auto;">
    @forelse($application->additionalInfoRequests as $req)
      <div class="chat-thread mb-4 p-3 rounded-4 shadow-sm bg-white">

        {{-- Admin message --}}
        <div class="d-flex mb-3 align-items-start">
          {{-- Admin Avatar --}}
          <img src="{{ asset('images/avatar.png') }}" alt="Admin" class="chat-avatar me-2">

          <div class="chat-bubble admin p-2 px-3 rounded-4"
               style="max-width:80%; background:#f2f2f2; border-left:4px solid #dd8027; display:flex; flex-direction:column; justify-content:flex-start;">
            <div class="small text-muted fw-bold mb-1" style="color:#52074f;">Admin</div>
            <p class="mb-2" style=" word-wrap:break-word; margin-top:0;">
              {{ $req->message }}
            </p>
            <span class="small text-muted">{{ $req->created_at->format('M d, H:i') }}</span>
          </div>
        </div>

        {{-- User response --}}
        @if($req->status != 'pending')
          <div class="d-flex justify-content-end align-items-start mb-3">
            <div class="chat-bubble user p-2 px-3 rounded-4 text-dark"
                 style="background-color:#f9ece1; max-width:50%; border-right:4px solid #52074f; display:flex; flex-direction:column; justify-content:flex-start;">
              <div class="small text-muted fw-bold mb-1" style="color:#52074f;">You</div>

              {{-- User message --}}
              <p class="mb-2" style=" word-wrap:break-word; margin-top:0;">
                {{ $req->response ?? 'No response provided.' }}
              </p>

              {{-- User file --}}
              @if(!empty($req->response_file_path))
                <div class="mt-1">
                  <a href="{{ asset('storage/'.$req->response_file_path) }}" 
                     target="_blank"
                     class="btn btn-sm btn-outline-primary"
                     style="border-color:#52074f; color:#52074f;">
                    📎 View Uploaded File
                  </a>
                </div>
              @endif

              <span class="small text-muted d-block mt-1">
                {{ $req->updated_at->format('M d, H:i') }}
              </span>
            </div>

            {{-- User avatar --}}
            <img 
              src="{{ Auth::user()->personalInfo?->profile_picture 
                        ? Storage::url(Auth::user()->personalInfo->profile_picture) 
                        : 'https://via.placeholder.com/40' }}" 
              alt="User" 
              class="chat-avatar ms-2">
          </div>
        @else
          {{-- Response form --}}
          <div class="d-flex justify-content-end mt-2">
            <form action="{{ route('applications.respond-info', $req->id) }}" 
                  method="POST" enctype="multipart/form-data"
                  class="p-3 bg-light rounded-4 shadow-sm border"
                  style="max-width:80%; border-color:#dd8027;">
              @csrf
              @method('PUT')

              <textarea name="response" class="form-control mb-2" rows="2" placeholder="Type your response..."></textarea>
              <input type="file" name="response_file" class="form-control form-control-sm mb-2">
              <button type="submit" class="btn btn-sm text-white" style="background-color:#52074f;">Send</button>
            </form>

            <img 
              src="{{ Auth::user()->personalInfo?->profile_picture 
                        ? Storage::url(Auth::user()->personalInfo->profile_picture) 
                        : 'https://via.placeholder.com/40' }}" 
              alt="User" 
              class="chat-avatar ms-2">
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

<style>
    /* Avatar styling */
.chat-avatar {
  width: 40px;
  height: 40px;
  border-radius: 50%;
  object-fit: cover;
  border: 2px solid #52074f;
}

/* Chat bubble */
.chat-bubble {
  line-height: 1.4;
  font-size: 0.95rem;
  padding: 8px 14px !important;
  border-radius: 16px;
  display: flex;
  flex-direction: column;
  justify-content: flex-start; /* ensures text starts from top */
  word-break: break-word;
}

/* Chat paragraph spacing */
.chat-bubble p {
  margin-bottom: 6px !important;
  margin-top: 0 !important; /* remove middle spacing */
}

/* Scrollbar */
.card-body::-webkit-scrollbar {
  width: 8px;
}
.card-body::-webkit-scrollbar-thumb {
  background-color: #dd8027;
  border-radius: 4px;
}

/* Hover effect */
.chat-bubble:hover {
  box-shadow: 0 2px 8px rgba(82, 7, 79, 0.15);
}

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
