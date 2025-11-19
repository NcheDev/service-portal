@extends('layouts.user-dashboard')
@section('content')

@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show mt-3" role="alert">
        <i class="bi bi-check-circle me-2"></i>
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif 
 
{{-- Header with My Applications link --}}
<div class="d-flex justify-content-between align-items-center mb-4">
     
    <div class="btn-group" role="group" aria-label="Application Actions">
        <a href="{{ route('application.create') }}" 
           class="btn btn-sm text-white" 
           style="background-color:#52074f; border-radius:25px;">
           ➕ New Application
        </a>

        <a href="{{ route('applications.my') }}" 
           class="btn btn-sm btn-outline-warning" 
           style="border-radius:25px;">
           📋 My Applications
        </a>
    </div>
</div>


<div class="form-card">

    <h2 class="form-header fw-bold" 
        style="color:#52074f; font-family:'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; letter-spacing:1px;">
        Qualification Evaluation Application
    </h2>

    @php
    $personalInfo = \App\Models\PersonalInformation::where('user_id', auth()->id())->first();

    $personalInfoComplete = $personalInfo 
        && $personalInfo->first_name 
        && $personalInfo->surname 
        && $personalInfo->primary_phone 
         && $personalInfo->date_of_birth 
        && $personalInfo->physical_address;
@endphp

@if(!$personalInfoComplete)
    <div class="alert alert-danger shadow-sm mt-3">
        <strong>⚠️ Action Required:</strong> You must 
        <a href="{{ route('user.personal-info') }}" class="text-decoration-underline fw-bold text-danger">
            complete your personal information
        </a> 
        before applying.
    </div>
@else
    <form id="application-form" action="{{ route('application.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        {{-- Applicant Information --}}
        <div class="mb-4 " style="border-color:#dd8027;">
         </div>
        <div class="row g-4 mb-4">
            <div class="col-md-6">
                <label for="processing_type" class="form-label fw-bold">Processing Type <span class="text-danger">*</span></label>
                <select class="form-select" name="processing_type" id="processing_type" required>
                    <option value="normal" {{ old('processing_type') == 'normal' ? 'selected' : '' }}>Normal</option>
                    <option value="express" {{ old('processing_type') == 'express' ? 'selected' : '' }}>Express</option>
                </select>
                @error('processing_type') 
                    <div class="text-danger small">{{ $message }}</div> 
                @enderror
            </div>
        </div>

        {{-- Qualification / Award --}}
       <div class="mb-4 " style="border-color:#dd8027;"></div>

@php
    $qualifications = old('qualifications', [['name'=>'','program_name'=>'','year'=>'','institution'=>'','country'=>'','merit'=>'']]);
    $countries = config('countries');
@endphp

@foreach($qualifications as $i => $qual)
<div class="row g-4 mb-3">

  {{-- Qualification Level --}}
<div class="col-md-6">
    <label class="form-label fw-bold" 
           data-bs-toggle="tooltip" 
           title="Select the level of qualification you obtained (Master's, Degree, Diploma)">
        Qualification Level <span class="text-danger">*</span>
    </label>
    <select name="qualifications[{{ $i }}][name]" 
            class="form-select" 
            required>
        <option value="">-- Select Qualification Level --</option>
        <option value="PhD" {{ $qual['name'] == 'PhD' ? 'selected' : '' }}>PhD / Doctorate</option>
        <option value="Masters" {{ $qual['name'] == 'Masters' ? 'selected' : '' }}>Master’s Degree</option>
        <option value="Degree" {{ $qual['name'] == 'Degree' ? 'selected' : '' }}>Bachelor’s Degree</option>
        <option value="Diploma" {{ $qual['name'] == 'Diploma' ? 'selected' : '' }}>Diploma</option>
        <option value="Certificate" {{ $qual['name'] == 'Certificate' ? 'selected' : '' }}>Certificate</option>
    </select>
    <div class="col-md-6" id="other-qualification-{{ $i }}" style="display:none;">
    <label class="form-label fw-bold">Specify Other Qualification</label>
    <input type="text" 
           name="qualifications[{{ $i }}][other_name]" 
           class="form-control" 
           placeholder=" Postgraduate Diploma in Project Management">
