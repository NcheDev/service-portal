@extends('layouts.user-dashboard')
@section('content')

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-12 col-sm-10 col-md-8 col-lg-6">
            <div class="card border-0 shadow-lg">
                
                <!-- Header -->
                <div class="card-header text-white text-center" style="background-color:#52074f;">
                    <h5 class="fw-bold mb-0">🎉 Application Submitted Successfully</h5>
                </div>

                <!-- Body -->
                <div class="card-body text-center p-4 p-sm-5" style="background-color:#f9f9f9;">
                    <i class="bi bi-check-circle-fill mb-3" style="font-size:4rem; color:#dd8027;"></i>
                    
                    <h4 class="fw-bold text-nche-primary mb-3">
                        Thank you — your application has been received
                    </h4>

                    <p class="text-muted mb-4">
                        Your application has been successfully submitted and is now under review by the NCHE team.
                    </p>

                    <a href="{{ route('application.download', $application->id) }}"
                       class="btn btn-lg fw-bold text-white"
                       style="background-color:#dd8027; border:none;">
                        <i class="bi bi-file-earmark-pdf me-2"></i> Download My Application PDF
                    </a>
                </div>

                <!-- Footer / Actions -->
                <div class="card-footer bg-white d-flex flex-column flex-sm-row justify-content-center gap-2 gap-sm-3 py-3">
                    <a href="{{ route('application.create') }}" 
                       class="btn btn-sm text-white flex-fill"
                       style="background-color:#52074f; border-radius:25px;">
                       ➕ New Application
                    </a>

                    @if($application->status === 'pending')
                    <a href="{{ route('applications.edit', $application->id) }}" 
                       class="btn btn-sm btn-outline-secondary flex-fill"
                       style="border-radius:25px;">
                       ✏️ Edit Application
                    </a>
                    @endif

                    <a href="{{ route('applications.my') }}" 
                       class="btn btn-sm btn-outline-warning flex-fill"
                       style="border-radius:25px;">
                       📋 View My Applications
                    </a>
                </div>

            </div>
        </div>
    </div>
</div>

@endsection
