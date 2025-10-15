{{-- Personal Information Form Partial --}}
@extends('layouts.user-dashboard')

@section('content')

{{-- ✅ SUCCESS MESSAGE --}}
@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show mt-3" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

{{-- ❌ VALIDATION ERRORS --}}
@if ($errors->any())
    <div class="alert alert-danger alert-dismissible fade show mt-3" role="alert">
        <strong>There were some problems with your input:</strong>
        <ul class="mb-0 mt-2">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif
 

<form id="personal-info-form" action="{{ route('personal.storeOrUpdate') }}" method="POST" enctype="multipart/form-data">
    @csrf

    <!-- Profile Picture -->
    <div class="text-center mb-4">
        <label for="profile_picture">
            <img id="profile-picture-preview"
                 src="{{ $personalInfo?->profile_picture ? Storage::url($personalInfo->profile_picture) : 'https://via.placeholder.com/180' }}"
                 alt="Profile Picture">
        </label>
        <input type="file" id="profile_picture" name="profile_picture" class="d-none" accept="image/*">
    </div>

    <h5>Applicant Details</h5>
    

    <div class="row g-3">  <div class="col-md-3">
        <label for="application_type" class="form-label">Application Type <span class="text-danger">*</span></label>
        <select name="application_type" id="application_type" class="form-select" required>
            <option value="">Select Type</option>
            <option value="Individual" {{ old('application_type', $personalInfo?->application_type) === 'Individual' ? 'selected' : '' }}>Individual</option>
            <option value="Institution" {{ old('application_type', $personalInfo?->application_type) === 'Institution' ? 'selected' : '' }}>Institution</option>
        </select>
    </div>

    <!-- Institution Name -->
    <div class="col-md-3" id="institution-name-field" 
         style="{{ old('application_type', $personalInfo?->application_type) === 'Institution' ? 'display:block;' : 'display:none;' }}">
        <label for="institution_name" class="form-label">Institution Name <span class="text-danger">*</span></label>
        <input type="text" name="institution_name" id="institution_name" class="form-control"
               value="{{ old('institution_name', $personalInfo?->institution_name) }}"
               placeholder="University of Malawi"
               title="Enter the full name of your institution">
    </div>

    <!-- New Field Next to Institution -->
    <div class="col-md-3" id="institution-position-field" 
         style="{{ old('application_type', $personalInfo?->application_type) === 'Institution' ? 'display:block;' : 'display:none;' }}">
        <label for="institution_position" class="form-label">Position <span class="text-danger">*</span></label>
        <input type="text" name="institution_position" id="institution_position" class="form-control"
               value="{{ old('institution_position', $personalInfo?->institution_position) }}"
               placeholder="Your Position ie HR"
               title="Enter your position in the institution">
    </div>

 <div class="col-md-3"></div>
       <div class="col-md-6">
    <label for="first_name" class="form-label">First Name <span class="text-danger">*</span></label>
    <input type="text" name="first_name" class="form-control" 
           value="{{ old('first_name', $personalInfo?->first_name) }}" 
           placeholder="  John"
           title="Enter your first name" 
           required>
</div>

<div class="col-md-6">
    <label for="surname" class="form-label">Surname <span class="text-danger">*</span></label>
    <input type="text" name="surname" class="form-control" 
           value="{{ old('surname', $personalInfo?->surname) }}" 
           placeholder="  Banda"
           title="Enter your surname" 
           required>
</div>

        <div class="col-md-6">
            <label for="title" class="form-label">Title  <span class="text-danger">*</span></label>
            <select name="title" class="form-select" required>
                <option value="">Select Title</option>
                <option value="Mr" {{ old('title', $personalInfo?->title) === 'Mr' ? 'selected' : '' }}>Mr</option>
                <option value="Mrs" {{ old('title', $personalInfo?->title) === 'Mrs' ? 'selected' : '' }}>Mrs</option>
                <option value="Miss" {{ old('title', $personalInfo?->title) === 'Miss' ? 'selected' : '' }}>Miss</option>
                <option value="Dr" {{ old('title', $personalInfo?->title) === 'Dr' ? 'selected' : '' }}>Dr</option>
            </select>
        </div>