</div>

    @error("qualifications.$i.name") 
        <div class="text-danger small">{{ $message }}</div> 
    @enderror
</div>


    {{-- Program Name --}}
    <div class="col-md-6">
        <label class="form-label fw-bold" 
               data-bs-toggle="tooltip" 
               title="Specify the specific program title under the qualification">
            Field of Study  <span class="text-danger">*</span>
        </label>
        <input type="text" 
               name="qualifications[{{ $i }}][program_name]" 
               class="form-control"
               placeholder=" Public Health"
               value="{{ $qual['program_name'] }}">
        @error("qualifications.$i.program_name") 
            <div class="text-danger small">{{ $message }}</div> 
        @enderror
    </div>

    {{-- Year Obtained --}}
    <div class="col-md-6">
        <label class="form-label fw-bold" 
               data-bs-toggle="tooltip" 
               title="Enter the year you were officially awarded this qualification">
            Year Obtained  <span class="text-danger">*</span>
        </label>
        <input type="number" 
               name="qualifications[{{ $i }}][year]" 
               class="form-control"
               placeholder="2020"
               value="{{ $qual['year'] }}" 
               min="1900" 
               max="{{ date('Y') }}" 
               required>
        @error("qualifications.$i.year") 
            <div class="text-danger small">{{ $message }}</div> 
        @enderror
    </div>

    {{-- Institution --}}
    <div class="col-md-6">
        <label class="form-label fw-bold" 
               data-bs-toggle="tooltip" 
               title="Enter the full name of the awarding institution or university">
            Awarding Institution <span class="text-danger">*</span>
        </label>
        <input type="text" 
               name="qualifications[{{ $i }}][institution]" 
               class="form-control"
               placeholder="University of Malawi"
               value="{{ $qual['institution'] }}">
        @error("qualifications.$i.institution") 
            <div class="text-danger small">{{ $message }}</div> 
        @enderror
    </div>

    {{-- Merit / Class --}}
    <div class="col-md-6">
        <label class="form-label fw-bold" 
               data-bs-toggle="tooltip" 
               title="Select your qualification class or merit (if applicable)">
            Merit / Class <span class="text-danger">*</span>
        </label>
        <select name="qualifications[{{ $i }}][merit]" class="form-select">
            <option value="">-- Select Merit / Class --</option>
            <option value="Distinction" {{ $qual['merit'] == 'Distinction' ? 'selected' : '' }}>Distinction</option>
            <option value="Credit" {{ $qual['merit'] == 'Credit' ? 'selected' : '' }}>Credit</option>
            <option value="Pass" {{ $qual['merit'] == 'Pass' ? 'selected' : '' }}>Pass</option>
         </select>
        @error("qualifications.$i.merit") 
            <div class="text-danger small">{{ $message }}</div> 
        @enderror
    </div>
            <div class="col-md-6">
                <label class="form-label fw-bold">Country Obtained  <span class="text-danger">*</span></label>
                <select name="qualifications[{{ $i }}][country]" class="form-select" required>
                    <option value="">-- Select Country --</option>
                    @foreach($countries as $country)
                        <option value="{{ $country }}" {{ $qual['country'] == $country ? 'selected' : '' }}>
                            {{ $country }}
                        </option>
                    @endforeach
                </select>
                @error("qualifications.$i.country") 
                    <div class="text-danger small">{{ $message }}</div> 
                @enderror
            </div>
        </div>
        @endforeach

       <!-- ========================= ATTACHMENTS SECTION ========================= -->
