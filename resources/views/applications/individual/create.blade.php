@extends('layouts.app')

@section('title', 'Individual Application')

@section('content')
<div class="container py-4">

    <!-- Progress Bar -->
    @include('applications.partials.progress', ['application' => $application])

    <h4 class="mb-4">Individual Application Details</h4>

    <form method="POST" action="{{ route('applications.individual.store', $application) }}">
        @csrf

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
                <label class="form-label">Nationality</label>
                <select name="nationality_id" class="form-control" required>
                    <option value="">Select nationality</option>
                    @foreach($countries as $country)
                        <option value="{{ $country->id }}">
                            {{ country_flag($country->iso_code) }} {{ $country->name }}
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

.btn-outline-secondary { border-color: #600061; color: #600061; }
.btn-outline-secondary:hover { background-color: #600061; color: #fff; }

.progress-bar { background-color: #d96c19; }
</style>
@endsection
