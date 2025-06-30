<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

<div class="container py-4">
    <h2 class="mb-4 text-center">Qualification Evaluation Application</h2>

    <form action="{{ route('application.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        {{-- Card: Processing Type & Nationality --}}
        <div class="card mb-4 shadow-sm">
    <div class="card-header bg-white">
        <h5 class="mb-0">Applicant Info</h5>
    </div>
    <div class="card-body row">
        {{-- Processing Type --}}
        <div class="col-md-6 mb-3">
            <label for="processing_type" class="form-label">Processing Type</label>
            <select class="form-control" name="processing_type" id="processing_type" required>
                <option value="normal">Normal</option>
                <option value="express">Express</option>
            </select>
            <div class="mt-2 text-info small" id="processing_info">Normal takes 21 days.</div>
        </div>

        {{-- Nationality --}}
        <div class="col-md-6 mb-3">
            <label for="nationality" class="form-label">Nationality</label>
            <select class="form-control" name="nationality" id="nationality" required>
                <option value="local">Local</option>
                <option value="foreigner">Foreigner</option>
            </select>
            <div class="mt-2 text-info small" id="fee_info">Locals: MK 75,000 per qualification</div>
        </div>
    </div>
</div>

        {{-- Card: Qualification to be Evaluated --}}
        <div class="card mb-4 shadow-sm">
            <div class="card-header bg-white">
                <h5 class="mb-0">Qualification/Award to be Evaluated</h5>
            </div>
           <div class="card-body">
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Qualification Name</th>
                <th>Program Name</th> {{-- ✅ Added this --}}
                <th>Date Obtained</th>
                <th>Institution</th>
                <th>Country</th>
            </tr>
        </thead>
        <tbody>
           <tr>
    {{-- Qualification Name --}}
    <td>
        <input 
            type="text" 
            name="qualifications[0][name]" 
            class="form-control" 
            placeholder="Qualification name" 
            value="{{ old('qualifications.0.name') }}"
        >
        <small class="text-muted">As it appears on certificate.</small>
        @error('qualifications.0.name') <div class="text-danger small">{{ $message }}</div> @enderror
    </td>

    {{-- Program Name --}}
    <td>
        <input 
            type="text" 
            name="qualifications[0][program_name]" 
            class="form-control" 
            placeholder="e.g., Computer Science" 
            value="{{ old('qualifications.0.program_name') }}"
        >
        <small class="text-muted">As it appears on certificate.</small>
        @error('qualifications.0.program_name') <div class="text-danger small">{{ $message }}</div> @enderror
    </td>

    {{-- Date Awarded --}}
    <td>
        <input 
            type="text" 
            name="qualifications[0][year]" 
            class="form-control" 
            placeholder="e.g., 12 July 2020" 
            value="{{ old('qualifications.0.year') }}"
        >
        <small class="text-muted">As it appears on certificate.</small>
        @error('qualifications.0.year') <div class="text-danger small">{{ $message }}</div> @enderror
    </td>

    {{-- Institution --}}
    <td>
        <input 
            type="text" 
            name="qualifications[0][institution]" 
            class="form-control" 
            placeholder="Institution name" 
            value="{{ old('qualifications.0.institution') }}"
        >
        <small class="text-muted">As it appears on certificate.</small>
        @error('qualifications.0.institution') <div class="text-danger small">{{ $message }}</div> @enderror
    </td>

    {{-- Country --}}
    <td>
        <input 
            type="text" 
            name="qualifications[0][country]" 
            class="form-control" 
            placeholder="Country" 
            value="{{ old('qualifications.0.country') }}"
        >
        <small class="text-muted">As it appears on certificate.</small>
        @error('qualifications.0.country') <div class="text-danger small">{{ $message }}</div> @enderror
    </td>
</tr>

        </tbody>
    </table>
