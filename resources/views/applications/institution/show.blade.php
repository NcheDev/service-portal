@extends('layouts.app')

@section('title', 'View Institution Application')

@section('content')
<div class="container py-4">

    {{-- HEADER --}}
    <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap">
        <h4 class="mb-0" style="color:#600061;">Institution Application Details</h4>
        <a href="{{ route('applications.institution.index') }}"
           class="btn text-white mt-2"
           style="background-color:#d96c19; border:none;">
            <i class="bi bi-arrow-left-circle"></i> Back to Applications
        </a>
    </div>

    {{-- INSTITUTION INFO CARD --}}
    <div class="card mb-4 shadow-sm">
        <div class="card-header bg-light fw-bold">
            Institution Information
        </div>
        <div class="card-body">
            <div class="row g-3">

                <div class="col-md-6">
                    <small class="text-muted">Institution Name</small>
                    <div class="fw-semibold">
                        {{ $application->institutionApplication?->institution_name ?? '-' }}
                    </div>
                </div>

                <div class="col-md-6">
                    <small class="text-muted">Registration Number</small>
                    <div class="fw-semibold">
                        {{ $application->institutionApplication?->registration_number ?? '-' }}
                    </div>
                </div>

                <div class="col-md-6">
                    <small class="text-muted">Country</small>
                    <div class="fw-semibold">
                        {{ $application->institutionApplication?->country?->name ?? '-' }}
                    </div>
                </div>

                <div class="col-md-6">
                    <small class="text-muted">Status</small>
                    <div>
                        <span class="badge"
                              style="background-color: {{ $application->status == 'submitted' ? '#d96c19' : '#600061' }}; color:white;">
                            {{ ucfirst($application->status) }}
                        </span>
                    </div>
                </div>

            </div>
        </div>
    </div>

    {{-- CONTACTS CARD --}}
    <div class="card mb-4 shadow-sm">
        <div class="card-header bg-light fw-bold">
            Contacts
        </div>
        <div class="card-body">
            @if($application->institutionApplication?->contacts->count() > 0)
                <ul class="mb-0">
                    @foreach($application->institutionApplication->contacts as $contact)
                        <li>
                            {{ $contact->first_name }} {{ $contact->last_name }} - 
                            {{ $contact->phone }} 
                            ({{ $contact->nationality?->name ?? '-' }})
                        </li>
                    @endforeach
                </ul>
            @else
                <p class="text-muted mb-0">No contacts added</p>
            @endif
        </div>
    </div>

    {{-- DOCUMENTS CARD --}}
    <div class="card mb-4 shadow-sm">
        <div class="card-header bg-light fw-bold">
            Uploaded Documents
        </div>
        <div class="card-body">
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

{{-- OPTIONAL MOBILE-FRIENDLY POLISH --}}
<style>
    .fw-semibold { font-weight: 600; }
    .card-header { font-weight: 600; }
    @media (max-width: 576px) {
        .card-body { padding: 1rem; }
        .row.g-3 > [class*='col-'] { margin-bottom: 0.75rem; }
    }
</style>
@endsection
