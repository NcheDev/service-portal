@extends('layouts.user-dashboard')
@section('content')
<div class="container py-5">
    <div class="modal-dialog modal-dialog-centered" style="max-width: 600px;">
        <div class="modal-content border-0 shadow-lg">
            <div class="modal-header text-white" style="background-color:#52074f;">
                <h5 class="modal-title fw-bold">🎉 Application Submitted Successfully</h5>
            </div>

            <div class="modal-body text-center p-5" style="background-color:#f9f9f9;">
                <i class="bi bi-check-circle-fill mb-3" style="font-size:4rem; color:#dd8027;"></i>
                <h4 class="fw-bold text-nche-primary mb-3">
                    Thank you — your application has been received
                </h4>
                <p class="text-muted">
                    Your application has been successfully submitted and is now under review by the NCHE team.
                </p>

                <a href="{{ route('application.download', $application->id) }}"
                   class="btn btn-lg fw-bold text-white mt-4"
                   style="background-color:#dd8027; border:none;">
                    <i class="bi bi-file-earmark-pdf me-2"></i> Download My Application PDF
                </a>
            </div>

            <div class="modal-footer justify-content-center">
                <a href="{{ route('application.create') }}" class="btn btn-outline-secondary">
                    New Application
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
