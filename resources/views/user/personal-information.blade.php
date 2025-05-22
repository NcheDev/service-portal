

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
<div class="card p-4 mb-4 shadow-sm">
  <form action="#" method="POST" novalidate>
    <div class="row g-3">
      <!-- Full Name -->
      <div class="col-md-3">
        <label for="full_name" class="form-label">Full Name</label>
        <input type="text" name="full_name" id="full_name" class="form-control" value="{{ old('full_name', $personalInfo?->full_name) }}" required>
      </div>

      <!-- Email -->
      <div class="col-md-3">
        <label for="email" class="form-label">Email Address</label>
        <input type="email" name="email" id="email" class="form-control" value="{{ old('email', $personalInfo?->email) }}" required>
      </div>

      <!-- Physical Address -->
      <div class="col-md-3">
        <label for="physical_address" class="form-label">Physical Address</label>
        <input type="text" name="physical_address" id="physical_address" class="form-control" value="{{ old('physical_address', $personalInfo?->physical_address) }}" required>
      </div>

      <!-- Contact Address -->
      <div class="col-md-3">
        <label for="contact_address" class="form-label">Contact Address</label>
        <input type="text" name="contact_address" id="contact_address" class="form-control" value="{{ old('contact_address', $personalInfo?->contact_address) }}" required>
      </div>

      <!-- Gender -->
      <div class="col-md-3">
        <label for="gender" class="form-label">Gender</label>
        <select name="gender" id="gender" class="form-select" required>
          <option value="">Select</option>
          <option value="Male" {{ old('gender', $personalInfo?->gender) === 'Male' ? 'selected' : '' }}>Male</option>
          <option value="Female" {{ old('gender', $personalInfo?->gender) === 'Female' ? 'selected' : '' }}>Female</option>
          <option value="Other" {{ old('gender', $personalInfo?->gender) === 'Other' ? 'selected' : '' }}>Other</option>
        </select>
      </div>
    </div>

  
    <div class="row ">
  <!-- Purpose Of Application -->
  <div class="col-12 col-md-3 mt-3">
    <label for="personal_statement" class="form-label">Purpose Of Application</label>
    <textarea name="personal_statement" id="personal_statement" class="form-control" style="height: 150px;" required>
      {{ old('personal_statement', $personalInfo?->personal_statement) }}
    </textarea>
  </div>
  

  <!-- National ID Upload -->
  <div class="col-12 col-md-3 mt-3">
    <label for="national_id" class="form-label">Upload National ID </label>
    <label for="national_id" class="d-block" style="cursor: pointer;">
      <div id="national_id_display" class="border rounded p-3 text-center" style="min-height: 150px;">
        @php
              $nationalIdPath = $personalInfo?->national_id_path ? Storage::url($personalInfo->national_id_path) : null;
              $isImage = $nationalIdPath && preg_match('/\.(jpg|jpeg|png)$/i', $nationalIdPath);
          @endphp

          @if($nationalIdPath && $isImage)
              <img src="{{ $nationalIdPath }}" id="national_id_preview" alt="National ID" class="img-fluid" style="max-height: 100px;">
          @elseif($nationalIdPath)
              <div class="pdf-placeholder text-muted">
                <i class="bi bi-file-earmark-pdf fs-1"></i>
                <div>PDF Uploaded</div>
              </div>
          @else
              <div class="placeholder-text text-muted">Click to upload National ID</div>
          @endif
        </div>
      </label>

      <!-- File Input -->
      <input type="file" name="national_id" id="national_id" accept=".jpg,.jpeg,.png,.pdf" class="form-control d-none">
    </div>
    </div>
    <h4 id="success-message-area" class="mt-3"></h4></div>

    <!-- Submit Button -->
    <div class="mt-4 text-end">
      <button type="submit" class="btn btn-primary">
        {{ isset($personalInfo) ? 'Update Information' : 'Save Information' }}
      </button>
    </div>
  </form>
</div>

<style>
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


/* Makes the profile image look embedded into the cover */










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