</div>

        </div>

        {{-- Card: Education History --}}
        <div class="card mb-4 shadow-sm">
            <div class="card-header bg-white">
                <h5 class="mb-0">History of Educational Institutions Attended</h5>
            </div>
            <div class="card-body">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Qualification Name</th>
                            <th>Year Obtained</th>
                            <th>Institution</th>
                            <th>Country</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody id="education-history-body">
                        @php $educationHistories = old('education_histories', [[]]); @endphp
                        @foreach ($educationHistories as $index => $history)
                            <tr>
                                <td>
                                    <input type="text" name="education_histories[{{ $index }}][name]" class="form-control"
                                        value="{{ $history['name'] ?? '' }}">
                                    @error("education_histories.$index.name") <div class="text-danger small">{{ $message }}</div> @enderror
                                </td>
                                <td>
                                    <input type="text" name="education_histories[{{ $index }}][year]" class="form-control"
                                        value="{{ $history['year'] ?? '' }}">
                                    @error("education_histories.$index.year") <div class="text-danger small">{{ $message }}</div> @enderror
                                </td>
                                <td>
                                    <input type="text" name="education_histories[{{ $index }}][institution]" class="form-control"
                                        value="{{ $history['institution'] ?? '' }}">
                                    @error("education_histories.$index.institution") <div class="text-danger small">{{ $message }}</div> @enderror
                                </td>
                                <td>
                                    <input type="text" name="education_histories[{{ $index }}][country]" class="form-control"
                                        value="{{ $history['country'] ?? '' }}">
                                    @error("education_histories.$index.country") <div class="text-danger small">{{ $message }}</div> @enderror
                                </td>
                                <td>
                                    <button type="button" class="btn btn-danger btn-sm" onclick="removeRow(this)">Remove</button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <button type="button" class="btn btn-outline-primary" onclick="addEducationRow()">+ Add More</button>
            </div>
        </div>

        {{-- Card: Document Uploads --}}
        <div class="card mb-4 shadow-sm">
            <div class="card-header bg-white">
                <h5 class="mb-0">Document Uploads</h5>
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <label>Upload Qualification Certificates (certified copy)</label>
                    <input type="file" name="certificates[]" class="form-control" multiple required>
                </div>
                <div class="mb-3">
                    <label>Upload Academic Records (transcripts)</label>
                    <input type="file" name="academic_records[]" class="form-control" multiple required>
                </div>
                <div class="mb-3">
                    <label>Upload Previous NCHE Evaluations</label>
                    <input type="file" name="previous_evaluations[]" class="form-control" multiple>
                </div>
                <div class="mb-3">
                    <label>Upload Syllabus / Course Prescriptions</label>
                    <input type="file" name="syllabi[]" class="form-control" multiple>
                </div>
            </div>
        </div>
        <!-- Consent Form Section -->
<div class="card mb-4">
    <div class="card-header bg-primary text-white">
        <strong>Consent Form</strong>
    </div>
    <div class="card-body">
        <p class="mb-4">Please download the consent form, sign it, and upload the signed version below.</p>

        <div class="row mb-3">
            <div class="col-auto">
                <!-- Download Button -->
                <a href="{{ asset('assets/forms/consent_form.pdf') }}" download class="btn btn-outline-primary">
                    <i class="bi bi-download"></i> Download Consent Form
                </a>
            </div>
        </div>

        <!-- Upload Form -->
        {{-- Consent Form Upload --}}
    <div class="card mb-4 shadow-sm">
        <div class="card-header bg-white">
            <h5 class="mb-0">Upload Signed Consent Form</h5>
        </div>
        <div class="card-body">
            <div class="row g-3 align-items-center">
                <div class="col-md-6">
                    <label for="consent_form" class="form-label">Consent Form (PDF)</label>
                    <input type="file" name="consent_form" id="consent_form" class="form-control" accept="application/pdf" required>
                </div>
            </div>
        </div>
    </div>
    </div>