<div class="card shadow-sm border-0 mb-4">
    <div class="card-header  fw-bold" style=" color:#52074f; border-radius: 8px 8px 0 0;">
        <i class="bi bi-paperclip me-2"></i> Attachments
    </div>

    <div class="card-body" style="background-color: #f9f9f9;  ">
      <p class="text-muted mb-4">
    Please upload all supporting documents for your application below. 
    Ensure that the files are in <strong>PDF, JPG, DOC, or PNG</strong> format, 
    and each file is clearly labeled. <strong>Maximum file size: 4 MB per file.</strong>
</p>


     <div class="row g-4">
    @foreach([
        'certificates' => 'Qualification Certificates',
        'academic_records' => 'Academic Records (optional)',
        'previous_evaluations' => 'Previous Evaluations',
        'syllabi' => 'Syllabi'
    ] as $field => $label)
        <div class="col-md-6">
            <label class="form-label fw-bold text-dark">
                {{ $label }}
                @if($field === 'certificates') <span class="text-danger">*</span> @endif
            </label>

            <input type="file"
                   name="{{ $field }}[]"
                   class="form-control border-secondary file-input @error($field) is-invalid @enderror"
                   multiple
                   data-type="{{ $field }}"
                   @if($field === 'certificates') required @endif>

            <ul class="list-group mt-2" id="{{ $field }}-list"></ul>

            {{-- Inline validation error message under the file list --}}
            @error($field)
                <div class="invalid-feedback d-block small mt-1">{{ $message }}</div>
            @enderror
        </div>
    @endforeach
</div>

<div class="mt-4">
    <div class="alert alert-warning mb-0 py-2 small">
        <i class="bi bi-info-circle me-2"></i>
        <strong>Tip:</strong> Upload all your documents before submitting to avoid delays in processing.
    </div>
</div>

<script>
document.querySelectorAll('.file-input').forEach(input => {
    const parent = input.closest('.col-md-6');
    const label = parent.querySelector('.form-label');
    const fieldType = input.dataset.type;

    input.addEventListener('change', function () {
        const list = document.getElementById(fieldType + '-list');
        list.innerHTML = ''; // Clear previous list

        const allowedExtensions = ['pdf', 'jpg', 'jpeg', 'png', 'doc', 'docx'];
        const maxFileSize = 5 * 1024 * 1024; // 5 MB
        let validFiles = [];
        let errors = [];

        Array.from(this.files).forEach((file, index) => {
            const ext = file.name.split('.').pop().toLowerCase();
            let errorMsg = '';

            // Validate type and size
            if (!allowedExtensions.includes(ext)) {
                errorMsg = `Invalid file type: .${ext}`;
            } else if (file.size > maxFileSize) {
                errorMsg = `File too large: ${(file.size / 1024 / 1024).toFixed(2)} MB`;
            }

            // Create list item
            const li = document.createElement('li');
            li.className = 'list-group-item d-flex justify-content-between align-items-center';
            li.innerHTML = `
                ${file.name}
                <div class="d-flex align-items-center">
                    <span class="badge rounded-pill ${errorMsg ? 'bg-danger' : 'bg-success'}">
                        ${errorMsg ? errorMsg : 'Ready'}
                    </span>
                    <button type="button" class="btn btn-sm btn-outline-danger ms-2 remove-file">X</button>
                </div>
            `;
            list.appendChild(li);

            if (!errorMsg) validFiles.push(file);
            else errors.push(file.name);

            // Remove file logic
            li.querySelector('.remove-file').addEventListener('click', () => {
                const dt = new DataTransfer();
                Array.from(input.files).forEach((f) => {
                    if (f.name !== file.name) dt.items.add(f);
                });
                input.files = dt.files;
                li.remove();

                // If no files left, show the input again
                if (input.files.length === 0) {
                    input.classList.remove('d-none');
                    label.classList.remove('text-success');
                }
            });
        });

        // Keep only valid files
        const dt = new DataTransfer();
        validFiles.forEach(f => dt.items.add(f));
        this.files = dt.files;

        // Show alert if errors
        if (errors.length > 0) {
            alert('Some files were rejected:\n' + errors.join('\n'));
        }

        // ✅ If at least one valid file, hide input and highlight label
        if (this.files.length > 0) {
            this.classList.add('d-none'); // hide the file input
            label.classList.add('text-success');
        }
    });
});
</script>

