@extends('layouts.app')

@section('title', 'Institution Applications')

@section('content')
<div class="container py-4">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="mb-0">My Institution Applications</h4>

        <a href="{{ route('applications.create') }}"
           class="btn text-white"
           style="background-color:#600061">
            <i class="bi bi-plus-circle"></i> New Application
        </a>
    </div>

    @forelse($applications as $application)
        <div class="card mb-3 shadow-sm">
            <div class="card-body">

                <div class="d-flex justify-content-between">
                    <div>
                        <h6 class="fw-bold mb-1">
                            {{ $application->institutionApplication->institution_name }}
                        </h6>

                        <div class="text-muted small">
                            Country:
                            {{ $application->institutionApplication->country->name ?? 'N/A' }}
                        </div>

                        <div class="text-muted small">
                            Processing:
                            <span class="badge"
                                  style="background-color:#d96c19">
                                {{ ucfirst($application->processing_type) }}
                            </span>
                        </div>
                    </div>

                    <div class="text-end">
                        <span class="badge bg-secondary mb-2">
                            {{ ucfirst($application->status) }}
                        </span>
                        <br>

                        <a href="{{ route('applications.institution.show', $application) }}"
                           class="btn btn-sm btn-outline-primary">
                            View
                        </a>
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
@endsection
