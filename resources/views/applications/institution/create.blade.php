@extends('layouts.app')

@section('title', 'Institution Application')

@section('content')
<div class="container py-4">

    <!-- Progress Bar -->
    @include('applications.partials.progress', ['application' => $application])

    <h4 class="mb-4">Institution Application Details</h4>

    <form method="POST" action="{{ route('applications.institution.store', $application) }}">
        @csrf

        <div class="row g-3 mb-3">
            <div class="col-md-6">
                <label class="form-label">Institution Name</label>
                <input name="institution_name" class="form-control" required>
            </div>

            <div class="col-md-6">
                <label class="form-label">Registration Number</label>
                <input name="registration_number" class="form-control">
            </div>

            <div class="col-md-6">
                <label class="form-label">Country</label>
                <select name="country_id" class="form-control" required>
                    <option value="">Select country</option>
                    @foreach($countries as $country)
                        <option value="{{ $country->id }}">
                            {{ country_flag($country->iso_code) }} {{ $country->name }}
                        </option>
                    @endforeach
                </select>
            </div>
        </div>

        <h5 class="mt-4 mb-2">Institution Contacts</h5>

        <div id="contact-container">
            <div class="row g-3 contact-row mb-2">
                <div class="col-md-3">
                    <label class="form-label">First Name</label>
                    <input name="contacts[0][first_name]" class="form-control" required>
                </div>

                <div class="col-md-3">
                    <label class="form-label">Last Name</label>
                    <input name="contacts[0][last_name]" class="form-control" required>
                </div>

                <div class="col-md-3">
                    <label class="form-label">Phone</label>
                    <input name="contacts[0][phone]" class="form-control" required>
                </div>

                <div class="col-md-3">
                    <label class="form-label">Nationality</label>
                    <select name="contacts[0][nationality_id]" class="form-control" required>
                        <option value="">Select nationality</option>
                        @foreach($countries as $country)
                            <option value="{{ $country->id }}">
                                {{ country_flag($country->iso_code) }} {{ $country->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>

        <button type="button" class="btn btn-secondary mb-3" id="add-contact">
            <i class="bi bi-plus-circle"></i> Add Another Contact
        </button>

        <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center gap-2 mt-4">
            <!-- Save & Continue -->
            <button class="btn btn-primary mb-2 mb-md-0">
                <i class="bi bi-save"></i> Save & Continue to Documents
            </button>

            <!-- Preview & Submit -->
            <div class="d-flex gap-2 flex-wrap">
                <a href="{{ route('applications.preview', $application) }}"
                   class="btn btn-outline-secondary">
                    <i class="bi bi-eye"></i> Preview Application
                </a>

                <form method="POST" action="{{ route('applications.submit', $application) }}">
                    @csrf
                    <button class="btn btn-success"
                            onclick="return confirm('Are you sure you want to submit this application?')">
                        <i class="bi bi-check-circle"></i> Submit Application
                    </button>
                </form>
            </div>
        </div>

    </form>
</div>

<script>
let contactIndex = 1;
document.getElementById('add-contact').addEventListener('click', function () {
    const container = document.getElementById('contact-container');
    const row = document.querySelector('.contact-row').cloneNode(true);

    row.querySelectorAll('input, select').forEach(input => {
        const name = input.getAttribute('name');
        const newName = name.replace(/\d+/, contactIndex);
        input.setAttribute('name', newName);
        if(input.tagName === 'INPUT') input.value = '';
        if(input.tagName === 'SELECT') input.selectedIndex = 0;
    });

    container.appendChild(row);
    contactIndex++;
});
</script>

<style>
/* Theme colors */
.btn-primary { background-color: #d96c19; border-color: #d96c19; }
.btn-primary:hover { background-color: #600061; border-color: #600061; }

.btn-outline-secondary { border-color: #600061; color: #600061; }
.btn-outline-secondary:hover { background-color: #600061; color: #fff; }

.btn-success { background-color: #28a745; border-color: #28a745; }
.btn-success:hover { background-color: #218838; border-color: #1e7e34; }

.progress-bar { background-color: #d96c19; }
</style>

@endsection