</div>


        {{-- Card: Notices --}}
        <div class="alert alert-info">
            <strong>Note:</strong>
            <ul class="mb-0">
                <li>Submit certified copies and transcripts as required.</li>
                <li>Forged documents lead to disqualification.</li>
                <li>NCHE may share this info with other institutions.</li>
                <li>Normal: <strong>21 working days</strong>, Express: <strong>10 working days</strong></li>
            </ul>
        </div>

        {{-- Submit --}}
        <div class="text-center mt-4">
            <button type="submit" class="btn btn-primary px-4 py-2">Submit Application</button>
        </div>
    </form>
</div>

 

<script>
    let eduIndex = 1;

    function addEducationRow() {
        const tbody = document.getElementById('education-history-body');
        const row = document.createElement('tr');

        row.innerHTML = `
            <td><input type="text" name="education_histories[${eduIndex}][name]" class="form-control" placeholder="Qualification Name"></td>
            <td><input type="text" name="education_histories[${eduIndex}][year]" class="form-control" placeholder="Year Obtained"></td>
            <td><input type="text" name="education_histories[${eduIndex}][institution]" class="form-control" placeholder="Institution"></td>
            <td><input type="text" name="education_histories[${eduIndex}][country]" class="form-control" placeholder="Country"></td>
            <td><button type="button" class="btn btn-danger btn-sm" onclick="removeRow(this)">Remove</button></td>
        `;

        tbody.appendChild(row);
        eduIndex++;
    }

    function removeRow(button) {
        button.closest('tr').remove();
    }
</script>
 
<script>
    document.addEventListener('DOMContentLoaded', function () {
        document.querySelectorAll('.qualification-select').forEach(function(select) {
            select.addEventListener('change', function () {
                const wrapper = this.closest('td').querySelector('.other-qualification-wrapper');

                if (this.value === 'Other') {
                    wrapper.classList.remove('d-none');
                } else {
                    wrapper.classList.add('d-none');
                    wrapper.querySelector('input').value = '';
                }
            });
        });
    });
</script>
 
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const processingSelect = document.getElementById('processing_type');
        const nationalitySelect = document.getElementById('nationality');
        const processingInfo = document.getElementById('processing_info');
        const feeInfo = document.getElementById('fee_info');

        function updateProcessingInfo() {
            const type = processingSelect.value;

            if (type === 'normal') {
                processingInfo.textContent = "Normal takes 21 days.";
            } else if (type === 'express') {
                processingInfo.textContent = "Express takes 10 days.";
            }
        }

        function updateFeeInfo() {
            const type = processingSelect.value;
            const nationality = nationalitySelect.value;

            if (type === 'normal' && nationality === 'local') {
                feeInfo.textContent = "Locals: MK 75,000 per qualification";
            } else if (type === 'normal' && nationality === 'foreigner') {
                feeInfo.textContent = "Foreigners: US$ 150 per qualification";
            } else if (type === 'express' && nationality === 'local') {
                feeInfo.textContent = "Locals: MK 112,500 per qualification";
            } else if (type === 'express' && nationality === 'foreigner') {
                feeInfo.textContent = "Foreigners: US$ 225 per qualification";
            }
        }

        // Initial load
        updateProcessingInfo();
        updateFeeInfo();

        // On change
        processingSelect.addEventListener('change', function () {
            updateProcessingInfo();
            updateFeeInfo();
        });

        nationalitySelect.addEventListener('change', function () {
            updateFeeInfo();
        });
    });
</script><script>
$(document).on('submit', '#applicationForm', function(e) {
    e.preventDefault();
    var formData = new FormData(this);
    
    $.ajax({
        url: $(this).attr('action'),
        method: $(this).attr('method'),
        data: formData,
        contentType: false,
        processData: false,
        success: function(response) {
            // Replace main panel content with invoice partial
            $('.main-panel').html(response);
        },
        error: function(xhr) {
            alert('Error submitting application');
            console.error(xhr.responseText);
        }
    });
});
</script>
 