<!-- ====================== END ATTACHMENTS SECTION ======================= -->
    </div></div>
<hr>
       {{-- 🧾 Consent Section --}}<div class="shadow-sm border rounded p-3 mb-4" style="border-left: 4px solid #dd8027; background-color: #fff8f0;">
    <h5 class="fw-bold text-nche-primary mb-2">
        Consent & Declaration <span class="text-danger">*</span>
    </h5>
    <p class="mb-2">
        By submitting this application, I hereby confirm that:
    </p>
    <ul class="mb-3">
        <li>I have provided accurate and truthful information to the best of my knowledge.</li>
        <li>All attached documents are certified true copies of the originals.</li>
        <li>I understand that submission of forged or falsified documents will result in <strong>disqualification</strong>.</li>
        <li>I consent to NCHE sharing my information with relevant institutions and authorities for verification purposes.</li>
    </ul>

    {{-- ✅ Agreement Checkbox --}}
    <div class="form-check mt-2">
        <input class="form-check-input" type="checkbox" id="consent_agree" name="consent_agree" required>
        <label class="form-check-label fw-bold text-danger" for="consent_agree">
            I have read, understood, and agree to the above terms and conditions.
        </label>
    </div>
</div>


        {{-- Submit --}}
        <div class="text-center mt-4">
    <button type="button" id="review-btn" class="btn btn-primary px-5 py-2 fw-semibold shadow">Review Form</button>
</div>

    </form>
    @endif
    <!-- Review Modal -->
<div class="modal fade" id="reviewModal" tabindex="-1" aria-labelledby="reviewModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-scrollable modal-fullscreen-sm-down" style="margin-top: 60px;">
    <div class="modal-content border-0 shadow-lg">
      
      <!-- Modal Header -->
      <div class="modal-header" style="background-color:#52074f; color:white;">
        <h5 class="modal-title fw-bold" id="reviewModalLabel">Review Your Submission</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      
      <!-- Modal Body -->
      <div class="modal-body" style="background-color:#f9f9f9;">
        <div id="review-content" class="p-3"></div>
      </div>
      
      <!-- Modal Footer -->
      <div class="modal-footer bg-light">
        <button type="button" class="btn btn-outline-secondary px-4 py-2 fw-semibold" data-bs-dismiss="modal">
          Go Back & Edit
        </button>
        <button type="button" id="submit-btn" class="btn" style="background-color:#dd8027; color:white; font-weight:600; padding:0.5rem 1.5rem;">
          Confirm & Submit
        </button>
      </div>
      
    </div>
  </div>
</div>
 


</div>
 <style>


/* Qualification Evaluation Form Styles */
.form-card {
    background: #fff;
    border-radius: 16px;
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.08);
    padding: 40px;
    max-width: 900px;
    margin: 0 auto;
    transition: all 0.3s ease-in-out;
}

.form-card:hover {
    box-shadow: 0 6px 22px rgba(0, 0, 0, 0.1);
}

.form-header {
    color: #52074f;
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    font-weight: 700;
    text-align: center;
    letter-spacing: 1px;
    position: relative;
    padding-bottom: 10px;
    
    margin-bottom: 30px;
}

.form-header::after {
    content: "";
    position: absolute;
    bottom: 0;
    left: 50%;
    transform: translateX(-50%);
    width: 600px;
    height: 3px;
    background-color: #dd8027;
    border-radius: 3px;
}

label.form-label {
    color: #52074f;
}

button.btn-primary {
    background-color: #dd8027;
    border: none;
    border-radius: 8px;
}

button.btn-primary:hover {
    background-color: #c56f1f;
}

