@extends('layouts.app')

@section('title', 'View Individual Application')

@section('content')
<div class="container py-4">

    {{-- HEADER --}}
    <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap">
        <h4 class="mb-0" style="color:#600061;">Individual Application Details</h4>
        <a href="{{ route('applications.individual.index') }}"
           class="btn text-white mt-2"
           style="background-color:#d96c19; border:none;">
            <i class="bi bi-arrow-left-circle"></i> Back to Applications
        </a>
    </div>

    {{-- APPLICATION DETAILS CARD --}}
    <div class="card mb-4 shadow-sm">
        <div class="card-header bg-light fw-bold">
            Application Information
        </div>
        <div class="card-body">
            <div class="row g-3">

                <div class="col-md-6">
                    <small class="text-muted">Where did you study?</small>
                    <div class="fw-semibold">
                        {{ $application->individualApplication?->studied_at ?? '-' }}
                    </div>
                </div>

                <div class="col-md-6">
                    <small class="text-muted">Qualification Name</small>
                    <div class="fw-semibold">
                        {{ $application->individualApplication?->qualification_name ?? '-' }}
                    </div>
                </div>

                <div class="col-md-6">
                    <small class="text-muted">Award</small>
                    <div class="fw-semibold">
                        {{ $application->individualApplication?->award ?? '-' }}
                    </div>
                </div>

                <div class="col-md-6">
                    <small class="text-muted">Nationality</small>
                    <div class="fw-semibold">
                        {{ $application->individualApplication?->nationality?->name ?? '-' }}
                    </div>
                </div>

                <div class="col-md-6">
                    <small class="text-muted">Status</small>
                    <div>
                        <span class="badge" style="background-color: {{ $application->status == 'submitted' ? '#d96c19' : '#600061' }}; color:white;">
                            {{ ucfirst($application->status) }}
                        </span>
                    </div>
                </div>

                <div class="col-12">
                    <small class="text-muted">Uploaded Documents</small>
                    <div>
                        @if($application->documents->count() > 0)
                            <ul class="mb-0">
                                @foreach($application->documents as $doc)
                                    <li>
                                        <a href="{{ route('documents.download', $doc) }}" style="color:#600061;">
                                            {{ ucfirst(str_replace('_',' ',$doc->document_type)) }}
                                        </a>
                                    </li>
                                @endforeach
                            </ul>
                        @else
                            <p class="text-muted mb-0">No documents uploaded</p>
                        @endif
                    </div>
                </div>

            </div>
        </div>
    </div>

</div>

{{-- MOBILE-FRIENDLY POLISH --}}
<style>
    .fw-semibold { font-weight: 600; }
    .card-header { font-weight: 600; }
    @media (max-width: 576px) {
        .row.g-3 > [class*='col-'] { margin-bottom: 0.75rem; }
    }
</style>
@endsection
