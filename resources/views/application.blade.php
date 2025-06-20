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
                <div class="col-md-6 mb-3">
                    <label for="processing_type" class="form-label">Processing Type</label>
                    <select class="form-control" name="processing_type" required>
                        <option value="normal">Normal</option>
                        <option value="express">Express</option>
                    </select>
                </div>
                <div class="col-md-6 mb-3">
                    <label for="nationality" class="form-label">Nationality</label>
                    <select class="form-control" name="nationality" required>
                        <option value="local">Local</option>
                        <option value="foreigner">Foreigner</option>
                    </select>
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
                            <th>Year Obtained</th>
                            <th>Institution</th>
                            <th>Country</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>
                                <input type="text" name="qualifications[0][name]" class="form-control" value="{{ old('qualifications.0.name') }}">
                                @error('qualifications.0.name') <div class="text-danger small">{{ $message }}</div> @enderror
                            </td>
                            <td>
                                <input type="text" name="qualifications[0][year]" class="form-control" value="{{ old('qualifications.0.year') }}">
                                @error('qualifications.0.year') <div class="text-danger small">{{ $message }}</div> @enderror
                            </td>
                            <td>
                                <input type="text" name="qualifications[0][institution]" class="form-control" value="{{ old('qualifications.0.institution') }}">
                                @error('qualifications.0.institution') <div class="text-danger small">{{ $message }}</div> @enderror
                            </td>
                            <td>
                                <input type="text" name="qualifications[0][country]" class="form-control" value="{{ old('qualifications.0.country') }}">
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

{{-- JavaScript for add/remove rows --}}
<script>
    function addEducationRow() {
        const index = document.querySelectorAll('#education-history-body tr').length;
        const row = `
            <tr>
                <td><input type="text" name="education_histories[${index}][name]" class="form-control"></td>
                <td><input type="text" name="education_histories[${index}][year]" class="form-control"></td>
                <td><input type="text" name="education_histories[${index}][institution]" class="form-control"></td>
                <td><input type="text" name="education_histories[${index}][country]" class="form-control"></td>
                <td><button type="button" class="btn btn-danger btn-sm" onclick="removeRow(this)">Remove</button></td>
            </tr>
        `;
        document.getElementById('education-history-body').insertAdjacentHTML('beforeend', row);
    }

    function removeRow(button) {
        button.closest('tr').remove();
    }
</script>

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
<style>
    @import url('application-form.css');
/* application-form.css */

/* General Layout */
body {
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    background-color: #f9f9f9;
    color: #333;
    padding: 20px;
}

/* Card Container */
.card {
    border: none;
    box-shadow: 0 0 15px rgba(0,0,0,0.05);
    border-radius: 10px;
    margin-bottom: 20px;
}

/* Card Header */
.card-header {
    background-color: #ffffff;
    border-bottom: 1px solid #dee2e6;
    font-weight: 600;
    font-size: 16px;
    padding: 10px 15px;
}

/* Card Body */
.card-body {
    padding: 15px;
}

/* Input Fields */
.form-control,
.form-select {
    border-radius: 5px;
    font-size: 14px;
    padding: 6px 10px;
    margin-bottom: 10px;
}

/* Labels */
.form-label {
    font-weight: 500;
    font-size: 13px;
    margin-bottom: 2px;
}

/* Tabs Styling */
.nav-tabs .nav-link {
    font-weight: 500;
    font-size: 14px;
    color: #555;
}

.nav-tabs .nav-link.active {
    background-color: #ffffff;
    border-color: #dee2e6 #dee2e6 #fff;
    color: #000;
}

/* Section Headings */
.section-title {
    font-size: 15px;
    font-weight: 600;
    margin-top: 15px;
    margin-bottom: 10px;
    border-bottom: 1px solid #ddd;
    padding-bottom: 5px;
}

/* Buttons */
.btn {
    font-size: 14px;
    padding: 6px 12px;
    border-radius: 5px;
}

.btn-primary {
    background-color: #007bff;
    border-color: #007bff;
}

/* Remove extra spacing */
.row {
    margin-bottom: 10px;
}

/* Reduce overall space to keep one-page fit */
.container {
    max-width: 960px;
}

/* Table section for educational background */
.table td,
.table th {
    padding: 6px;
    font-size: 13px;
    vertical-align: middle;
}

/* Make sure it fits in one page on most screens */
html, body {
    overflow-y: auto;
    max-height: 100vh;
}

/* Hide unused large spacing on smaller viewports */
@media (max-width: 768px) {
    .card-body, .card-header {
        padding: 10px;
    }

    .form-label, .form-control, .form-select {
        font-size: 13px;
    }
}

</style>