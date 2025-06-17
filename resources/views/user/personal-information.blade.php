<!DOCTYPE html>
<html> 
<head></head>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">

</head>
<body>
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <form id="personal-info-form" action="{{ route('personal.storeOrUpdate') }}" method="POST" enctype="multipart/form-data">
        @csrf
        @if(isset($personalInfo))
            @method('PUT')
        @endif

        

        <!-- Cover Photo -->
<div class="text-center">
  <div class="d-block mb-2 position-relative"
       style="height: 200px; border-radius: 8px; border: 1px solid #ccc;">

    <img src="{{ asset('assets/images/cover.jpg') }}" alt="Cover Photo"
         class="w-100 h-100" style="object-fit: cover; display: block;">

    <!-- Profile Picture Label -->
    <label for="profile_picture"
           class="position-absolute"
           style="left: 40px; bottom: -15px; width: 120px; height: 120px; cursor: pointer;">
      <img
          id="profile-picture-preview"
          src="{{ $personalInfo?->profile_picture ? Storage::url($personalInfo->profile_picture) : 'https://via.placeholder.com/180' }}"
          alt="Profile Picture"
          style="width: 100%; height: 100%; object-fit: cover; border-radius: 50%; border: 4px solid white;">

      <!-- Upload Icon Overlay -->
      <div style="
        position: absolute;
        bottom: 5px;
        right: 5px;
        background-color: rgba(0,0,0,0.6);
        color: white;
        width: 32px;
        height: 32px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 18px;
        pointer-events: none;
      ">
        &#9998;
      </div>
    </label>

    <!-- Full Name inside cover -->
    <div style="
      position: absolute;
      left: 180px;  /* position to the right of the profile picture */
      bottom: 10px;
      color: white;
      font-weight: 600;
      font-size: 1.25rem;
      text-shadow: 0 0 5px rgba(0,0,0,0.7);
      ">
      {{ $personalInfo?->full_name ?? 'Your Name Here' }}
    </div>

    <!-- Hidden file input -->
    <input type="file" id="profile_picture" name="profile_picture" class="d-none" accept="image/*" />
  </div>
</div>

<div class="card-section">
  <p class="section-heading mb-1">Personal Information</p>
  <p class="text-muted mb-0">Please fill in your personal information below.</p>
</div>

<!-- Wrap these fields inside a flex container -->
<div class="card shadow-sm mb-4">
  
  <ul class="nav nav-tabs" role="tablist">
  <li class="nav-item" role="presentation">
    <button class="nav-link active" id="basic-tab" data-bs-toggle="tab" data-bs-target="#basic" type="button" role="tab" aria-controls="basic" aria-selected="true">
      <i class="bi bi-person-fill me-1"></i> Basic Info
    </button>
  </li>
  <li class="nav-item" role="presentation">
    <button class="nav-link" id="contact-tab" data-bs-toggle="tab" data-bs-target="#contact" type="button" role="tab" aria-controls="contact" aria-selected="false">
      <i class="bi bi-telephone-fill me-1"></i> Contact
    </button>
  </li>
  <li class="nav-item" role="presentation">
    <button class="nav-link" id="details-tab" data-bs-toggle="tab" data-bs-target="#details" type="button" role="tab" aria-controls="details" aria-selected="false">
      <i class="bi bi-file-person-fill me-1"></i> Personal Details
    </button>
  </li>
  <li class="nav-item" role="presentation">
    <button class="nav-link" id="kinid-tab" data-bs-toggle="tab" data-bs-target="#kinid" type="button" role="tab" aria-controls="kinid" aria-selected="false">
      <i class="bi bi-card-checklist me-1"></i> Emergency Contact & ID 
    </button>
  </li>
