<!-- Success Message Area -->


<div class="container py-4">
    <h2 class="mb-4 section-heading" id="personal">Personal Information</h2>


    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <form id="personal-info-form" action="{{ route('personal.storeOrUpdate') }}" method="POST" enctype="multipart/form-data">
        @csrf
        @if(isset($personalInfo))
            @method('PUT')
        @endif

        

        <!-- Cover Photo -->
<div class="mb-4">
    <div class="d-block mb-2" 
         style="height: 200px; overflow: hidden; border-radius: 8px; position: relative; border: 1px solid #ccc;">
        <img src="{{ asset('assets/images/cover.jpg') }}" alt="Cover Photo"
             class="w-100 h-100" style="object-fit: cover; display: block;">
    </div>
</div>


<!-- Profile Picture -->
<div class="mb-4 text-center position-relative" style="margin-top: -90px;">
    <label for="profile_picture" class="mx-auto d-block" style="width: 180px; height: 180px; position: relative; cursor: pointer;">
        <img
            id="profile-picture-preview"
            src="{{ $personalInfo?->profile_picture ? Storage::url($personalInfo->profile_picture) : 'https://via.placeholder.com/180' }}"
            alt="Profile Picture"
            class="rounded-circle border border-white shadow"
            style="width: 180px; height: 180px; object-fit: cover;"
        >
        <div style="position: absolute; bottom: 10px; right: 10px; background: rgba(0,0,0,0.5); color: white; padding: 6px 10px; border-radius: 50%; font-size: 18px;">
            &#9998;
        </div>
    </label>
    <input type="file" id="profile_picture" name="profile_picture" class="form-control d-none" accept="image/*">
</div>


     <!-- Wrap these fields inside a flex container -->
<div class="form-container">
  <form action="#" method="POST" novalidate>
    <div class="form-row">
      <!-- Full Name -->
      <div class="form-group">
        <label for="full_name" class="form-label">Full Name</label>
        <input type="text" name="full_name" id="full_name" class="form-control" value="{{ old('full_name', $personalInfo?->full_name) }}" required>
      </div>

      <!-- Email -->
      <div class="form-group">
        <label for="email" class="form-label">Email Address</label>
        <input type="email" name="email" id="email" class="form-control" value="{{ old('email', $personalInfo?->email) }}" required>
      </div>

      <!-- Physical Address -->
      <div class="form-group">
        <label for="physical_address" class="form-label">Physical Address</label>
        <input type="text" name="physical_address" id="physical_address" class="form-control" value="{{ old('physical_address', $personalInfo?->physical_address) }}" required>
      </div>

      <!-- Contact Address -->
      <div class="form-group">
        <label for="contact_address" class="form-label">Contact Address</label>
        <input type="text" name="contact_address" id="contact_address" class="form-control" value="{{ old('contact_address', $personalInfo?->contact_address) }}" required>
      </div>

      <!-- Gender -->
      <div class="form-group">
        <label for="gender" class="form-label">Gender</label>
        <select name="gender" id="gender" class="form-select" required>
          <option value="">Select</option>
          <option value="Male" {{ old('gender', $personalInfo?->gender) === 'Male' ? 'selected' : '' }}>Male</option>
          <option value="Female" {{ old('gender', $personalInfo?->gender) === 'Female' ? 'selected' : '' }}>Female</option>
          <option value="Other" {{ old('gender', $personalInfo?->gender) === 'Other' ? 'selected' : '' }}>Other</option>
        </select>
      </div>
    </div>

    <!-- Personal Statement -->
    <div class="form-group personal-statement-group">
      <label for="personal_statement" class="form-label">Purpose Of Application</label>
      <textarea name="personal_statement" id="personal_statement" rows="5" class="form-control personal-statement" required>{{ old('personal_statement', $personalInfo?->personal_statement) }}</textarea>
    </div>
    <!-- National ID Upload -->
<!-- National ID Upload -->
<div class="form-group national-id-upload">
    <label for="national_id" class="form-label">Upload National ID (JPG, PNG, PDF)</label>

    <!-- Preview Box -->
    <label for="national_id" class="id-upload-box">
        <div id="national_id_display">
            @php
                $nationalIdPath = $personalInfo?->national_id_path ? Storage::url($personalInfo->national_id_path) : null;
                $isImage = $nationalIdPath && preg_match('/\.(jpg|jpeg|png)$/i', $nationalIdPath);
            @endphp

            @if($nationalIdPath && $isImage)
                <img src="{{ $nationalIdPath }}" id="national_id_preview" alt="National ID" class="preview-img">
            @elseif($nationalIdPath)
                <div class="pdf-placeholder" id="pdf_display_box">
                    <i class="bi bi-file-earmark-pdf"></i>
                    <span>PDF Uploaded</span>
                </div>
            @else
                <div class="placeholder-text" id="upload_placeholder">Click to upload National ID</div>
            @endif
        </div>
    </label>

    <!-- File Input -->
    <input type="file" name="national_id" id="national_id" accept=".jpg,.jpeg,.png,.pdf" class="form-control d-none">
</div>


<h4 id="success-message-area"></h4>
    <!-- Submit Button -->
    <div class="form-submit-container">
      <button type="submit" class="btn-submit">
        {{ isset($personalInfo) ? 'Update Information' : 'Save Information' }}
      </button>
    </div>
  
  </form>
</div>

<style>
 .section-heading {
  font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
  font-size: 1.8rem;
  font-weight: 600;
  color: #ffffff;
  background-color: #52074f;
  padding: 12px 20px;
  border-left: 6px solid #dd8027;
  border-radius: 8px;
  margin-top: 0px;
  box-shadow: 0 2px 6px rgba(0, 0, 0, 0.1);
  width: 500px;
}


/* Container and row */
.form-container {
  max-width: 960px;
  margin: 40px auto;
  padding: 0 20px;
  font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
  color: #333;
}

.form-row {
  display: flex;
  flex-wrap: wrap;
  gap: 24px;
  margin-bottom: 30px;
}

/* Form groups */
.form-group {
  flex: 1 1 220px;
  min-width: 220px;
  display: flex;
  flex-direction: column;
}

/* Labels */
.form-label {
  font-weight: 600;
  margin-bottom: 8px;
  font-size: 1.1rem;
  color: #52074f;
  user-select: none;
}

/* Inputs and selects */
.form-control,
.form-select {
  padding: 12px 16px;
  font-size: 1rem;
  border: 1.8px solid #ccc;
  border-radius: 10px;
  box-shadow: inset 0 1px 3px rgba(0, 0, 0, 0.05);
  transition: border 0.3s, box-shadow 0.3s;
}

.form-control:focus,
.form-select:focus {
  border-color: #dd8027;
  outline: none;
  box-shadow: 0 0 0 3px rgba(221, 128, 39, 0.25);
}

/* Submit Button */
.btn-submit {
  background-color: #52074f;
  color: white;
  font-weight: 600;
  border: none;
  padding: 12px 24px;
  font-size: 1rem;
  border-radius: 8px;
  transition: background-color 0.3s;
  cursor: pointer;
}

.btn-submit:hover {
  background-color: #dd8027;
  color: #fff;
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

.pdf-placeholder {
  display: flex;
  flex-direction: column;
  align-items: center;
  justify-content: center;
  color: #52074f;
  font-weight: 600;
}

.pdf-placeholder i {
  font-size: 3rem;
  color: #dd8027;
  margin-bottom: 8px;
}

/* Placeholder text */
.placeholder-text {
  color: #999;
  font-style: italic;
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


