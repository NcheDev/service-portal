@extends('layouts.app')

@section('title', 'Individual Application')

@section('content')
<div class="container py-4">
@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

@if(session('error'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        {{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

    <!-- Progress Bar -->
    @include('applications.partials.progress', ['application' => $application])

    <h4 class="mb-4">Individual Application Details</h4>

    <form method="POST" action="{{ route('applications.individual.store', $application) }}">
        @csrf
@php
function flagEmoji($code) {
    return mb_convert_encoding(
        '&#' . (127397 + ord($code[0])) . ';' .
        '&#' . (127397 + ord($code[1])) . ';',
        'UTF-8',
        'HTML-ENTITIES'
    );
}
@endphp

        <div class="row g-3">

            <div class="col-md-6">
                <label class="form-label">Where did you study?</label>
                <input name="studied_at" class="form-control" required>
            </div>

            <div class="col-md-6">
                <label class="form-label">Qualification Name</label>
                <input name="qualification_name" class="form-control" required>
            </div>

            <div class="col-md-6">
                <label class="form-label">Award</label>
                <input name="award" class="form-control" required>
            </div>

            <div class="col-md-6">
    <label class="form-label">Awarding Institution</label>
    <input
        type="text"
        name="awarding_institution"
        class="form-control"
        placeholder="e.g. University of Malawi"
        required
    >
</div>
           <div class="col-md-6">
    <label class="form-label">Year Obtained</label>
    <select name="year_obtained" class="form-control" required>
        <option value="">Select year</option>
        @for ($year = now()->year; $year >= 1950; $year--)
            <option value="{{ $year }}">{{ $year }}</option>
        @endfor
    </select>
</div>
<div class="col-md-6">
    <label class="form-label">Country Obtained</label>
    <select name="country_obtained_id" class="form-control" required>
        <option value="">Select country</option>

        @foreach($countries as $country)
            <option value="{{ $country->id }}">
                {{ flagEmoji($country->iso_code) }} {{ $country->name }}
            </option>
        @endforeach

    </select>
</div>

            </div>

        <!-- Buttons -->
        <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center gap-2 mt-4">
            <button class="btn btn-primary mb-2 mb-md-0">
                <i class="bi bi-save"></i> Save & Continue
            </button>

            <div class="d-flex gap-2 flex-wrap">
                <!-- Preview -->
                <a href="{{ route('applications.preview', $application) }}"
                   class="btn btn-outline-secondary">
                    <i class="bi bi-eye"></i> Preview Application
                </a>
            </div>
        </div>
    </form>

</div>

<style>
/* Theme colors */
.btn-primary { background-color: #d96c19; border-color: #d96c19; }
.btn-primary:hover { background-color: #600061; border-color: #600061; }

.btn-outline-secondary { border-color: #600061;iiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiuuuuuuuuuuuuut0]
    22222222
    4hu,color: #600061; }
.btn-outline-secondary:hover { background-color: #600061; color: #fff; }

.progress-bar { background-color: #d96c19; }
</style>
@endsection
iujnjiii