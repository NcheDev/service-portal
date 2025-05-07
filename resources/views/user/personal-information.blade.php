<div class="container">
    <h2>Personal Information</h2>

    {{-- Show success or error messages --}}
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form id="personalInfoForm" 
          action="{{ route('personal.storeOrUpdate') }}" 
          method="POST" 
          enctype="multipart/form-data">
          
        @csrf
        <input type="hidden" name="_method" value="{{ isset($personalInfo) ? 'PUT' : 'POST' }}">

        <div class="form-group">
            <label for="full_name">Full Name:</label>
            <input type="text" name="full_name" class="form-control" id="full_name" 
                   value="{{ old('full_name', $personalInfo->full_name ?? '') }}" required>
        </div>

        <div class="form-group">
            <label for="email">Email:</label>
            <input type="email" name="email" class="form-control" id="email" 
                   value="{{ old('email', $personalInfo->email ?? '') }}" required>
        </div>

        <div class="form-group">
            <label for="contact_address">Contact Address:</label>
            <input type="text" name="contact_address" class="form-control" id="contact_address" 
                   value="{{ old('contact_address', $personalInfo->contact_address ?? '') }}" required>
        </div>

        <div class="form-group">
            <label for="physical_address">Physical Address:</label>
            <input type="text" name="physical_address" class="form-control" id="physical_address" 
                   value="{{ old('physical_address', $personalInfo->physical_address ?? '') }}" required>
        </div>

        <div class="form-group">
            <label for="personal_statement">Personal Statement:</label>
            <textarea name="personal_statement" class="form-control" id="personal_statement" rows="4" required>{{ old('personal_statement', $personalInfo->personal_statement ?? '') }}</textarea>
        </div>

        <div class="form-group">
            <label for="national_id">Upload National ID (jpg, png, pdf):</label>
            <input type="file" name="national_id" class="form-control-file" id="national_id">
        </div>

        @if(!empty($personalInfo->national_id_path))
            <div class="form-group">
                <label>Current National ID:</label>
                <div>
                    <a href="{{ Storage::url($personalInfo->national_id_path) }}" target="_blank">View Uploaded File</a>
                </div>
            </div>
        @endif

        <button type="submit" class="btn btn-primary">Save Information</button>
    </form>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

<style>
    body {
        background-color: #f7f5f9;
        font-family: 'Segoe UI', sans-serif;
    }

    .container {
        max-width: 700px;
        margin: 50px auto;
        background: white;
        padding: 40px;
        border-radius: 12px;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
    }

    h2 {
        color: #52074f;
        margin-bottom: 30px;
        font-weight: 700;
        text-align: center;
    }

    label {
        color: #52074f;
        font-weight: 600;
    }

    .form-control {
        border-radius: 8px;
        border: 1px solid #ddd;
        box-shadow: none;
    }

    .btn-primary {
        background-color: #dd8027;
        border-color: #dd8027;
        font-weight: 600;
        border-radius: 8px;
        padding: 10px 20px;
    }

    .btn-primary:hover {
        background-color: #c86f20;
        border-color: #c86f20;
    }

    .alert-success {
        background-color: #dff4e5;
        color: #317b39;
        border-left: 5px solid #34a853;
    }

    .alert-danger {
        background-color: #fdecea;
        color: #b71c1c;
        border-left: 5px solid #dd2c00;
    }

</style>
