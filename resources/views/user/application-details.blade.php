@extends('layouts.user-dashboard')

@section('title', 'Application Details')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
     
    <div class="btn-group" role="group" aria-label="Application Actions">
        <a href="{{ route('application.select') }}" 
           class="btn btn-sm text-white" 
           style="background-color:#52074f; border-radius:25px;">
           ➕ New Application
        </a>

        @if($application->status === 'pending')
        <a href="{{ route('applications.edit', $application->id) }}" 
           class="btn btn-sm btn-outline-secondary" 
           style="border-radius:25px;">
           ✏️ Edit Application
        </a>
        @endif

        <a href="{{ route('applications.my') }}" 
           class="btn btn-sm btn-outline-warning" 
           style="border-radius:25px;">
           📋 My Applications
        </a>
    </div>
</div>

<div class="container py-4">

    {{-- Header --}}
    <h3 class="text-center fw-bold mb-4" style="color:#52074f; letter-spacing:1px;">
        📄 Application Details
        <span class="d-block mt-2" style="border-bottom: 4px solid #dd8027; width: 100px; margin: 0 auto;"></span>
    </h3> 
    <div class="row justify-content-center">
        <div class="col-lg-10">

<div class="card shadow-sm mb-4 border-0">
   
    @if($institutionApplicants)
        @foreach($institutionApplicants as $applicant)
        
    <div class="card-body">
         <div class="card-header fw-bold" style="background-color:#fdf5fa; color:#52074f;">
        👤 Personal Information
    </div>
            <p><strong>Name:</strong> {{ $applicant->first_name }} {{ $applicant->surname }}</p>
            
            <p><strong>Nationality:</strong> {{ $applicant->nationality ?? 'N/A' }}</p>
            <hr>
        @endforeach
    @endif
</div>

</div>
            {{-- ===== Application Summary ===== --}}
            <div class="card shadow-sm mb-4 border-0">
                <div class="card-body">
                    <div class="row g-3">
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
                                    <span class="badge bg-warning text-dark rounded-pill px-3 py-2">Under Review</span>
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
                </div>
            </div>

            {{-- ===== Qualifications ===== --}} 
<div class="card shadow-sm mb-4 border-0">
    <div class="card-header fw-bold d-flex align-items-center" 
         style="background-color:#fdf5fa; color:#52074f; font-size:1.2rem;">
        <i class="bi bi-mortarboard-fill fs-4 me-2"></i> 🎓 Qualifications
    </div>
    <div class="card-body">
        @foreach($application->qualifications as $qual)
            <div class="p-3 mb-3 border rounded shadow-sm bg-light">
                <div class="row g-3">
                    <div class="col-md-4">
                        <strong>Level:</strong> {{ $qual->name ?? 'N/A' }}
                    </div>
                    <div class="col-md-4">
                        <strong>Program:</strong> {{ $qual->program_name ?? 'N/A' }}
                    </div>
                    <div class="col-md-4">
                        <strong>Merit:</strong> {{ $qual->merit ?? 'N/A' }}
                    </div>
                    <div class="col-md-4">
                        <strong>Institution:</strong> {{ $qual->institution ?? 'N/A' }}
                    </div>
                    <div class="col-md-4">
                        <strong>Country:</strong> {{ $qual->country ?? 'N/A' }}
                    </div>
                    <div class="col-md-4">
                        <strong>Year Obtained:</strong> {{ $qual->year ?? 'N/A' }}
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>