<div class="col-md-6">
    <label for="email" class="form-label">Email  <span class="text-danger">*</span></label>
    <input type="email" name="email" class="form-control" 
           value="{{ old('email', $personalInfo?->email) }}"
           placeholder="  user@example.com"
           title="Enter a valid email address,   user@example.com">
</div>

        
<div class="col-md-6">
    <label for="gender" class="form-label">Gender <span class="text-danger">*</span></label>
    <select name="gender" id="gender" class="form-select" required>
        <option value="">Select Gender</option>
        <option value="Male" {{ old('gender', $personalInfo?->gender) == 'Male' ? 'selected' : '' }}>Male</option>
        <option value="Female" {{ old('gender', $personalInfo?->gender) == 'Female' ? 'selected' : '' }}>Female</option>
     </select>
</div>

        <div class="col-md-6">
            <label for="date_of_birth" class="form-label">Date of Birth <span class="text-danger">*</span></label>
            <input type="date" name="date_of_birth" class="form-control" 
                   value="{{ old('date_of_birth', $personalInfo?->date_of_birth) }}">
        </div>

        <div class="col-md-6">
            <label for="contact_address" class="form-label">Contact Address  <span class="text-danger">*</span></label>
            <input type="text" name="contact_address" class="form-control" 
                   value="{{ old('contact_address', $personalInfo?->contact_address) }}">
        </div>

        <div class="col-md-6">
            <label for="physical_address" class="form-label">Postal Address <span class="text-danger">*</span></label>
            <input type="text" name="physical_address" class="form-control" 
                   value="{{ old('physical_address', $personalInfo?->physical_address) }}">
        </div> 
        


<div class="row g-3">
 

    {{-- Primary Phone --}}
    <div class="col-md-6">
        <label for="primary_phone" class="form-label">Primary Phone <span class="text-danger">*</span></label>
        <div class="input-group">
            <select name="primary_country_code" class="form-select" required>
                @foreach(config('country_codes') as $code => $country)
                    <option value="{{ $code }}" {{ old('primary_country_code', $personalInfo?->primary_country_code) == $code ? 'selected' : '' }}>
                        {{ $code }} {{ $country }}
                    </option>
                @endforeach
            </select>
            <input type="tel" name="primary_phone" class="form-control" 
                   value="{{ old('primary_phone', $personalInfo?->primary_phone) }}" 
                   placeholder="Enter phone number" required>
        </div>
    </div>

    {{-- Secondary Phone --}}
    <div class="col-md-6">
        <label for="secondary_phone" class="form-label">Secondary Phone <span class="text-danger">*</span></label>
        <div class="input-group">
            <select name="secondary_country_code" class="form-select">
                @foreach(config('country_codes') as $code => $country)
                    <option value="{{ $code }}" {{ old('secondary_country_code', $personalInfo?->secondary_country_code) == $code ? 'selected' : '' }}>
                        {{ $code }} {{ $country }}
                    </option>
                @endforeach
            </select>
            <input type="tel" name="secondary_phone" class="form-control" 
                   value="{{ old('secondary_phone', $personalInfo?->secondary_phone) }}" 
                   placeholder="Enter phone number">
        </div>
    </div>

</div>


        <div class="col-md-6">
            <label for="country" class="form-label">Country <span class="text-danger">*</span></label>
           @php
                $countries = Symfony\Component\Intl\Countries::getNames();
           @endphp
           <select name="country" class="form-select" required>
               <option value="">Select Country</option>
               @foreach($countries as $code => $name)
                   <option value="{{ $name }}" {{ old('country', $personalInfo?->country) === $name ? 'selected' : '' }}>
                       {{ $name }}
                   </option>
               @endforeach
           </select>
        </div>
 

       <div class="col-md-6">
    <label for="nationality" class="form-label">Nationality  <span class="text-danger">*</span></label>
    <select name="nationality" id="nationality" class="form-select" required>
        <option value="">-- Select Nationality --</option>
        @foreach (config('nationalities') as $nation)
            <option value="{{ $nation }}" 
                {{ old('nationality', $personalInfo?->nationality) == $nation ? 'selected' : '' }}>
                {{ $nation }}
            </option>
        @endforeach
    </select>
