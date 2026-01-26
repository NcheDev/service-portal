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

        @foreach($applications as $app)
            @if($app->application_type == 'individual')
            <div class="card mb-3 shadow-sm">
                <div class="card-body d-flex justify-content-between flex-wrap">

                    {{-- LEFT SIDE: Application Info --}}
                    <div class="mb-2 mb-md-0">
                        <h6 class="fw-bold mb-1">
                            {{ $app->individualApplication?->qualification_name ?? 'Qualification pending' }}
                        </h6>
                        <div class="text-muted small">
                            Studied At: {{ $app->individualApplication?->studied_at ?? '-' }}
                        </div>
                        <div class="text-muted small">
                            Award: {{ $app->individualApplication?->award ?? '-' }}
                        </div>
                        <div class="text-muted small">
                            Nationality: {{ $app->individualApplication?->nationality?->name ?? '-' }}
                        </div>
                        <div class="text-muted small mt-1">
                            Status:
                            <span class="badge" style="background-color: {{ $app->status == 'submitted' ? '#d96c19' : '#600061' }}; color:white;">
                                {{ ucfirst($app->status) }}
                            </span>
                        </div>
                    </div>

                    {{-- RIGHT SIDE: Actions --}}
                    <div class="text-end">
                        @if($app->status != 'submitted')
                            <a href="{{ route('applications.resume', $app) }}" class="btn btn-sm btn-warning">
                                <i class="bi bi-arrow-repeat"></i> Continue Application
                            </a>
                        @else
                          <a href="{{ route('applications.individual.show', $app) }}" class="btn btn-sm btn-outline-primary">
    <i class="bi bi-eye"></i> View Application
</a>

                        @endif
                    </div>

                </div>
            </div>
            @endif
        @endforeach

    @endif

</div>

{{-- MOBILE FRIENDLY POLISH --}}
<style>
    .fw-bold { font-weight: 600; }
    .card { border-radius: 0.75rem; }
    @media (max-width: 576px) {
        .text-end { text-align: left !important; margin-top: 0.75rem; }
    }
</style>
@endsection
