@extends('layouts.app')

@section('title', 'Upload Documents')

@section('content')
<div class="container py-4">

    <!-- Progress Bar Partial -->
    @include('applications.partials.progress', ['application' => $application])

    <h4 class="mb-4">Upload Documents for Your Application</h4>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <!-- Already Uploaded Files -->
    @if($application->documents->count() > 0)
        <h5>Uploaded Documents</h5>
        <ul class="list-group mb-4">
            @foreach($application->documents as $doc)
                <li class="list-group-item d-flex justify-content-between align-items-center">
                    {{ ucfirst(str_replace('_', ' ', $doc->document_type)) }}
                    <a href="{{ route('documents.download', $doc) }}" class="btn btn-sm btn-outline-primary">
                        Download
                    </a>
                </li>
            @endforeach
        </ul>
    @endif

    <form method="POST"
          action="{{ route('applications.documents.store', $application) }}"
          enctype="multipart/form-data">
        @csrf

        <div id="document-container">
            <div class="row g-3 document-row mb-2">
                <div class="col-md-6">
                    <label class="form-label">Document Type</label>
                    <select name="documents[0][type]" class="form-control" required>
                        <option value="">Select Type</option>
                        <option value="qualification_certificate">Qualification Certificate</option>
                        <option value="transcript">Transcript</option>
                        <option value="id">ID / Passport</option>
                    </select>
                </div>

                <div class="col-md-6">
                    <label class="form-label">File</label>
                    <input type="file" name="documents[0][file]" class="form-control" required>
                </div>
            </div>
        </div>

        <button type="button" class="btn btn-secondary mb-3" id="add-document">
            <i class="bi bi-plus-circle"></i> Add Another Document
        </button>

        <!-- Action Buttons -->
        <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center gap-2 mt-4">
            <!-- Upload -->
            <button class="btn btn-primary mb-2 mb-md-0">
                <i class="bi bi-upload"></i> Upload Documents
            </button>

            <!-- Preview & Submit -->
            <div class="d-flex gap-2 flex-wrap">
                <a href="{{ route('applications.preview', $application) }}"
                   class="btn btn-outline-secondary">
                    <i class="bi bi-eye"></i> Preview Application
                </a>

                <form method="POST" action="{{ route('applications.submit', $application) }}">
                    @csrf
                    <button class="btn btn-success"
                            onclick="return confirm('Are you sure you want to submit this application?')">
                        <i class="bi bi-check-circle"></i> Submit Application
                    </button>
                </form>
            </div>
        </div>

    </form>
</div>

<script>
let index = 1;
document.getElementById('add-document').addEventListener('click', function () {
    const container = document.getElementById('document-container');
    const row = document.querySelector('.document-row').cloneNode(true);

    row.querySelectorAll('input, select').forEach(input => {
        const name = input.getAttribute('name');
        const newName = name.replace(/\d+/, index);
        input.setAttribute('name', newName);
        if(input.tagName === 'INPUT') input.value = '';
        if(input.tagName === 'SELECT') input.selectedIndex = 0;
    });

    container.appendChild(row);
    index++;
});
</script>

<style>
/* Theme colors */
.btn-primary { background-color: #d96c19; border-color: #d96c19; }
.btn-primary:hover { background-color: #600061; border-color: #600061; }

.btn-outline-secondary { border-color: #600061; color: #600061; }
.btn-outline-secondary:hover { background-color: #600061; color: #fff; }

.btn-success { background-color: #28a745; border-color: #28a745; }
.btn-success:hover { background-color: #218838; border-color: #1e7e34; }

.progress-bar { background-color: #d96c19; }
</style>

@endsection
