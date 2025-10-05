@extends('layouts.user-dashboard')

@section('title', 'My Applications')

@section('content')
<div class="container pt-5 pb-4">
    <h2 class="mb-4 text-center fw-bold" style="color:#52074f; letter-spacing:1px;">
        📄 My Applications
    </h2>

    <p class="text-center mb-4">
        You have submitted <strong>{{ $applicationCount }}</strong>
        application{{ $applicationCount !== 1 ? 's' : '' }}.
    </p>

    @if($applications->isEmpty())
        <div class="alert alert-info shadow-sm border-0 text-center">
            No applications found.
        </div>
    @else
        <div class="table-responsive shadow-sm rounded">
            <table class="table align-middle table-hover">
                <thead style="background-color:#52074f; color:white;">
                    <tr>
                        <th>Application ID</th>
                        <th>Processing Type</th>
                        <th>Nationality</th>
                        <th>Submitted At</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($applications as $app)
                        <tr class="align-middle">
                            <td>{{ $app->id }}</td>
                            <td class="text-capitalize">{{ $app->processing_type }}</td>
                            <td class="text-capitalize">{{ $app->nationality }}</td>
                            <td>{{ $app->created_at->format('Y-m-d') }}</td>
                            <td>
                                @if ($app->status === 'validated')
                                    <span class="badge rounded-pill" style="background-color:#28a745; color:white;">Recognised</span>
                                @elseif ($app->status === 'invalid')
                                    <span class="badge rounded-pill" style="background-color:#dc3545; color:white;">Unrecognised</span>
                                @else
                                    <span class="badge rounded-pill" style="background-color:#ffc107; color:#52074f;">Pending</span>
                                @endif
                            </td>
                            <td>
                                <a href="{{ route('applications.show', $app->id) }}" 
                                   class="btn btn-sm" 
                                   style="background-color:#52074f; color:white; border:none;">
                                    View Details
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif
</div>

@endsection