</ul>


  <div class="card-body tab-content" id="infoTabsContent">
    <form action="#" method="POST" enctype="multipart/form-data">
      @csrf

      <!-- Basic Info -->
      <div class="tab-pane fade show active" id="basic" role="tabpanel">
        <div class="row g-3 mb-3">
          <div class="col-md-4">
            <label for="full_name" class="form-label">Full Name</label>
            <input type="text" name="full_name" class="form-control" value="{{ old('full_name', $personalInfo?->full_name) }}" required>
          </div>
          <div class="col-md-4">
            <label for="title" class="form-label">Title</label>
            <input type="text" name="title" class="form-control" value="{{ old('title', $personalInfo?->title) }}">
          </div>
          <div class="col-md-4">
            <label for="previous_surnames" class="form-label">Previous Surname</label>
            <input type="text" name="previous_surnames" class="form-control" value="{{ old('previous_surnames', $personalInfo?->previous_surnames) }}">
          </div>
        </div>
      </div>

      <!-- Contact Info -->
      <div class="tab-pane fade" id="contact" role="tabpanel">
        <div class="row g-3 mb-3">
          <div class="col-md-4">
            <label for="email" class="form-label">Email</label>
            <input type="email" name="email" class="form-control" value="{{ old('email', $personalInfo?->email) }}">
          </div>
          <div class="col-md-4">
            <label for="contact_address" class="form-label">Contact Address</label>
            <input type="text" name="contact_address" class="form-control" value="{{ old('contact_address', $personalInfo?->contact_address) }}">
          </div>
          <div class="col-md-4">
            <label for="physical_address" class="form-label">Physical Address</label>
            <input type="text" name="physical_address" class="form-control" value="{{ old('physical_address', $personalInfo?->physical_address) }}">
          </div>
        </div>
      </div>

      <!-- Personal Details -->
      <div class="tab-pane fade" id="details" role="tabpanel">
        <div class="row g-3 mb-3">
          <div class="col-md-4">
            <label for="gender" class="form-label">Gender</label>
            <select name="gender" class="form-select">
              <option value="">Select</option>
              <option value="Male" {{ old('gender', $personalInfo?->gender) === 'Male' ? 'selected' : '' }}>Male</option>
              <option value="Female" {{ old('gender', $personalInfo?->gender) === 'Female' ? 'selected' : '' }}>Female</option>
              <option value="Other" {{ old('gender', $personalInfo?->gender) === 'Other' ? 'selected' : '' }}>Other</option>
            </select>
          </div>
          <div class="col-md-4">
            <label for="date_of_birth" class="form-label">Date of Birth</label>
            <input type="date" name="date_of_birth" class="form-control" value="{{ old('date_of_birth', $personalInfo?->date_of_birth) }}">
          </div>
          <div class="col-md-4">
            <label for="country" class="form-label">Country</label>
            <input type="text" name="country" class="form-control" value="{{ old('country', $personalInfo?->country) }}">
          </div>
        </div>
      </div>

      <!-- Kin & ID -->
<div class="tab-pane fade" id="kinid" role="tabpanel" aria-labelledby="kinid-tab">        <div class="row g-3 mb-3">
          <div class="col-md-4">
            <label for="next_of_kin" class="form-label">Family & ID Info</label>
            <input type="text" name="next_of_kin" class="form-control" value="{{ old('next_of_kin', $personalInfo?->next_of_kin) }}">
          </div>
          <div class="col-md-4">
            <label for="kin_contact" class="form-label">Next of Kin Phone</label>
            <input type="text" name="kin_contact" class="form-control" value="{{ old('kin_contact', $personalInfo?->kin_contact) }}">
          </div>
          <div class="col-md-4">
            <label for="national_id_number" class="form-label">National ID Number</label>
            <input type="text" name="national_id_number" class="form-control" value="{{ old('national_id_number', $personalInfo?->national_id_number) }}">
          </div>
        </div>

        <div class="mb-3">
          <label for="personal_statement" class="form-label">Purpose Of Application</label>
          <textarea name="personal_statement" class="form-control" rows="4">{{ old('personal_statement', $personalInfo?->personal_statement) }}</textarea>
        </div>

        <div class="mb-4">
          <label class="form-label">Upload National ID</label>
          <label for="national_id" class="d-block" style="cursor: pointer;">
            <div id="national_id_display" class="border rounded p-3 text-center">
              @php
                $nationalIdPath = $personalInfo?->national_id_path ? Storage::url($personalInfo->national_id_path) : null;
                $isImage = $nationalIdPath && preg_match('/\.(jpg|jpeg|png)$/i', $nationalIdPath);
              @endphp

              @if($nationalIdPath && $isImage)
                <img src="{{ $nationalIdPath }}" id="national_id_preview" alt="National ID" class="img-fluid" style="max-height: 100px;">
              @elseif($nationalIdPath)
                <i class="bi bi-file-earmark-pdf fs-1 text-muted"></i>
                <div>PDF Uploaded</div>
              @else
                <div class="text-muted">Click to upload National ID</div>
              @endif
            </div>
          </label>
          <input type="file" name="national_id" id="national_id" class="form-control d-none" accept=".jpg,.jpeg,.png,.pdf">
        </div>
      </div>

     <div class="text-end mt-4">
  <button type="submit" class="btn custom-btn-purple">
    {{ isset($personalInfo) ? 'Update Information' : 'Save Information' }}
  </button>
</div>

      </div>
    </form>
  </div>
</div>
</body>

<style>
  .custom-btn-purple {
  background-color: #52074f;
  color: #fff;
  border: none;
}

