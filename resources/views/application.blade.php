@extends('layouts.user-dashboard')
@section('content')

@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show mt-3" role="alert">
        <i class="bi bi-check-circle me-2"></i>
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif
{{-- ✅ SUCCESS MESSAGE --}}
@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show mt-3" role="alert">
        <i class="bi bi-check-circle me-2"></i>
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

{{-- ❌ VALIDATION ERRORS --}}
@if ($errors->any())
    <div class="alert alert-danger alert-dismissible fade show mt-3" role="alert">
        <i class="bi bi-exclamation-triangle me-2"></i>
        <strong>Please fix the following errors:</strong>
        <ul class="mb-0 mt-2 small">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif
{{-- Header with My Applications link --}}
<div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="text-nche-primary fw-bold mb-0">New Application</h4>
    <a href="{{ route('applications.my') }}" class="btn btn-outline-nche-orange">
        <i class="mdi mdi-file-document-outline me-2"></i> View My Applications
    </a>
</div>

<div class="form-card">

    <h2 class="form-header fw-bold" 
        style="color:#52074f; font-family:'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; letter-spacing:1px;">
        Qualification Evaluation Application
    </h2>

    <form id="application-form" action="{{ route('application.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        {{-- Applicant Information --}}
        <div class="mb-4 " style="border-color:#dd8027;">
         </div>
        <div class="row g-4 mb-4">
            <div class="col-md-6">
                <label for="processing_type" class="form-label fw-bold">Processing Type</label>
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
           title="Select the level of qualification you obtained (e.g., Master's, Degree, Diploma)">
        Qualification Level
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
        <option value="Other" {{ $qual['name'] == 'Other' ? 'selected' : '' }}>Other</option>
    </select>
    <div class="col-md-6" id="other-qualification-{{ $i }}" style="display:none;">
    <label class="form-label fw-bold">Specify Other Qualification</label>
    <input type="text" 
           name="qualifications[{{ $i }}][other_name]" 
           class="form-control" 
           placeholder="e.g., Postgraduate Diploma in Project Management">
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
            Program Name
        </label>
        <input type="text" 
               name="qualifications[{{ $i }}][program_name]" 
               class="form-control"
               placeholder="e.g., Public Health"
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
            Year Obtained
        </label>
        <input type="number" 
               name="qualifications[{{ $i }}][year]" 
               class="form-control"
               placeholder="e.g., 2020"
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
            Institution
        </label>
        <input type="text" 
               name="qualifications[{{ $i }}][institution]" 
               class="form-control"
               placeholder="e.g., University of Malawi"
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
            Merit / Class
        </label>
        <select name="qualifications[{{ $i }}][merit]" class="form-select">
            <option value="">-- Select Merit / Class --</option>
            <option value="Distinction" {{ $qual['merit'] == 'Distinction' ? 'selected' : '' }}>Distinction</option>
            <option value="Merit" {{ $qual['merit'] == 'Merit' ? 'selected' : '' }}>Merit</option>
            <option value="Credit" {{ $qual['merit'] == 'Credit' ? 'selected' : '' }}>Credit</option>
            <option value="Pass" {{ $qual['merit'] == 'Pass' ? 'selected' : '' }}>Pass</option>
            <option value="Other" {{ $qual['merit'] == 'Other' ? 'selected' : '' }}>Other</option>
        </select>
        @error("qualifications.$i.merit") 
            <div class="text-danger small">{{ $message }}</div> 
        @enderror
    </div>
            <div class="col-md-6">
                <label class="form-label fw-bold">Country</label>
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

        {{-- Document Uploads --}}
        <div class="mb-4 " style="border-color:#dd8027;">

        </div>
        <div class="row g-4 mb-4">
            <div class="col-md-6">
                <label class="form-label fw-bold">Upload Qualification Certificates</label>
                <input type="file" name="certificates[]" class="form-control" multiple required>
                @error('certificates') <div class="text-danger small">{{ $message }}</div> @enderror
            </div>
            <div class="col-md-6">
                <label class="form-label fw-bold">Upload Academic Records</label>
                <input type="file" name="academic_records[]" class="form-control" multiple required>
                @error('academic_records') <div class="text-danger small">{{ $message }}</div> @enderror
            </div>
        </div>

       {{-- 🧾 Consent Section --}}
<div class="alert alert-warning shadow-sm border-0">
    <h5 class="fw-bold text-nche-primary mb-2">Consent & Declaration</h5>
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
    <div class="form-check">
        <input class="form-check-input" type="checkbox" id="consent_agree" name="consent_agree" required>
        <label class="form-check-label" for="consent_agree">
            I have read, understood, and agree to the above terms and conditions.
        </label>
    </div>
</div>


        {{-- Submit --}}
        <div class="text-center mt-4">
            <button type="submit" class="btn btn-primary px-5 py-2 fw-semibold shadow">Submit Application</button>
        </div>
    </form>
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
 

  
@endsection
