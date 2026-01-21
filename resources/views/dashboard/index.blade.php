@extends('layouts.app')

@section('title', 'My Applications')

@section('content')
<div class="container py-4">
@if($draft = auth()->user()
    ->applications()
    ->where('submitted', false)
    ->latest()
    ->first()
)
    <div class="card border-warning mb-3">
        <div class="card-body">
            <h5 class="card-title">
                <i class="bi bi-arrow-repeat"></i> Resume Application
            </h5>

            <p class="text-muted mb-2">
                You stopped at:
                <strong>{{ ucfirst($draft->current_step) }}</strong>
            </p>

            <a href="{{ route('applications.resume', $draft) }}"
               class="btn btn-warning">
                Continue Application
            </a>
        </div>
    </div>
@endif

    <h4 class="mb-4">My Applications</h4>

    @if($applications->isEmpty())
        <p>You have not started any applications yet.</p>
        <a href="{{ route('applications.create') }}" class="btn btn-primary">Start New Application</a>
    @else

        @foreach($applications as $app)
        <div class="card mb-3">
            <div class="card-header d-flex justify-content-between align-items-center">
                <strong>Application #{{ $app->id }} - {{ ucfirst($app->application_type) }}</strong>
                <span class="badge bg-{{ $app->status == 'submitted' ? 'success' : 'secondary' }}">
                    {{ ucfirst($app->status) }}
                </span>
            </div>

            <div class="card-body">

                @if($app->application_type == 'individual' && $app->individualApplication)
                    <p><strong>Studied At:</strong> {{ $app->individualApplication->studied_at }}</p>
                    <p><strong>Qualification:</strong> {{ $app->individualApplication->qualification_name }}</p>
                    <p><strong>Award:</strong> {{ $app->individualApplication->award }}</p>
                @elseif($app->application_type == 'institution' && $app->institutionApplication)
                    <p><strong>Institution Name:</strong> {{ $app->institutionApplication->institution_name }}</p>
                    <p><strong>Registration #:</strong> {{ $app->institutionApplication->registration_number ?? '-' }}</p>

                    <h6>Contacts:</h6>
                    <ul>
                        @foreach($app->institutionApplication->contacts as $contact)
                            <li>{{ $contact->first_name }} {{ $contact->last_name }} - {{ $contact->phone }}</li>
                        @endforeach
                    </ul>
                @endif

                <h6>Uploaded Documents:</h6>
                @if($app->documents->count() > 0)
                    <ul>
                        @foreach($app->documents as $doc)
                            <li>
                                {{ ucfirst(str_replace('_', ' ', $doc->document_type)) }} -
                                <a href="{{ route('documents.download', $doc) }}">Download</a>
                            </li>
                        @endforeach
                    </ul>
                @else
                    <p>No documents uploaded yet.</p>
                @endif

                <a href="{{ route('applications.documents.create', $app) }}" class="btn btn-sm btn-primary mt-2">
                    Manage Documents
                </a>

            </div>
        </div>
        @endforeach

    @endif

</div>
@endsection