.custom-btn-purple:hover {
  background-color: #3e063c;
  color: #fff;
}

  .tab-pane {
  background-color: white;
  padding: 1.5rem; /* optional: add some padding */
  border-radius: 0.375rem;
  box-shadow: 0 0 10px rgba(0,0,0,0.05); /* subtle shadow */
}
.card-body.tab-content {
  background-color: white !important;
  padding: 2rem;
  border-radius: 0.5rem;
}
input.form-control,
select.form-select,
textarea.form-control {
  border: 1.5px solid #ced4da; /* soft gray border */
  background-color: #f9fafb; /* very light gray fill */
  transition: border-color 0.3s ease, box-shadow 0.3s ease;
  border-radius: 0.375rem;
}

input.form-control:focus,
select.form-select:focus,
textarea.form-control:focus {
  border-color: #52074f; /* your deep plum color */
  box-shadow: 0 0 5px rgba(82, 7, 79, 0.5);
  background-color: white;
  outline: none;
}


.section-heading {
  font-size: 1.5rem;
  font-weight: 700;
  color: #222;
  margin-bottom: 0.25rem;
  letter-spacing: 0.05em;
}

.text-muted {
  font-size: 1rem;
  color: #6c757d; /* Bootstrap muted gray */
  margin-top: 0;
}
.card-section {
  background: #fff;
  padding: 16px 24px;
  border-radius: 8px;
  box-shadow: 0 3px 6px rgba(0,0,0,0.1);
  margin-bottom: 1.5rem;
}


 


 
   /* Change the background behind the tab links */
.card-header, /* or your container selector */
.nav-tabs {
  background-color: #52074f !important;
  border-bottom: none; /* optional: remove bottom border if you want */
  padding-left: 1rem;
  padding-right: 1rem;
  border-radius: 0.375rem 0.375rem 0 0;
}

/* Optional: make tab links transparent so background shows */
.nav-tabs .nav-link {
  background-color: transparent !important;
  color: white !important;
  border: none !important;
}

.nav-tabs .nav-link.active {
  background-color: rgba(255,255,255,0.15) !important; /* slight highlight */
  color: white !important;
  border: none !important;
}




/* Upload Box */
.id-upload-box {
  display: flex;
  align-items: center;
  justify-content: center;
  border: 2px dashed #ccc;
  border-radius: 10px;
  padding: 20px;
  cursor: pointer;
  transition: border-color 0.3s, background-color 0.3s;
  text-align: center;
  min-height: 180px;
}

.id-upload-box:hover {
  border-color: #52074f;
  background-color: #f9f0f8;
}

/* Upload preview */
.preview-img {
  max-width: 100%;
  max-height: 160px;
  object-fit: contain;
  border-radius: 8px;
}




/* Responsive tweaks */
@media (max-width: 600px) {
  .form-row {
    flex-direction: column;
  }
}

</style>



<script>
    $('.main-panel').on('submit', '#personal-info-form', function(e) {
        e.preventDefault();

        let formData = new FormData(this);

        $.ajax({
            url: $(this).attr('action'),
            method: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function(response) {
                // Reload the form and inject the success message
                $.ajax({
                    url: '/personal-info',
                    method: 'GET',
                    success: function (formHtml) {
                        $('.main-panel').html(formHtml);

                        // Inject success message after the form loads
                        $('#success-message-area').html(`
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                ${response.message}
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        `);
                    }
                });
            },
            error: function(xhr) {
                $('.text-danger').remove();

                if (xhr.status === 422) {
                    let errors = xhr.responseJSON.errors;
                    $.each(errors, function(field, messages) {
                        let input = $('[name="' + field + '"]');
                        if (input.length) {
                            input.after('<div class="text-danger">' + messages[0] + '</div>');
                        }
                    });
                } else {
                    console.error(xhr.responseText);
                }
            }
        });
    });
</script>
<script>
  document.getElementById('profile_picture').addEventListener('change', function (event) {
    const preview = document.getElementById('profile-picture-preview');
    const file = event.target.files[0];
    if (file) {
      const reader = new FileReader();
      reader.onload = function (e) {
        preview.src = e.target.result;
      };
      reader.readAsDataURL(file);
    }
  });
</script>

<script>
document.getElementById('national_id').addEventListener('change', function (event) {
    const file = event.target.files[0];
    const displayBox = document.getElementById('national_id_display');

    if (!file) return;

    const extension = file.name.split('.').pop().toLowerCase();

    if (['jpg', 'jpeg', 'png'].includes(extension)) {
        const reader = new FileReader();
        reader.onload = function (e) {
            displayBox.innerHTML = `<img src="${e.target.result}" class="preview-img" alt="National ID">`;
        };
        reader.readAsDataURL(file);
    } else if (extension === 'pdf') {
        displayBox.innerHTML = `
            <div class="pdf-placeholder">
                <i class="bi bi-file-earmark-pdf"></i>
                <span>${file.name}</span>
            </div>
        `;
    } else {
        displayBox.innerHTML = `<div class="placeholder-text text-danger">Unsupported file type</div>`;
    }
});
</script>


