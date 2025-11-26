@extends('layouts.user-dashboard')

@section('content')
<div class="container py-5" style="max-width: 700px;">
    <div class="card shadow-sm p-4">
        <h4 class="fw-bold mb-3">Bulk Upload Applicants</h4>
        <p>Upload a CSV file to create multiple applications at once. You can also download a template to fill.</p>

        {{-- Download template --}}
        <a href="{{ route('application.download_template') }}" 
           class="btn btn-outline-primary mb-4">
           📥 Download CSV Template
        </a>

        {{-- Upload CSV --}}
        <form action="{{ route('application.bulk.upload') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="mb-3">
                <label class="form-label fw-bold">Upload Applicants CSV</label>
                <input type="file" name="applicants_csv" class="form-control" accept=".csv" required>
            </div>
            <button type="submit" class="btn btn-success">Upload & Create Applications</button>
        </form>
    </div>
</div>
@endsection
