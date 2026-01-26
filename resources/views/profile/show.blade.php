@extends('layouts.app')

@section('title', 'My Profile')

@section('content')
<div class="container py-4">

    {{-- PAGE HEADER --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="mb-0">My Profile</h4>
            <small class="text-muted">Personal information</small>
        </div>

        <a href="{{ route('profile.create') }}" class="btn btn-warning">
            <i class="bi bi-pencil-square"></i> Edit
        </a>
    </div>

    <div class="row g-3">

        {{-- BASIC INFO --}}
        <div class="col-lg-6">
            <div class="card h-100 shadow-sm">
                <div class="card-header bg-light fw-bold">
                    Basic Information
                </div>

                <div class="card-body">

                    <div class="mb-3">
                        <small class="text-muted">Title</small>
                        <div class="fw-semibold">{{ $profile->title?->name ?? '-' }}</div>
                    </div>

                    <div class="row">
                        <div class="col-6 mb-3">
                            <small class="text-muted">First Name</small>
                            <div class="fw-semibold">{{ $profile->first_name }}</div>
                        </div>

                        <div class="col-6 mb-3">
                            <small class="text-muted">Last Name</small>
                            <div class="fw-semibold">{{ $profile->last_name }}</div>
                        </div>
                    </div>

                    <div class="mb-3">
                        <small class="text-muted">Previous Names</small>
                        <div class="fw-semibold">{{ $profile->previous_names ?? '-' }}</div>
                    </div>

                    <div class="mb-3">
                        <small class="text-muted">Gender</small>
                        <div class="fw-semibold">{{ $profile->gender?->name ?? '-' }}</div>
                    </div>

                </div>
            </div>
        </div>

        {{-- CONTACT INFO --}}
        <div class="col-lg-6">
            <div class="card h-100 shadow-sm">
                <div class="card-header bg-light fw-bold">
                    Contact Information
                </div>

                <div class="card-body">

                    <div class="mb-3">
                        <small class="text-muted">Primary Contact</small>
                        <div class="fw-semibold">{{ $profile->primary_contact }}</div>
                    </div>

                    <div class="mb-3">
                        <small class="text-muted">Secondary Contact</small>
                        <div class="fw-semibold">{{ $profile->secondary_contact ?? '-' }}</div>
                    </div>

                    <div class="mb-3">
                        <small class="text-muted">Nationality</small>
                        <div class="fw-semibold">
                            {{ $profile->nationality?->name ?? '-' }}
                        </div>
                    </div>

                    <div class="mb-3">
                        <small class="text-muted">Country of Residence</small>
                        <div class="fw-semibold">{{ $profile->country ?? '-' }}</div>
                    </div>

                </div>
            </div>
        </div>

        {{-- IDENTIFICATION --}}
        <div class="col-lg-6">
            <div class="card shadow-sm">
                <div class="card-header bg-light fw-bold">
                    Identification
                </div>

                <div class="card-body">
                    <div class="mb-0">
                        <small class="text-muted">Malawian ID</small>
                        <div class="fw-semibold">
                            {{ $profile->malawian_id ?? 'Not provided' }}
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>

{{-- SUBTLE UI POLISH --}}
<style>
    .card {
        border-radius: 0.75rem;
    }

    .fw-semibold {
        font-weight: 600;
    }

    @media (max-width: 576px) {
        .card-header {
            font-size: 0.95rem;
        }
    }
</style>
@endsection