<style>
.card-header {
    letter-spacing: 0.5px;
}
.card-body .p-3 {
    transition: all 0.2s ease-in-out;
}
.card-body .p-3:hover {
    box-shadow: 0 5px 12px rgba(82, 7, 79, 0.15);
}
</style>



            {{-- ===== Attachments ===== --}}
           <div class="card shadow-sm mb-4 border-0">
    <div class="card-header fw-bold" style="background-color:#fdf5fa; color:#52074f;">
        📎 Uploaded Documents
    </div>
    <div class="card-body">
        @foreach([
            'certificates' => 'Qualification Certificates', 
            'academic_records' => 'Academic Records', 
            'previous_evaluations' => 'Previous Evaluations', 
            'syllabi' => 'Syllabi'
        ] as $type => $label)

            @php
                $docs = $application->documents->where('type', $type);
            @endphp

            @if($docs->count())
                <div class="mb-3">
                    <h6 class="fw-bold text-secondary">{{ $label }}</h6>
                    <ul class="list-group shadow-sm">
                        @foreach($docs as $doc)
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <a href="{{ asset('storage/' . $doc->file_path) }}" target="_blank">
                                {{ basename($doc->file_path) }}
                            </a>
                            <div>
                                <a href="{{ asset('storage/' . $doc->file_path) }}" download class="btn btn-sm btn-outline-secondary">Download</a>
                            </div>
                        </li>
                        @endforeach
                    </ul>
                </div>
            @endif

        @endforeach
    </div>
</div>


            {{-- ===== Admin Feedback ===== --}}
            <div class="card shadow-sm mb-4 border-0">
                <div class="card-header fw-bold" style="background-color:#fdf5fa; color:#52074f;">
                    💬 Admin Feedback
                </div>
                <div class="card-body">
                    @if($application->response_report_path)
                        <div class="d-flex justify-content-between align-items-center border rounded p-3 mb-2 shadow-sm bg-light">
                            <div>
                                <strong>{{ $application->response_report_name ?? 'Feedback Report' }}</strong>
                                <p class="text-muted mb-0">Uploaded by admin</p>
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
            </div>

            {{-- ===== Additional Info Requests ===== --}}
            <div class="card shadow-sm mb-4 border-0">
                <div class="card-header fw-bold" style="background-color:#fdf5fa; color:#52074f;">
                    ℹ️ Additional Information Requests
                </div>
                <div class="card-body" style="max-height:400px; overflow-y:auto;">
                    @forelse($application->additionalInfoRequests as $req)
                        <div class="mb-3 p-3 bg-light rounded shadow-sm">
                            <p><strong style="color:#dd8027;">Admin:</strong> {{ $req->message }}</p>
                            <small class="text-muted">{{ $req->created_at->format('M d, H:i') }}</small>

                            @if($req->status != 'pending')
                                <div class="mt-2 p-2 bg-white border rounded">
                                    <strong style="color:#52074f;">Your Response:</strong>
                                    <p>{{ $req->response ?? 'No response provided.' }}</p>
                                    @if($req->response_file_path)
                                        <a href="{{ asset('storage/'.$req->response_file_path) }}" target="_blank" class="btn btn-sm btn-outline-primary mt-1">📎 View Uploaded File</a>
                                    @endif
                                </div>
                            @else
                                <form action="{{ route('applications.respond-info', $req->id) }}" method="POST" enctype="multipart/form-data" class="mt-2">
                                    @csrf
                                    @method('PUT')
                                    <textarea name="response" class="form-control mb-2" rows="2" placeholder="Type your response..."></textarea>
                                    <input type="file" name="response_file" class="form-control form-control-sm mb-2">
                                    <button type="submit" class="btn btn-sm text-white" style="background-color:#52074f;">Send Response</button>
                                </form>
                            @endif
                        </div>
                    @empty
                        <p class="text-muted text-center">No additional information requested by admin.</p>
                    @endforelse
                </div>
            </div>

            {{-- Download PDF --}} 
    <a href="{{ route('application.download', $application->id) }}" class="btn btn-primary">
        Download PDF
    </a>
 


        </div>
    </div>
</div>

<style>
.card-header {
    font-size: 1rem;
    letter-spacing: 0.5px;
}
.card-body p, .card-body strong {
    font-size: 0.95rem;
}
.document-section, .document-card {
    transition: all 0.2s ease-in-out;
}
.document-section:hover, .document-card:hover {
    box-shadow: 0 4px 12px rgba(82,7,79,0.08);
}
</style>
@endsection
