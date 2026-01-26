@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="container py-4">

    {{-- PAGE HEADER --}}
    <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap">
        <div>
            <h4 class="mb-0">My Applications</h4>
            <small class="text-muted">Track and manage your applications</small>
        </div>

        <a href="{{ route('applications.create') }}" class="btn text-white mt-2"
           style="background-color:#600061;">
            <i class="bi bi-plus-circle"></i> New Application
        </a>
    </div>

    {{-- RESUME DRAFT --}}
    @if($draft = auth()->user()->applications()->where('status', 'draft')->latest()->first())
        <div class="alert alert-warning d-flex justify-content-between align-items-center">
            <div>
                <strong>Resume Application</strong><br>
                <small>You stopped at <strong>{{ ucfirst($draft->current_step) }}</strong></small>
            </div>

            <a href="{{ route('applications.resume', $draft) }}" class="btn btn-warning">
                Continue
            </a>
        </div>
    @endif

    {{-- APPLICATION STATUS COUNTERS --}}
    <div class="row g-3 mb-4">

        @php
            $submitted = auth()->user()->applications()->where('status','submitted')->count();
            $pending   = auth()->user()->applications()->where('status','pending')->count();
            $verified  = auth()->user()->applications()->where('status','verified')->count();
            $drafts    = auth()->user()->applications()->where('status','draft')->count();
        @endphp

        <div class="col-sm-6 col-md-3">
            <div class="card text-center shadow-sm">
                <div class="card-body">
                    <h5 class="fw-bold">{{ $submitted }}</h5>
                    <small class="text-muted">Submitted</small>
                </div>
            </div>
        </div>

        <div class="col-sm-6 col-md-3">
            <div class="card text-center shadow-sm">
                <div class="card-body">
                    <h5 class="fw-bold">{{ $pending }}</h5>
                    <small class="text-muted">Pending</small>
                </div>
            </div>
        </div>

        <div class="col-sm-6 col-md-3">
            <div class="card text-center shadow-sm">
                <div class="card-body">
                    <h5 class="fw-bold">{{ $verified }}</h5>
                    <small class="text-muted">Verified</small>
                </div>
            </div>
        </div>

        <div class="col-sm-6 col-md-3">
            <div class="card text-center shadow-sm">
                <div class="card-body">
                    <h5 class="fw-bold">{{ $drafts }}</h5>
                    <small class="text-muted">Drafts</small>
                </div>
            </div>
        </div>

    </div>

    {{-- APPLICATION LIST --}}
    <div class="row g-3">
        @foreach($applications as $app)
            <div class="col-md-6 col-lg-4">
                <div class="card h-100 shadow-sm">

                    {{-- CARD HEADER --}}
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <span class="fw-bold">
                            #{{ $app->id }} · {{ ucfirst($app->application_type) }}
                        </span>
                        <span class="badge bg-{{ $app->status == 'submitted' ? 'success' : ($app->status == 'draft' ? 'warning' : 'secondary') }}">
                            {{ ucfirst($app->status) }}
                        </span>
                    </div>

                    {{-- CARD BODY --}}
                    <div class="card-body small">

                        @if($app->application_type === 'individual' && $app->individualApplication)
                            <p class="mb-1">
                                <strong>Institution:</strong> {{ $app->individualApplication->studied_at }}
                            </p>
                            <p class="mb-1">
                                <strong>Qualification:</strong> {{ $app->individualApplication->qualification_name }}
                            </p>
                            <p class="mb-0">
                                <strong>Award:</strong> {{ $app->individualApplication->award }}
                            </p>

                        @elseif($app->application_type === 'institution' && $app->institutionApplication)
                            <p class="mb-1">
                                <strong>Institution:</strong> {{ $app->institutionApplication->institution_name }}
                            </p>
                            <p class="mb-0">
                                <strong>Reg #:</strong> {{ $app->institutionApplication->registration_number ?? '-' }}
                            </p>
                        @endif

                    </div>

                    {{-- CARD FOOTER --}}
                    <div class="card-footer bg-light text-center">
                        @if($app->status == 'draft')
                            <a href="{{ route('applications.resume', $app) }}" class="btn btn-sm btn-warning w-100">
                                <i class="bi bi-arrow-repeat"></i> Continue Application
                            </a>
                        @else
                            <a href="{{ route('applications.show', $app) }}" class="btn btn-sm btn-outline-primary w-100">
                                <i class="bi bi-eye"></i> View Application
                            </a>
                        @endif
                    </div>

                </div>
            </div>
        @endforeach
    </div>

</div>

{{-- MOBILE-FRIENDLY POLISH --}}
<style>
    .card {
        border-radius: 0.75rem;
    }
    .fw-bold { font-weight: 600; }
    .btn-primary {
        background-color: #d96c19;
        border-color: #d96c19;
    }
    .btn-primary:hover {
        background-color: #600061;
        border-color: #600061;
    }
</style>
@endsection
