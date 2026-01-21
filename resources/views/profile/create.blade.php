@extends('layouts.app')

@section('title', 'Complete Profile')

@section('content')
<div class="container py-4">
    <h4 class="mb-4">Personal Information</h4>

    <form method="POST" action="{{ route('profile.store') }}">
        @csrf

        <div class="row g-3">

            <div class="col-md-3">
                <label class="form-label">Title</label>
                <select name="title_id" class="form-control" required>
                    <option value="">Select</option>
                    @foreach($titles as $title)
                        <option value="{{ $title->id }}">{{ $title->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="col-md-4">
                <label class="form-label">First Name</label>
                <input name="first_name" class="form-control" required>
            </div>

            <div class="col-md-5">
                <label class="form-label">Last Name</label>
                <input name="last_name" class="form-control" required>
            </div>

            <div class="col-md-6">
                <label class="form-label">Previous Names</label>
                <input name="previous_names" class="form-control">
            </div>

            <div class="col-md-6">
                <label class="form-label">Gender</label>
                <select name="gender_id" class="form-control" required>
                    <option value="">Select</option>
                    @foreach($genders as $gender)
                        <option value="{{ $gender->id }}">{{ $gender->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="col-md-6">
                <label class="form-label">Primary Contact</label>
                <input name="primary_contact" class="form-control" required>
            </div>

            <div class="col-md-6">
                <label class="form-label">Secondary Contact</label>
                <input name="secondary_contact" class="form-control">
            </div>

            <div class="col-md-6">
                <label class="form-label">Nationality</label>
                <select name="nationality_id" class="form-control" required>
                    @foreach($countries as $country)
                        <option value="{{ $country->id }}">
                            {{ country_flag($country->iso_code) }} {{ $country->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="col-md-6">
                <label class="form-label">Country of Residence</label>
                <select name="country_id" class="form-control" required>
                    @foreach($countries as $country)
                        <option value="{{ $country->id }}">
                            {{ country_flag($country->iso_code) }} {{ $country->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="col-md-6">
                <label class="form-label">National ID (Malawi only)</label>
                <input name="national_id_number" class="form-control">
            </div>

        </div>

        <div class="mt-4">
            <button class="btn btn-primary">Save Profile</button>
        </div>
    </form>
</div>
@endsection
