@extends('layouts.app')

@section('title', 'Institution Applications')

@section('content')
<div class="container py-4">

    {{-- PAGE HEADER --}}
    <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap">
        <h4 class="mb-0">My Institution Applications</h4>
        <a href="{{ route('applications.create') }}"
           class="btn text-white mt-2"
           style="background-color:#600061">
            <i class="bi bi-plus-circle"></i> New Application
        </a>
    </div>

    @forelse($applications as $application)
        <div class="card mb-3 shadow-sm">
            <div class="card-body">

                <div class="d-flex justify-content-between flex-wrap">

                    {{-- LEFT SIDE: Application Info --}}
                    <div class="mb-2 mb-md-0">
                        @if($application->institutionApplication)
                            <h6 class="fw-bold mb-1">
                                {{ $application->institutionApplication->institution_name }}
                            </h6>
                        @else
                            <h6 class="fw-bold mb-1 text-muted">
                                Institution details pending
                            </h6>
                        @endif

                        <div class="text-muted small">
                            Country: 
                            {{ optional($application->institutionApplication?->country)->name ?? 'N/A' }}
                        </div>

                        <div class="text-muted small">
                            Processing: 
                            <span class="badge" style="background-color:#d96c19">
                                {{ ucfirst($application->processing_type) ?? 'N/A' }}
                            </span>
                        </div>
                    </div>

                    {{-- RIGHT SIDE: Actions --}}
                    <div class="text-end">

                        {{-- Status Badge --}}
                        <span class="badge {{ $application->submitted ? 'bg-success' : 'bg-secondary' }} mb-2">
                            {{ ucfirst($application->status) }}
                        </span>
                        <br>

                        {{-- Action Button --}}
                        @if(!$application->submitted)
                            <a href="{{ route('applications.resume', $application) }}"
                               class="btn btn-sm btn-warning">
                                <i class="bi bi-arrow-repeat"></i> Continue Application
                            </a>
                        @else
                            <a href="{{ route('applications.institution.show', $application) }}"
                               class="btn btn-sm btn-outline-primary">
                                <i class="bi bi-eye"></i> View
                            </a>
                        @endif
                    </div>

                </div>

            </div>
        </div>
    @empty
        <div class="alert alert-info">
            No institution applications found.
        </div>
    @endforelse

</div>

{{-- OPTIONAL: Mobile-friendly card polish --}}
<style>
    @media (max-width: 576px) {
        .card-body {
            padding: 1rem;
        }
        .text-end {
            text-align: left !important;
            margin-top: 1rem;
        }
    }
</style>
@endsection