/* Alerts */
.alert-info {
    background-color: #fdf6f0;
    border-left: 5px solid #dd8027;
    color: #52074f;
}

/* Responsive */
@media (max-width: 768px) {
    .form-card {
        padding: 25px;
    }
    .form-header::after {
        width: 150px;
    }
}
.btn-outline-nche-orange {
    border: 1.8px solid #dd8027;
    color: #dd8027;
    border-radius: 6px;
    font-weight: 500;
    transition: 0.3s ease;
}

.btn-outline-nche-orange:hover {
    background-color: #dd8027;
    color: #fff;
}

#reviewModal .btn:hover {
    opacity: 0.9;
}
#review-content h6 {
    color: #52074f;
    font-weight: 600;
}


 </style>
 
 

 
<script>
document.addEventListener("DOMContentLoaded", function() {
    const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
    tooltipTriggerList.forEach(el => new bootstrap.Tooltip(el))

    // Show 'Other' text field when selected
    document.querySelectorAll('select[name^="qualifications"]').forEach(select => {
        select.addEventListener('change', function() {
            const index = this.name.match(/\d+/)[0];
            const otherField = document.getElementById(`other-qualification-${index}`);
            otherField.style.display = (this.value === 'Other') ? 'block' : 'none';
        });
    });
});
</script> 
 

