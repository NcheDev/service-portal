@extends('layouts.user-dashboard')
@section('content')
@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show mt-3" role="alert">
        <i class="bi bi-check-circle me-2"></i>
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

<div class="container pt-5 pb-4">

    <h2 class="mb-4 text-center fw-bold" 
        style="color:#52074f; font-family:'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; letter-spacing:1px;">
        Qualification Evaluation Application
    </h2>

    {{-- Success Message --}}
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show mt-3" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <form id="application-form" action="{{ route('application.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        {{-- Card: Processing Type & Nationality --}}
        <div class="card mb-4 border-0 shadow-sm">
            <div class="card-header text-white" style="background-color:#52074f;">
                <h5 class="mb-0">Applicant Information</h5>
            </div>
            <div class="card-body">
                <div class="row g-4">
                    <div class="col-md-6">
                        <label for="processing_type" class="form-label fw-bold">Processing Type</label>
                        <select class="form-select" name="processing_type" id="processing_type" required>
                            <option value="normal" {{ old('processing_type') == 'normal' ? 'selected' : '' }}>Normal</option>
                            <option value="express" {{ old('processing_type') == 'express' ? 'selected' : '' }}>Express</option>
                        </select>
                        <div class="mt-2 text-info small" id="processing_info"></div>
                        @error('processing_type') 
                            <div class="text-danger small">{{ $message }}</div> 
                        @enderror
                    </div>

                    <div class="col-md-6">
                        <label for="nationality" class="form-label fw-bold">Nationality</label>
                        <select class="form-select" name="nationality" id="nationality" required>
                            <option value="local" {{ old('nationality') == 'local' ? 'selected' : '' }}>Local</option>
                            <option value="foreigner" {{ old('nationality') == 'foreigner' ? 'selected' : '' }}>Foreigner</option>
                        </select>
                        <div class="mt-2 text-info small" id="fee_info"></div>
                        @error('nationality') 
                            <div class="text-danger small">{{ $message }}</div> 
                        @enderror
                    </div>
                </div>
            </div>
           
        </div>

        {{-- Card: Qualification to be Evaluated --}}
        <div class="card mb-4 border-0 shadow-sm">
            <div class="card-header text-white" style="background-color:#52074f;">
                <h5 class="mb-0">Qualification / Award to be Evaluated</h5>
            </div>
            <div class="card-body">
                <p class="text-muted mb-4">
                    <em>Please enter details exactly as they appear on your certificate.</em>
                </p>

                @php
                    $qualifications = old('qualifications', [['name'=>'','program_name'=>'','year'=>'','institution'=>'','country'=>'']]);
                @endphp

                @foreach($qualifications as $i => $qual)
                <div class="row g-4 mb-3 border-bottom pb-3">
                    <div class="col-md-6">
                        <label class="form-label fw-bold">Qualification Name</label>
                        <input type="text" name="qualifications[{{ $i }}][name]" class="form-control"
                               value="{{ $qual['name'] }}">
                        @error("qualifications.$i.name") 
                            <div class="text-danger small">{{ $message }}</div> 
                        @enderror
                    </div>

                    <div class="col-md-6">
                        <label class="form-label fw-bold">Program Name</label>
                        <input type="text" name="qualifications[{{ $i }}][program_name]" class="form-control"
                               value="{{ $qual['program_name'] }}">
                        @error("qualifications.$i.program_name") 
                            <div class="text-danger small">{{ $message }}</div> 
                        @enderror
                    </div>

                    <div class="col-md-6">
                        <label class="form-label fw-bold">Year Obtained</label>
                        <input type="number" name="qualifications[{{ $i }}][year]" class="form-control"
       value="{{ $qual['year'] }}" min="1900" max="{{ date('Y') }}" required>

                        @error("qualifications.$i.year") 
                            <div class="text-danger small">{{ $message }}</div> 
                        @enderror
                    </div>

                    <div class="col-md-6">
                        <label class="form-label fw-bold">Institution</label>
                        <input type="text" name="qualifications[{{ $i }}][institution]" class="form-control"
                               value="{{ $qual['institution'] }}">
                        @error("qualifications.$i.institution") 
                            <div class="text-danger small">{{ $message }}</div> 
                        @enderror
                    </div>

                    <div class="col-md-6">
                        <label class="form-label fw-bold">Country</label>
                        <select name="qualifications[{{ $i }}][country]" class="form-select" required>
                            <option value="">-- Select Country --</option>
                            @foreach(['Afghanistan','Albania','Algeria','Andorra','Angola','Antigua and Barbuda','Argentina','Armenia','Australia','Austria','Azerbaijan',
            'Bahamas','Bahrain','Bangladesh','Barbados','Belarus','Belgium','Belize','Benin','Bhutan','Bolivia','Bosnia and Herzegovina','Botswana','Brazil','Brunei','Bulgaria','Burkina Faso','Burundi',
            'Cabo Verde','Cambodia','Cameroon','Canada','Central African Republic','Chad','Chile','China','Colombia','Comoros','Congo (Congo-Brazzaville)','Costa Rica','Croatia','Cuba','Cyprus','Czechia (Czech Republic)',
            'Democratic Republic of the Congo','Denmark','Djibouti','Dominica','Dominican Republic',
            'Ecuador','Egypt','El Salvador','Equatorial Guinea','Eritrea','Estonia','Eswatini','Ethiopia',
            'Fiji','Finland','France',
            'Gabon','Gambia','Georgia','Germany','Ghana','Greece','Grenada','Guatemala','Guinea','Guinea-Bissau','Guyana',
            'Haiti','Honduras','Hungary',
            'Iceland','India','Indonesia','Iran','Iraq','Ireland','Israel','Italy',
            'Jamaica','Japan','Jordan',
            'Kazakhstan','Kenya','Kiribati','Kuwait','Kyrgyzstan',
            'Laos','Latvia','Lebanon','Lesotho','Liberia','Libya','Liechtenstein','Lithuania','Luxembourg',
            'Madagascar','Malawi','Malaysia','Maldives','Mali','Malta','Marshall Islands','Mauritania','Mauritius','Mexico','Micronesia','Moldova','Monaco','Mongolia','Montenegro','Morocco','Mozambique','Myanmar (Burma)',
            'Namibia','Nauru','Nepal','Netherlands','New Zealand','Nicaragua','Niger','Nigeria','North Korea','North Macedonia','Norway',
            'Oman',
            'Pakistan','Palau','Palestine State','Panama','Papua New Guinea','Paraguay','Peru','Philippines','Poland','Portugal',
            'Qatar',
            'Romania','Russia','Rwanda',
            'Saint Kitts and Nevis','Saint Lucia','Saint Vincent and the Grenadines','Samoa','San Marino','Sao Tome and Principe','Saudi Arabia','Senegal','Serbia','Seychelles','Sierra Leone','Singapore','Slovakia','Slovenia','Solomon Islands','Somalia','South Africa','South Korea','South Sudan','Spain','Sri Lanka','Sudan','Suriname','Sweden','Switzerland','Syria',
            'Taiwan','Tajikistan','Tanzania','Thailand','Timor-Leste','Togo','Tonga','Trinidad and Tobago','Tunisia','Turkey','Turkmenistan','Tuvalu',
            'Uganda','Ukraine','United Arab Emirates','United Kingdom','United States of America','Uruguay','Uzbekistan',
            'Vanuatu','Vatican City','Venezuela','Vietnam',
            'Yemen',
            'Zambia','Zimbabwe'] as $country) {{-- simplified for demo --}}
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
            </div>
        </div>

        {{-- Card: Education History --}}
        <div class="card mb-4 border-0 shadow-sm">
            <div class="card-header text-white" style="background-color:#52074f;">
                <h5 class="mb-0">
                    History of Educational Institutions Attended 
                    <span class="badge" style="background-color:#dd8027;">Required</span>
                </h5>
            </div>
            <div class="card-body">
                <div id="education-history-body">
                    @php $educationHistories = old('education_histories', [[]]); @endphp
                    @foreach ($educationHistories as $index => $history)
                        <div class="row g-3 align-items-end mb-3 border-bottom pb-3">
                            <div class="col-md-6">
                                <label class="form-label">Qualification Name</label>
                                <input type="text" name="education_histories[{{ $index }}][name]" class="form-control"
                                       value="{{ $history['name'] ?? '' }}">
                                @error("education_histories.$index.name") 
                                    <div class="text-danger small">{{ $message }}</div> 
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Year Obtained</label>
                                <input type="number" name="education_histories[{{ $index }}][year]" class="form-control"
                                       value="{{ $history['year'] ?? '' }}">
                                @error("education_histories.$index.year") 
                                    <div class="text-danger small">{{ $message }}</div> 
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Institution</label>
                                <input type="text" name="education_histories[{{ $index }}][institution]" class="form-control"
                                       value="{{ $history['institution'] ?? '' }}">
                                @error("education_histories.$index.institution") 
                                    <div class="text-danger small">{{ $message }}</div> 
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Country</label>
                                <select name="education_histories[{{ $index }}][country]" class="form-control">
                                    <option value="">-- Select Country --</option>
                                    @foreach(['Afghanistan','Albania','Algeria','Andorra','Angola','Antigua and Barbuda','Argentina','Armenia','Australia','Austria','Azerbaijan',
            'Bahamas','Bahrain','Bangladesh','Barbados','Belarus','Belgium','Belize','Benin','Bhutan','Bolivia','Bosnia and Herzegovina','Botswana','Brazil','Brunei','Bulgaria','Burkina Faso','Burundi',
            'Cabo Verde','Cambodia','Cameroon','Canada','Central African Republic','Chad','Chile','China','Colombia','Comoros','Congo (Congo-Brazzaville)','Costa Rica','Croatia','Cuba','Cyprus','Czechia (Czech Republic)',
            'Democratic Republic of the Congo','Denmark','Djibouti','Dominica','Dominican Republic',
            'Ecuador','Egypt','El Salvador','Equatorial Guinea','Eritrea','Estonia','Eswatini','Ethiopia',
            'Fiji','Finland','France',
            'Gabon','Gambia','Georgia','Germany','Ghana','Greece','Grenada','Guatemala','Guinea','Guinea-Bissau','Guyana',
            'Haiti','Honduras','Hungary',
            'Iceland','India','Indonesia','Iran','Iraq','Ireland','Israel','Italy',
            'Jamaica','Japan','Jordan',
            'Kazakhstan','Kenya','Kiribati','Kuwait','Kyrgyzstan',
            'Laos','Latvia','Lebanon','Lesotho','Liberia','Libya','Liechtenstein','Lithuania','Luxembourg',
            'Madagascar','Malawi','Malaysia','Maldives','Mali','Malta','Marshall Islands','Mauritania','Mauritius','Mexico','Micronesia','Moldova','Monaco','Mongolia','Montenegro','Morocco','Mozambique','Myanmar (Burma)',
            'Namibia','Nauru','Nepal','Netherlands','New Zealand','Nicaragua','Niger','Nigeria','North Korea','North Macedonia','Norway',
            'Oman',
            'Pakistan','Palau','Palestine State','Panama','Papua New Guinea','Paraguay','Peru','Philippines','Poland','Portugal',
            'Qatar',
            'Romania','Russia','Rwanda',
            'Saint Kitts and Nevis','Saint Lucia','Saint Vincent and the Grenadines','Samoa','San Marino','Sao Tome and Principe','Saudi Arabia','Senegal','Serbia','Seychelles','Sierra Leone','Singapore','Slovakia','Slovenia','Solomon Islands','Somalia','South Africa','South Korea','South Sudan','Spain','Sri Lanka','Sudan','Suriname','Sweden','Switzerland','Syria',
            'Taiwan','Tajikistan','Tanzania','Thailand','Timor-Leste','Togo','Tonga','Trinidad and Tobago','Tunisia','Turkey','Turkmenistan','Tuvalu',
            'Uganda','Ukraine','United Arab Emirates','United Kingdom','United States of America','Uruguay','Uzbekistan',
            'Vanuatu','Vatican City','Venezuela','Vietnam',
            'Yemen',
            'Zambia','Zimbabwe'] as $country) {{-- simplified --}}
                                        <option value="{{ $country }}" {{ ($history['country'] ?? '') == $country ? 'selected' : '' }}>
                                            {{ $country }}
                                        </option>
                                    @endforeach
                                </select>
                                @error("education_histories.$index.country") 
                                    <div class="text-danger small">{{ $message }}</div> 
                                @enderror
                            </div>
                            <div class="col-12 text-end">
                                <button type="button" class="btn btn-sm" style="background-color:#dd8027; color:white;" onclick="removeRow(this)">
                                    Remove
                                </button>
                            </div>
                        </div>
                    @endforeach
                </div>
                <div class="mt-3">
                    <button type="button" class="btn" style="background-color:#52074f; color:white;" onclick="addEducationRow()">
                        + Add More
                    </button>
                </div>
            </div>
        </div>

        {{-- Card: Document Uploads --}}
        <div class="card mb-4 border-0 shadow-sm">
            <div class="card-header text-white" style="background-color:#52074f;">
                <h5 class="mb-0">Document Uploads</h5>
            </div>
            <div class="card-body">
                <div class="row g-4">
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
                    <div class="col-md-6">
                        <label class="form-label fw-bold">Upload Previous NCHE Evaluations</label>
                        <input type="file" name="previous_evaluations[]" class="form-control" multiple>
                        @error('previous_evaluations') <div class="text-danger small">{{ $message }}</div> @enderror
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-bold">Upload Syllabus / Course Prescriptions</label>
                        <input type="file" name="syllabi[]" class="form-control" multiple>
                        @error('syllabi') <div class="text-danger small">{{ $message }}</div> @enderror
                    </div>
                </div>
            </div>
        </div>

        {{-- Card: Consent Form --}}
        <div class="card mb-4 border-0 shadow-sm">
            <div class="card-header text-white" style="background-color:#52074f;">
                <h5 class="mb-0">Consent Form</h5>
            </div>
            <div class="card-body">
                <p class="mb-4 text-muted">
                    Please download the consent form, sign it, and upload the signed version below.
                </p>
                <div class="row mb-3">
                    <div class="col-auto">
                        <a href="{{ asset('assets/forms/consent_form.pdf') }}" download 
                           class="btn text-white" style="background-color:#dd8027;">
                            <i class="bi bi-download"></i> Download Consent Form
                        </a>
                    </div>
                </div>
                <div class="row g-4">
                    <div class="col-md-6">
                        <label for="consent_form" class="form-label fw-bold">
                            Upload Signed Consent Form (PDF)
                        </label>
                        <input type="file" name="consent_form" id="consent_form" 
                               class="form-control" accept="application/pdf" required>
                        @error('consent_form') <div class="text-danger small">{{ $message }}</div> @enderror
                    </div>
                </div>
            </div>
        </div>

        {{-- Notices --}}
        <div class="alert alert-info shadow-sm border-0">
            <strong>Important Notes:</strong>
            <ul class="mb-0 mt-2">
                <li>Submit certified copies and transcripts as required.</li>
                <li>Forged documents will lead to <strong>disqualification</strong>.</li>
                <li>NCHE may share this information with other institutions.</li>
                <li>Processing time: Normal – <strong>21 working days</strong>, Express – <strong>10 working days</strong>.</li>
            </ul>
        </div>

        {{-- Submit --}}
        <div class="text-center mt-4">
            <button type="submit" class="btn btn-primary px-5 py-2 fw-semibold shadow">Submit Application</button>
        </div>
    </form>
</div>

<script>
let eduIndex = {{ count(old('education_histories', [[]])) }};

function addEducationRow() {
    const container = document.getElementById('education-history-body');

    const row = document.createElement('div');
    row.className = 'row g-3 align-items-end mb-3 border-bottom pb-3';
    row.innerHTML = `
        <div class="col-md-6">
            <label class="form-label">Qualification Name</label>
            <input type="text" name="education_histories[${eduIndex}][name]" class="form-control" placeholder="Qualification Name">
        </div>
        <div class="col-md-6">
            <label class="form-label">Year Obtained</label>
            <input type="number" name="education_histories[${eduIndex}][year]" class="form-control">
        </div>
        <div class="col-md-6">
            <label class="form-label">Institution</label>
            <input type="text" name="education_histories[${eduIndex}][institution]" class="form-control" placeholder="Institution">
        </div>
        <div class="col-md-6">
               <label class="form-label">Country</label>
                                <select name="education_histories[{{ $index }}][country]" class="form-control">
                                    <option value="">-- Select Country --</option>
                                    @foreach(['Afghanistan','Albania','Algeria','Andorra','Angola','Antigua and Barbuda','Argentina','Armenia','Australia','Austria','Azerbaijan',
            'Bahamas','Bahrain','Bangladesh','Barbados','Belarus','Belgium','Belize','Benin','Bhutan','Bolivia','Bosnia and Herzegovina','Botswana','Brazil','Brunei','Bulgaria','Burkina Faso','Burundi',
            'Cabo Verde','Cambodia','Cameroon','Canada','Central African Republic','Chad','Chile','China','Colombia','Comoros','Congo (Congo-Brazzaville)','Costa Rica','Croatia','Cuba','Cyprus','Czechia (Czech Republic)',
            'Democratic Republic of the Congo','Denmark','Djibouti','Dominica','Dominican Republic',
            'Ecuador','Egypt','El Salvador','Equatorial Guinea','Eritrea','Estonia','Eswatini','Ethiopia',
            'Fiji','Finland','France',
            'Gabon','Gambia','Georgia','Germany','Ghana','Greece','Grenada','Guatemala','Guinea','Guinea-Bissau','Guyana',
            'Haiti','Honduras','Hungary',
            'Iceland','India','Indonesia','Iran','Iraq','Ireland','Israel','Italy',
            'Jamaica','Japan','Jordan',
            'Kazakhstan','Kenya','Kiribati','Kuwait','Kyrgyzstan',
            'Laos','Latvia','Lebanon','Lesotho','Liberia','Libya','Liechtenstein','Lithuania','Luxembourg',
            'Madagascar','Malawi','Malaysia','Maldives','Mali','Malta','Marshall Islands','Mauritania','Mauritius','Mexico','Micronesia','Moldova','Monaco','Mongolia','Montenegro','Morocco','Mozambique','Myanmar (Burma)',
            'Namibia','Nauru','Nepal','Netherlands','New Zealand','Nicaragua','Niger','Nigeria','North Korea','North Macedonia','Norway',
            'Oman',
            'Pakistan','Palau','Palestine State','Panama','Papua New Guinea','Paraguay','Peru','Philippines','Poland','Portugal',
            'Qatar',
            'Romania','Russia','Rwanda',
            'Saint Kitts and Nevis','Saint Lucia','Saint Vincent and the Grenadines','Samoa','San Marino','Sao Tome and Principe','Saudi Arabia','Senegal','Serbia','Seychelles','Sierra Leone','Singapore','Slovakia','Slovenia','Solomon Islands','Somalia','South Africa','South Korea','South Sudan','Spain','Sri Lanka','Sudan','Suriname','Sweden','Switzerland','Syria',
            'Taiwan','Tajikistan','Tanzania','Thailand','Timor-Leste','Togo','Tonga','Trinidad and Tobago','Tunisia','Turkey','Turkmenistan','Tuvalu',
            'Uganda','Ukraine','United Arab Emirates','United Kingdom','United States of America','Uruguay','Uzbekistan',
            'Vanuatu','Vatican City','Venezuela','Vietnam',
            'Yemen',
            'Zambia','Zimbabwe'] as $country) {{-- simplified --}}
                                        <option value="{{ $country }}" {{ ($history['country'] ?? '') == $country ? 'selected' : '' }}>
                                            {{ $country }}
                                        </option>
                                    @endforeach
                                </select>
                                @error("education_histories.$index.country") 
                                    <div class="text-danger small">{{ $message }}</div> 
                                @enderror
                            

        </div>
        <div class="col-12 text-end">
            <button type="button" class="btn btn-sm" style="background-color:#dd8027; color:white;" onclick="removeRow(this)">
                Remove
            </button>
        </div>
    `;
    container.appendChild(row);
    eduIndex++;
}

function removeRow(button) {
    button.closest('.row').remove();
}

// Processing Fee Script
initProcessingFeeScript();
function initProcessingFeeScript() {
    const processingSelect = document.getElementById('processing_type');
    const nationalitySelect = document.getElementById('nationality');
    const processingInfo = document.getElementById('processing_info');
    const feeInfo = document.getElementById('fee_info');

    if (!processingSelect || !nationalitySelect || !processingInfo || !feeInfo) return;

    function updateProcessingInfo() {
        const type = processingSelect.value;
        processingInfo.textContent = type === 'normal' ? "Normal takes 21 days." : "Express takes 10 days.";
    }

    function updateFeeInfo() {
        const type = processingSelect.value;
        const nationality = nationalitySelect.value;
        if(type==='normal' && nationality==='local') feeInfo.textContent="Locals: MK 75,000 per qualification";
        else if(type==='normal' && nationality==='foreigner') feeInfo.textContent="Foreigners: US$ 150 per qualification";
        else if(type==='express' && nationality==='local') feeInfo.textContent="Locals: MK 112,500 per qualification";
        else if(type==='express' && nationality==='foreigner') feeInfo.textContent="Foreigners: US$ 225 per qualification";
    }

    updateProcessingInfo();
    updateFeeInfo();
    processingSelect.addEventListener('change', ()=>{updateProcessingInfo(); updateFeeInfo();});
    nationalitySelect.addEventListener('change', updateFeeInfo);
}
</script>
@endsection
