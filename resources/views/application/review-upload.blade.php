@extends('layouts.user-dashboard')

@section('content')

<div class="container py-5">
    
    <div class="card shadow-lg border-0">
        <div class="card-header text-white text-center" style="background-color:#52074f;">
            <h4 class="fw-bold mb-0">📋 Review Uploaded Applicants</h4>
        </div>

        <div class="card-body">
            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            <table class="table table-striped table-bordered align-middle">
                <thead class="table-dark text-center">
                    <tr>
                        <th>#</th>
                        <th>Application ID</th>
                        <th>Applicant Name</th>
                        <th>Nationality</th>
                        <th>Qualifications</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($applications as $index => $app)
                        @foreach($app->institutionApplicants as $instApplicant)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $app->id }}</td>
                                <td>{{ $instApplicant->first_name }} {{ $instApplicant->surname }}</td>
                                <td>{{ $instApplicant->nationality }}</td>
                                <td>
                                    <ul class="list-unstyled mb-0">
                                        @foreach($app->qualifications as $qual)
                                            <li>
                                                {{ $qual->name }} ({{ $qual->program_name }}, {{ $qual->year }})
                                            </li>
                                        @endforeach
                                    </ul>
                                </td>
                                <td>
                                    <form action="{{ route('application.upload.attachments', $app->id) }}" method="POST" enctype="multipart/form-data">
    @csrf

    {{-- File input --}}
    <input type="file" name="certificates[]" class="form-control mb-1" multiple>

    {{-- Uploaded files preview --}}
    @php
        $uploadedCertificates = $app->documents->where('type', 'certificates');
    @endphp

    <ul class="list-unstyled mt-2" id="certificates-list">
        @foreach($uploadedCertificates as $doc)
            <li class="mb-1 d-flex justify-content-between align-items-center">
                <a href="{{ asset('storage/' . $doc->file_path) }}" target="_blank">
                    {{ basename($doc->file_path) }}
                </a>
             </li>
        @endforeach
    </ul>

    {{-- Upload button --}}
    <button type="submit" class="btn btn-sm text-white" style="background-color:#28a745; border-radius:25px;">
        📤 Upload Attachment
    </button>
</form>

                                </td>
                            </tr>
                        @endforeach
                    @empty
                        <tr>
                            <td colspan="6" class="text-center">No uploaded applicants yet.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', () => {
    const input = document.querySelector('input[name="certificates[]"]');
    const list = document.getElementById('certificates-list');

    input.addEventListener('change', () => {
        // Clear only new preview (optional)
        const newFilesFragment = document.createDocumentFragment();

        for (let file of input.files) {
            const li = document.createElement('li');
            li.textContent = file.name;
            li.style.fontWeight = '500';
            li.style.color = '#52074f';
            newFilesFragment.appendChild(li);
        }

        list.appendChild(newFilesFragment);

        // Hide the input to prevent re-upload
        input.style.display = 'none';
    });
});
</script>


@endsection
