@extends('layouts.user-dashboard')

@section('title', 'Edit Application')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
     
    <div class="btn-group" role="group" aria-label="Application Actions">
        <a href="{{ route('application.create') }}" 
           class="btn btn-sm text-white" 
           style="background-color:#52074f; border-radius:25px;">
           ➕ New Application
        </a>

        @if($application->status === 'pending')
        <a href="{{ route('applications.edit', $application->id) }}" 
           class="btn btn-sm btn-outline-secondary" 
           style="border-radius:25px;">
           ✏️ Edit Application
        </a>
        @endif

        <a href="{{ route('applications.my') }}" 
           class="btn btn-sm btn-outline-warning" 
           style="border-radius:25px;">
           📋 My Applications
        </a>
    </div>
</div>
<div class="container pt-4 pb-5">

    {{-- Page Header --}}
    <div class="mb-4 text-center">
        <h2 class="fw-bold" style="color:#52074f;">✏️ Edit Your Application</h2>
        <p class="text-muted">You can update your application details while it is still under review.</p>
    </div>

    <form action="{{ route('applications.update', $application->id) }}" 
          method="POST" 
          enctype="multipart/form-data" 
          class="p-4 rounded shadow"
          style="background:#ffffff; border-top:4px solid #52074f;">
        
        @csrf
        @method('PUT')


        {{-- ============= Processing Type Card ============= --}}
        <div class="card shadow-sm mb-4 border-0" style="border-left:4px solid #52074f;">
            <div class="card-header bg-white fw-bold" style="color:#52074f;">
                Processing Details
            </div>

            <div class="card-body">
                <label class="form-label fw-semibold">Processing Type <span class="text-danger">*</span></label>
                <select class="form-select shadow-sm" name="processing_type">
                    <option value="normal"  {{ $application->processing_type == 'normal' ? 'selected' : '' }}>Normal</option>
                    <option value="express" {{ $application->processing_type == 'express' ? 'selected' : '' }}>Express</option>
                </select>
            </div>
        </div>


        {{-- ============= Qualification Cards ============= --}}
        @foreach($qualifications as $i => $qual)
        <div class="card shadow-sm mb-4 border-0" style="border-left:4px solid #52074f;">
            <div class="card-header bg-white">
                <h5 class="fw-bold m-0" style="color:#52074f;">Qualification #{{ $i+1 }}</h5>
            </div>

            <div class="card-body">

                <div class="row g-4">

                    {{-- Qualification Level --}}
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Qualification Level*</label>
                        <select name="qualifications[{{ $i }}][name]" class="form-select shadow-sm" required>
                            <option value="PhD"         {{ $qual['name']=='PhD' ? 'selected':'' }}>PhD</option>
                            <option value="Masters"     {{ $qual['name']=='Masters' ? 'selected':'' }}>Masters</option>
                            <option value="Degree"      {{ $qual['name']=='Degree' ? 'selected':'' }}>Degree</option>
                            <option value="Diploma"     {{ $qual['name']=='Diploma' ? 'selected':'' }}>Diploma</option>
                            <option value="Certificate" {{ $qual['name']=='Certificate' ? 'selected':'' }}>Certificate</option>
                        </select>
                    </div>

                    {{-- Program Name --}}
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Program Name*</label>
                        <input type="text" 
                               name="qualifications[{{ $i }}][program_name]"
                               class="form-control shadow-sm"
                               value="{{ $qual['program_name'] }}" 
                               required>
                    </div>

                  {{-- Year --}}
<div class="col-md-6">
    <label class="form-label fw-semibold">Year Obtained*</label>
    <input type="number" 
           name="qualifications[{{ $i }}][year]" 
           class="form-control shadow-sm year-input" 
           value="{{ $qual['year'] }}"
           min="1900" max="{{ date('Y') }}" required>
    <small class="text-danger d-none year-error">Invalid year.</small>
