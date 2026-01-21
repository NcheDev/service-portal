@extends('layouts.app')

@section('title', 'Application Preview')

@section('content')
<div class="container py-4">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4>Application Preview</h4>

        <span class="badge bg-{{ $application->status === 'submitted' ? 'success' : 'secondary' }}">
            {{ ucfirst($application->status) }}
        </span>
    </div>

    {{-- BASIC INFO --}}
    <div class="card mb-4">
        <div class="card-header bg-light fw-bold">
            Application Information
        </div>
        <div class="card-body">
            <p><strong>Application Type:</strong> {{ ucfirst($application->application_type) }}</p>
            <p><strong>Application Number:</strong> {{ $application->id }}</p>
            <p><strong>Date Created:</strong> {{ $application->created_at->format('d M Y') }}</p>
        </div>
    </div>

    {{-- INDIVIDUAL APPLICATION --}}
    @if($application->application_type === 'individual' && $application->individualApplication)
        <div class="card mb-4">
            <div class="card-header bg-light fw-bold">
                Individual Details
            </div>
            <div class="card-body">
                <p><strong>Institution Studied At:</strong> {{ $application->individualApplication->studied_at }}</p>
                <p><strong>Qualification:</strong> {{ $application->individualApplication->qualification_name }}</p>
                <p><strong>Award:</strong> {{ $application->individualApplication->award }}</p>
                <p><strong>Nationality:</strong>
                    {{ $application->individualApplication->nationality->name ?? '-' }}
                </p>
            </div>
        </div>
    @endif

    {{-- INSTITUTION APPLICATION --}}
    @if($application->application_type === 'institution' && $application->institutionApplication)
        <div class="card mb-4">
            <div class="card-header bg-light fw-bold">
                Institution Details
            </div>
            <div class="card-body">
                <p><strong>Institution Name:</strong> {{ $application->institutionApplication->institution_name }}</p>
                <p><strong>Registration Number:</strong>
                    {{ $application->institutionApplication->registration_number ?? '-' }}
                </p>
                <p><strong>Country:</strong>
                    {{ $application->institutionApplication->country->name ?? '-' }}
                </p>
            </div>
        </div>

        {{-- CONTACT PERSONS --}}
        <div class="card mb-4">
            <div class="card-header bg-light fw-bold">
                Contact Persons
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-sm">
                        <thead class="table-light">
                            <tr>
                                <th>Name</th>
                                <th>Phone</th>
                                <th>Nationality</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($application->institutionApplication->contacts as $contact)
                                <tr>
                                    <td>{{ $contact->first_name }} {{ $contact->last_name }}</td>
                                    <td>{{ $contact->phone }}</td>
                                    <td>{{ $contact->nationality->name ?? '-' }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    @endif

    {{-- DOCUMENTS --}}
    <div class="card mb-4">
        <div class="card-header bg-light fw-bold">
            Uploaded Documents
        </div>
        <div class="card-body">
            @if($application->documents->count() > 0)
                <ul class="list-group">
                    @foreach($application->documents as $doc)
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            {{ ucfirst(str_replace('_', ' ', $doc->document_type)) }}

                            <a href="{{ route('documents.download', $doc) }}"
                               class="btn btn-sm btn-outline-primary">
                                <i class="bi bi-download"></i> Download
                            </a>
                        </li>
                    @endforeach
                </ul>
            @else
                <p class="text-muted mb-0">No documents uploaded.</p>
            @endif
        </div>
    </div>

    {{-- ACTIONS --}}
    <div class="d-flex justify-content-between">
        <a href="{{ route('applications.documents.create', $application) }}"
           class="btn btn-outline-secondary">
            <i class="bi bi-arrow-left"></i> Back to Documents
        </a>

        @if($application->status !== 'submitted')
            <form method="POST"
                  action="{{ route('applications.submit', $application) }}">
                @csrf
                <button class="btn btn-success"
                        onclick="return confirm('Submit application? You will not be able to edit after submission.')">
                    <i class="bi bi-check-circle"></i> Submit Application
                </button>
            </form>
        @endif
    </div>

</div>
@endsection