<script>
document.addEventListener('DOMContentLoaded', function () {
    const currentYear = new Date().getFullYear();

    // Select all year inputs
    document.querySelectorAll('input[name^="qualifications"][name$="[year]"]').forEach(input => {

        input.addEventListener('input', function () {
            const year = parseInt(this.value, 10);
            const feedbackId = this.dataset.feedbackId;

            // Remove previous feedback if exists
            let existingFeedback = this.parentElement.querySelector('.year-feedback');
            if (existingFeedback) existingFeedback.remove();

            // Validation
            if (isNaN(year) || year < 1900 || year > currentYear) {
                const div = document.createElement('div');
                div.className = 'text-danger small year-feedback';
                div.innerText = `Please enter a valid year between 1900 and ${currentYear}.`;
                this.parentElement.appendChild(div);
            }
        });
    });
});
</script>
<script>
document.getElementById('review-btn').addEventListener('click', function () {

    const form = document.getElementById('application-form');
    let valid = true;
    const currentYear = new Date().getFullYear();

    // Remove all previous errors
    document.querySelectorAll('.validation-error-msg').forEach(e => e.remove());

    // ------------------------------
    // REQUIRED FIELDS
    // ------------------------------
    form.querySelectorAll('[required]').forEach(field => {
        if (!field.value || field.value.trim() === '') {
            valid = false;
            showError(field, "This field is required.");
        }
    });

    // ------------------------------
    // YEAR VALIDATION
    // ------------------------------
    const yearInputs = form.querySelectorAll('input[name^="qualifications"][name$="[year]"]');
    yearInputs.forEach(input => {
        const year = parseInt(input.value, 10);

        if (isNaN(year) || year < 1900 || year > currentYear) {
            valid = false;
            showError(input, `Enter a valid year (1900 - ${currentYear}).`);
        }
    });

    // ------------------------------
    // CERTIFICATE REQUIRED
    // ------------------------------
    const certInput = document.querySelector('input[name="certificates[]"]');
    if (certInput && certInput.files.length === 0) {
        valid = false;
        showError(certInput, "At least one certificate is required.");
    }

    // ------------------------------
    // CONSENT CHECK
    // ------------------------------
    const consent = document.getElementById('consent_agree');
    if (!consent.checked) {
        valid = false;
        showError(consent, "You must agree before continuing.");
    }

    // ------------------------------
    // STOP IF INVALID
    // ------------------------------
    if (!valid) {
        scrollToFirstError();
        return;
    }

    // =========================================================
    // 🔥 BUILD THE REVIEW CONTENT HERE
    // =========================================================
    const reviewContent = document.getElementById('review-content');
    reviewContent.innerHTML = "";  

    // 1️⃣ Processing Type
    const processingType = form.querySelector('[name="processing_type"]').value; 
    reviewContent.innerHTML += `
        <div class="mb-3 p-2 rounded" style="background-color:#fff3e6; border-left: 4px solid #dd8027;">
            <strong>Processing Type:</strong> ${processingType}
        </div>
    `;

    // 2️⃣ Qualifications
    const qualificationBlocks = form.querySelectorAll('[name^="qualifications"]');
    let qualifications = {};

    qualificationBlocks.forEach(input => {
        const match = input.name.match(/qualifications\[(\d+)\]\[(\w+)\]/);
        if (match) {
            const index = match[1];
            const field = match[2];
            if (!qualifications[index]) qualifications[index] = {};
            qualifications[index][field] = input.value;
        }
    });

    reviewContent.innerHTML += `<h6 class="mt-3 mb-2">Qualifications / Awards:</h6>`;
    Object.values(qualifications).forEach((qual, idx) => {
        reviewContent.innerHTML += `
            <div class="mb-2 p-2 rounded shadow-sm" style="background-color:white; border-left: 4px solid #52074f;">
                <strong>Qualification ${idx+1}</strong><br>
                <div><strong>Level:</strong> ${qual.name || '-'}</div>
                <div><strong>Program:</strong> ${qual.program_name || '-'}</div>
                <div><strong>Year:</strong> ${qual.year || '-'}</div>
                <div><strong>Institution:</strong> ${qual.institution || '-'}</div>
                <div><strong>Merit/Class:</strong> ${qual.merit || '-'}</div>
                <div><strong>Country:</strong> ${qual.country || '-'}</div>
            </div>
        `;
    });

    // 3️⃣ Attachments
    const attachmentInputs = Array.from(form.querySelectorAll('.file-input'));
    let attachmentsHTML = ``;
    let anyFiles = false;

    attachmentInputs.forEach(input => {
        if (input.files.length > 0) {
            anyFiles = true;
            const label = input.closest('.col-md-6').querySelector('label').innerText;
            const filenames = Array.from(input.files).map(f => f.name).join(', ');
            attachmentsHTML += `
                <div class="mb-2 p-2 rounded" style="background-color:#fff3e6; border-left: 4px solid #dd8027;">
                    <strong>${label}:</strong> ${filenames}
                </div>
            `;
        }
    });

    reviewContent.innerHTML += `<h6 class="mt-3 mb-2">Attachments:</h6>`;
    reviewContent.innerHTML += anyFiles ? attachmentsHTML : `
        <div class="mb-2 p-2 rounded" style="background-color:#fff3e6; border-left: 4px solid #dd8027;">
            No files uploaded
        </div>
    `;

    // 4️⃣ Consent
    reviewContent.innerHTML += `
        <div class="mt-3 p-2 rounded" style="background-color:#ffe6e6; border-left:4px solid #dc3545;">
            <strong>Consent Agreed:</strong> Yes
        </div>
    `;

    // =========================================================
    // NOW OPEN THE MODAL (ONLY ONCE)
    // =========================================================
    const reviewModal = new bootstrap.Modal(document.getElementById('reviewModal'));
    reviewModal.show();
});

// =============================
// HELPER FUNCTIONS
// =============================
function showError(field, message) {
    const div = document.createElement('div');
    div.className = "text-danger small validation-error-msg mt-1";
    div.innerText = message;
    field.parentElement.appendChild(div);
    field.classList.add('is-invalid');
}

function scrollToFirstError() {
    const firstError = document.querySelector('.validation-error-msg');
    if (firstError) {
        firstError.scrollIntoView({ behavior: 'smooth', block: 'center' });
    }
}
document.getElementById('submit-btn').addEventListener('click', function () {
    document.getElementById('application-form').submit();
});
</script>

  
@endsection
