@extends('layouts.app')

@section('title', 'Start Application')

@section('content')
<div class="container py-4">

    <h4 class="mb-4">Start New Application</h4>

    <form method="POST" action="{{ route('applications.store') }}">
        @csrf

        <!-- Application Type -->
        <div class="mb-4">
            <label class="form-label fw-bold">Who are you applying for?</label>

            <div class="form-check">
                <input class="form-check-input" type="radio"
                       name="application_type" value="individual" required>
                <label class="form-check-label">
                    Individual (Applying for myself)
                </label>
            </div>

            <div class="form-check">
                <input class="form-check-input" type="radio"
                       name="application_type" value="institution">
                <label class="form-check-label">
                    Institution (Applying on behalf of an institution)
                </label>
            </div>
        </div>

        <!-- Processing Type -->
        <div class="mb-4">
            <label class="form-label fw-bold">Processing Type</label>

            <div class="form-check">
                <input class="form-check-input" type="radio"
                       name="processing_type" value="normal" checked>
                <label class="form-check-label">
                    Normal Processing
                </label>
            </div>

            <div class="form-check">
                <input class="form-check-input" type="radio"
                       name="processing_type" value="express">
                <label class="form-check-label">
                    Express Processing
                </label>
            </div>
        </div>

        <button class="btn btn-primary">
            Continue
        </button>
    </form>

</div>
@endsection
