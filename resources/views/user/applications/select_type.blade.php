@extends('layouts.user-dashboard')

@section('content')
<div class="container py-5">
    <div class="card shadow-sm p-4 text-center" style="max-width: 600px; margin: 0 auto;">
        <h3 class="mb-4 fw-bold text-nche-primary">Create New Application</h3>
        <p class="mb-4">Choose how you want to submit your application:</p>

        <div class="d-flex justify-content-center gap-3">
            {{-- Single Application --}}
            <a href="{{ route('application.create') }}" 
               class="btn btn-primary px-4 py-2 fw-semibold shadow">
               ➕ Single Application
            </a>

            {{-- Bulk Upload --}}
            <a href="{{ route('application.bulk.form') }}" 
               class="btn btn-success px-4 py-2 fw-semibold shadow">
               📤 Bulk Upload
            </a>
        </div>
    </div>
</div>
@endsection
