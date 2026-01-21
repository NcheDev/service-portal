@extends('layouts.app')

@section('title', 'View Individual Application')

@section('content')
<div class="container py-4">

    <h4 class="mb-4" style="color:#600061;">Individual Application Details</h4>

    <table class="table table-bordered">
        <tr>
            <th>Where did you study?</th>
            <td>{{ $application->individualApplication?->studied_at ?? '-' }}</td>
        </tr>
        <tr>
            <th>Qualification Name</th>
            <td>{{ $application->individualApplication?->qualification_name ?? '-' }}</td>
        </tr>
        <tr>
            <th>Award</th>
            <td>{{ $application->individualApplication?->award ?? '-' }}</td>
        </tr>
        <tr>
            <th>Nationality</th>
            <td>{{ $application->individualApplication?->nationality?->name ?? '-' }}</td>
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

    <a href="{{ route('applications.individual.index') }}" class="btn btn-secondary" style="background-color:#d96c19; border:none; color:white;">
        Back to Applications
    </a>

</div>
@endsection