</div>

                    {{-- Institution --}}
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Institution*</label>
                        <input type="text"
                               name="qualifications[{{ $i }}][institution]"
                               class="form-control shadow-sm"
                               value="{{ $qual['institution'] }}"
                               required>
                    </div>

                    {{-- Country --}}
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Country Obtained*</label>
                        <select name="qualifications[{{ $i }}][country]" class="form-select shadow-sm" required>
                            @foreach($countries as $country)
                                <option value="{{ $country }}" {{ $qual['country']==$country ? 'selected':'' }}>
                                    {{ $country }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Merit --}}
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Merit*</label>
                        <select name="qualifications[{{ $i }}][merit]" class="form-select shadow-sm">
                            <option value="Distinction" {{ $qual['merit']=='Distinction'?'selected':'' }}>Distinction</option>
                            <option value="Credit"      {{ $qual['merit']=='Credit'?'selected':'' }}>Credit</option>
                            <option value="Pass"        {{ $qual['merit']=='Pass'?'selected':'' }}>Pass</option>
                        </select>
                    </div>

                </div>

            </div>
        </div>
        @endforeach



        {{-- ============= Attachments Card ============= --}}
       <div class="card shadow-sm mb-4 border-0" style="border-left:4px solid #52074f;">
    <div class="card-header bg-white fw-bold" style="color:#52074f;">
        Attachments
        <small class="d-block text-muted mt-1" style="font-weight:400; font-size:0.85rem;">
        Allowed file types: PDF, PNG, JPG, JPEG | Max file size: 4MB
    </small>
    </div>

    <div class="card-body">

        @foreach([
            'certificates' => ['label' => 'Qualification Certificates', 'items' => $certificates],
            'academic_records' => ['label' => 'Academic Records', 'items' => $academic_records],
            'previous_evaluations' => ['label' => 'Previous Evaluations', 'items' => $previous_evaluations],
            'syllabi' => ['label' => 'Syllabi', 'items' => $syllabi],
        ] as $field => $data)

            <div class="mb-4">

                <label class="fw-bold" style="color:#52074f;">{{ $data['label'] }}</label>

                {{-- Existing Uploaded Files --}}
                @if($data['items']->count())
                    <ul class="list-group shadow-sm mb-2" id="{{ $field }}-list">
                        @foreach($data['items'] as $doc)
                            <li class="list-group-item d-flex justify-content-between align-items-center" data-id="{{ $doc->id }}">
                                <a href="{{ asset('storage/' . $doc->file_path) }}" target="_blank">
                                    {{ basename($doc->file_path) }}
                                </a>
                                <button type="button" class="btn btn-sm btn-danger ms-2 remove-file-btn">
                                    Remove
                                </button>
                            </li>
                        @endforeach
                    </ul>
                @endif

                {{-- Upload new files --}}
                <input type="file" name="{{ $field }}[]" class="form-control shadow-sm" multiple>

            </div>

        @endforeach

    </div>
</div>




        {{-- Submit Button --}}
        <div class="text-center mt-4">
            <button type="submit" 
                    class="btn px-5 py-2 fw-semibold shadow"
                    style="background:#52074f; color:white; border-radius:30px;">
                Save Changes
            </button>
        </div>

    </form>

</div>
@if(session('success'))
<!-- Success Modal -->
<div class="modal fade" id="successModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content shadow-lg border-0" style="border-radius: 15px;">

            <div class="modal-header bg-success text-white" style="border-radius: 15px 15px 0 0;">
                <h5 class="modal-title fw-bold">
                    ✓ Success
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body text-center p-4">
                <h5 class="fw-bold mb-2" style="color:#52074f;">
                    Application Updated
                </h5>
                <p class="text-muted">
                    {{ session('success') }}
                </p>
            </div>

            <div class="modal-footer justify-content-center">
                <button class="btn btn-success px-4" data-bs-dismiss="modal">
                    OK
                </button>
            </div>

        </div>
    </div>
</div>
@endif
@if(session('success'))
<script>
    document.addEventListener('DOMContentLoaded', function() {
        var successModal = new bootstrap.Modal(document.getElementById('successModal'));
        successModal.show();
    });
</script>
@endif
 

{{-- JS to remove existing files --}}
<script>
document.addEventListener('DOMContentLoaded', function() {
    document.querySelectorAll('.remove-file-btn').forEach(function(button) {
        button.addEventListener('click', function() {
            const li = this.closest('li');
            const fileId = li.getAttribute('data-id');

            if(!confirm('Are you sure you want to remove this file?')) return;

            fetch(`/applications/document/${fileId}/delete`, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json'
                }
            }).then(res => res.json())
              .then(data => {
                  if(data.success) {
                      li.remove();
                  } else {
                      alert('Failed to remove file.');
                  }
              });
        });
    });
});
</script> <script>


    document.addEventListener('DOMContentLoaded', function() {
    const allowedExtensions = ['pdf', 'png', 'jpg', 'jpeg'];
    const maxSize = 4 * 1024 * 1024; // 4MB

    // Target all file inputs inside attachments card
    const fileInputs = document.querySelectorAll('.card-body input[type="file"]');

    fileInputs.forEach(input => {
        input.addEventListener('change', function() {
            const files = Array.from(input.files);
            if (!files.length) return;

            for (const file of files) {
                const ext = file.name.split('.').pop().toLowerCase();
                if (!allowedExtensions.includes(ext)) {
                    alert(`❌ Invalid file type: ${file.name}. Only PDF, PNG, JPG, JPEG allowed.`);
                    input.value = '';
                    return;
                }
                if (file.size > maxSize) {
                    alert(`❌ File too large: ${file.name}. Max size is 4MB.`);
                    input.value = '';
                    return;
                }
            }

            const fileNames = files.map(f => f.name).join('\n');
            const proceed = confirm(`You are about to upload:\n${fileNames}\nProceed?`);
            if (!proceed) {
                input.value = '';
            }
        });
    });
});

</script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const yearInputs = document.querySelectorAll('.year-input');
    const currentYear = new Date().getFullYear();

    yearInputs.forEach(input => {
        const errorMsg = input.nextElementSibling; // assumes <small> is next
        input.addEventListener('input', function() {
            const year = parseInt(input.value, 10);
            if (isNaN(year) || year < 1900 || year > currentYear) {
                errorMsg.classList.remove('d-none');
                input.classList.add('is-invalid');
            } else {
                errorMsg.classList.add('d-none');
                input.classList.remove('is-invalid');
            }
        });
    });
});
</script>
@endsection
