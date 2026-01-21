@extends('layouts.app')

@section('title', 'Profile')

@section('content')
<div class="container py-4">
    <h4 class="mb-4">My Profile</h4>

    <table class="table table-bordered">
        <tr>
            <th>Title</th>
            <td>{{ $profile->title?->name }}</td>
        </tr>
        <tr>
            <th>First Name</th>
            <td>{{ $profile->first_name }}</td>
        </tr>
        <tr>
            <th>Last Name</th>
            <td>{{ $profile->last_name }}</td>
        </tr>
        <tr>
            <th>Previous Names</th>
            <td>{{ $profile->previous_names }}</td>
        </tr>
        <tr>
            <th>Primary Contact</th>
            <td>{{ $profile->primary_contact }}</td>
        </tr>
        <tr>
            <th>Secondary Contact</th>
            <td>{{ $profile->secondary_contact }}</td>
        </tr>
        <tr>
            <th>Nationality</th>
            <td>{{ $profile->nationality?->name }}</td>
        </tr>
        <tr>
            <th>Malawian ID</th>
            <td>{{ $profile->malawian_id }}</td>
        </tr>
        <tr>
            <th>Gender</th>
            <td>{{ $profile->gender?->name }}</td>
        </tr>
        <tr>
            <th>Country</th>
            <td>{{ $profile->country }}</td>
        </tr>
    </table>

    <a href="{{ route('profile.create') }}" class="btn btn-warning">Edit Profile</a>
</div>
@endsection