</div>

<!-- Hidden by default, shown only if Malawian -->
<div class="col-md-6" id="national_id_section" 
     style="display: {{ old('nationality', $personalInfo?->nationality) == 'Malawian' ? 'block' : 'none' }};">
    <label for="national_id_number" class="form-label">National ID Number <span class="text-danger">*</span></label>
    <input type="text" name="national_id_number" id="national_id_number"
           class="form-control"
           value="{{ old('national_id_number', $personalInfo?->national_id_number) }}"
           placeholder="Enter National ID Number">
</div>

    </div>

    <!-- Submit -->
    <div class="text-end mt-4">
        <button type="submit" class="btn custom-btn-purple">
            {{ isset($personalInfo) ? 'Update Information' : 'Save Information' }}
        </button>
    </div>
</form>

{{-- Inline Styles --}}
<style>
form#personal-info-form {
    max-width: 1000px;
    margin: 20px auto;
    padding: 30px;
    background-color: #fff;
    border-radius: 12px;
    box-shadow: 0 6px 18px rgba(0,0,0,0.1);
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
}
form#personal-info-form h5 {
    font-weight: 600;
    color: #52074f;
    border-bottom: 2px solid #dd8027;
    padding-bottom: 8px;
    margin-bottom: 20px;
}
#profile-picture-preview {
    width: 120px;
    height: 120px;
    border-radius: 50%;
    object-fit: cover;
    border: 4px solid #dd8027;
    transition: transform 0.3s ease, box-shadow 0.3s ease;
    cursor: pointer;
}
#profile-picture-preview:hover {
    transform: scale(1.05);
    box-shadow: 0 4px 12px rgba(82, 7, 79, 0.3);
}
.custom-btn-purple {
    background-color: #52074f;
    color: #fff;
    border: none;
    padding: 10px 25px;
    border-radius: 6px;
    font-weight: 600;
    transition: background-color 0.3s ease;
}
.custom-btn-purple:hover {
    background-color: #3e063c;
}
</style>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.19/css/intlTelInput.min.css"/>
<script src="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.19/js/intlTelInput.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.19/js/utils.js"></script>

{{-- Profile Picture Preview Script --}}
<script>
document.getElementById('profile_picture').addEventListener('change', function(event) {
    const preview = document.getElementById('profile-picture-preview');
    const file = event.target.files[0];
    if(file) {
        const reader = new FileReader();
        reader.onload = function(e){ preview.src = e.target.result; };
        reader.readAsDataURL(file);
    }
});
</script><script>
document.addEventListener('DOMContentLoaded', function () {
    const typeSelect = document.getElementById('application_type');
    const institutionField = document.getElementById('institution-name-field');
    const positionField = document.getElementById('institution-position-field');

    function toggleInstitutionFields() {
        if (typeSelect.value === 'Institution') {
            institutionField.style.display = 'block';
            positionField.style.display = 'block';
        } else {
            institutionField.style.display = 'none';
            positionField.style.display = 'none';
            document.getElementById('institution_name').value = '';
            document.getElementById('institution_position').value = '';
        }
    }

    typeSelect.addEventListener('change', toggleInstitutionFields);
});
</script>

 <script>
document.addEventListener('DOMContentLoaded', function () {
    const nationalitySelect = document.getElementById('nationality');
    const idSection = document.getElementById('national_id_section');

    nationalitySelect.addEventListener('change', function () {
        if (this.value === 'Malawian') {
            idSection.style.display = 'block';
        } else {
            idSection.style.display = 'none';
        }
    });
});
</script>


@endsection
