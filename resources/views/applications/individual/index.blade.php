@extends('layouts.app')

@section('title', 'My Individual Applications')

@section('content')
<div class="container py-4">

    <h4 class="mb-4" style="color:#600061;">My Individual Applications</h4>

    @if($applications->isEmpty())
        <div class="alert alert-warning">
            You have not started any individual applications yet.
        </div>
        <a href="{{ route('applications.create') }}" class="btn btn-warning" style="background-color:#d96c19; border:none;">
            Start New Application
        </a>
    @else
        <div class="table-responsive">
            <table class="table table-bordered align-middle">
                <thead style="background-color:#600061; color:white;">
                    <tr>
                        <th>#</th>
                        <th>Studied At</th>
                        <th>Qualification</th>
                        <th>Award</th>
                        <th>Nationality</th>
                        <th>Status</th>
                        <th>Documents</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($applications as $index => $app)
                        @if($app->application_type == 'individual')
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $app->individualApplication?->studied_at ?? '-' }}</td>
                            <td>{{ $app->individualApplication?->qualification_name ?? '-' }}</td>
                            <td>{{ $app->individualApplication?->award ?? '-' }}</td>
                            <td>{{ $app->individualApplication?->nationality?->name ?? '-' }}</td>
                            <td>
                                <span class="badge" style="background-color: {{ $app->status == 'submitted' ? '#d96c19' : '#600061' }}; color:white;">
                                    {{ ucfirst($app->status) }}
                                </span>
                            </td>
                            <td>
                                @if($app->documents->count() > 0)
                                    <ul class="mb-0">
                                        @foreach($app->documents as $doc)
                                            <li>
                                                <a href="{{ route('documents.download', $doc) }}" style="color:#600061;">
                                                    {{ ucfirst(str_replace('_',' ',$doc->document_type)) }}
                                                </a>
                                            </li>
                                        @endforeach
                                    </ul>
                                @else
                                    No documents
                                @endif
                            </td>
                            <td>
                                @if($app->status != 'submitted')
                                    <a href="{{ route('applications.individual.edit', $app) }}" class="btn btn-sm" style="background-color:#d96c19; color:white;">
                                        Edit
                                    </a>
                                @endif
                                <a href="{{ route('applications.documents.create', $app) }}" class="btn btn-sm" style="background-color:#600061; color:white;">
                                    Upload Documents
                                </a>
                            </td>
                        </tr>
                        @endif
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif

</div>
@endsection
