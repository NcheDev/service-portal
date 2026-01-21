@extends('layouts.app')

@section('title', 'View Institution Application')

@section('content')
<div class="container py-4">

    <h4 class="mb-4" style="color:#600061;">Institution Application Details</h4>

    <table class="table table-bordered">
        <tr>
            <th>Institution Name</th>
            <td>{{ $application->institutionApplication?->institution_name ?? '-' }}</td>
        </tr>
        <tr>
            <th>Registration Number</th>
            <td>{{ $application->institutionApplication?->registration_number ?? '-' }}</td>
        </tr>
        <tr>
            <th>Country</th>
            <td>{{ $application->institutionApplication?->country?->name ?? '-' }}</td>
        </tr>
        <tr>
            <th>Status</th>
            <td>
                <span class="badge" style="background-color: {{ $application->status == 'submitted' ? '#d96c19' : '#600061' }}; color:white;">
                    {{ ucfirst($application->status) }}
                </span>
            </td>
        </tr>
        <tr>
            <th>Contacts</th>
            <td>
                @if($application->institutionApplication?->contacts->count() > 0)
                    <ul class="mb-0">
                        @foreach($application->institutionApplication->contacts as $contact)
                            <li>{{ $contact->first_name }} {{ $contact->last_name }} - {{ $contact->phone }} ({{ $contact->nationality?->name }})</li>
                        @endforeach
                    </ul>
                @else
                    No contacts added
                @endif
            </td>
        </tr>
        <tr>
            <th>Uploaded Documents</th>
            <td>
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
                    No documents uploaded
                @endif
            </td>
        </tr>
    </table>

    <a href="{{ route('applications.institution.index') }}" class="btn btn-secondary" style="background-color:#d96c19; border:none; color:white;">
        Back to Applications
    </a>

</div>
@endsection
