{{-- Personal Information Form Partial --}}
@extends('layouts.user-dashboard')
@section('content')

@if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
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

    <h5>Personal Information</h5>

    <div class="row g-3">
        <div class="col-md-6">
            <label for="first_name" class="form-label">First Name</label>
            <input type="text" name="first_name" class="form-control" 
                   value="{{ old('first_name', $personalInfo?->first_name) }}" required>
        </div>
        <div class="col-md-6">
            <label for="surname" class="form-label">Surname</label>
            <input type="text" name="surname" class="form-control" 
                   value="{{ old('surname', $personalInfo?->surname) }}" required>
        </div>

        <div class="col-md-6">
            <label for="title" class="form-label">Title</label>
            <select name="title" class="form-select" required>
                <option value="">Select Title</option>
                <option value="Mr" {{ old('title', $personalInfo?->title) === 'Mr' ? 'selected' : '' }}>Mr</option>
                <option value="Mrs" {{ old('title', $personalInfo?->title) === 'Mrs' ? 'selected' : '' }}>Mrs</option>
                <option value="Miss" {{ old('title', $personalInfo?->title) === 'Miss' ? 'selected' : '' }}>Miss</option>
                <option value="Dr" {{ old('title', $personalInfo?->title) === 'Dr' ? 'selected' : '' }}>Dr</option>
            </select>
        </div>
        <div class="col-md-6">
            <label for="email" class="form-label">Email</label>
            <input type="email" name="email" class="form-control" 
                   value="{{ old('email', $personalInfo?->email) }}">
        </div>

        <div class="col-md-6">
            <label for="contact_address" class="form-label">Contact Address</label>
            <input type="text" name="contact_address" class="form-control" 
                   value="{{ old('contact_address', $personalInfo?->contact_address) }}">
        </div>
        <div class="col-md-6">
            <label for="physical_address" class="form-label">Physical Address</label>
            <input type="text" name="physical_address" class="form-control" 
                   value="{{ old('physical_address', $personalInfo?->physical_address) }}">
        </div>

        <div class="col-md-6">
            <label for="gender" class="form-label">Gender</label>
            <select name="gender" class="form-select" required>
                <option value="">Select Gender</option>
                <option value="Male" {{ old('gender', $personalInfo?->gender) === 'Male' ? 'selected' : '' }}>Male</option>
                <option value="Female" {{ old('gender', $personalInfo?->gender) === 'Female' ? 'selected' : '' }}>Female</option>
            </select>
        </div>
        <div class="col-md-6">
            <label for="date_of_birth" class="form-label">Date of Birth</label>
            <input type="date" name="date_of_birth" class="form-control" 
                   value="{{ $personalInfo?->date_of_birth ?? now()->format('Y-m-d') }}" readonly>
        </div>

        <div class="col-md-6">
            <label for="country" class="form-label">Country</label>
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
            <label for="next_of_kin" class="form-label">Next of Kin</label>
            <input type="text" name="next_of_kin" class="form-control" 
                   value="{{ old('next_of_kin', $personalInfo?->next_of_kin) }}">
        </div>

        <div class="col-md-6">
            <label for="kin_contact" class="form-label">Next of Kin Phone</label>
            <input type="text" name="kin_contact" class="form-control" 
                   value="{{ old('kin_contact', $personalInfo?->kin_contact) }}">
        </div>
        <div class="col-md-6">
            <label for="national_id_number" class="form-label">National ID Number</label>
            <input type="text" name="national_id_number" class="form-control" 
                   value="{{ old('national_id_number', $personalInfo?->national_id_number) }}">
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
</script>
@endsection