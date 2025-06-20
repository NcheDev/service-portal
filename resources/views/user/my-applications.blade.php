<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>My Applications</title>
    <!-- Bootstrap 5 CSS CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
</head>
<body>
    <div class="container py-4">
        <h2 class="mb-4">My Applications</h2>

        <p>You have submitted <strong>{{ $applicationCount }}</strong> application{{ $applicationCount !== 1 ? 's' : '' }}.</p>

        @if($applications->isEmpty())
            <p>No applications found.</p>
        @else
            <div class="table-responsive">
                <table class="table table-bordered table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>Application ID</th>
                            <th>Processing Type</th>
                            <th>Nationality</th>
                            <th>Submitted At</th>
                            <th>Status</th> {{-- If you have a status column --}}
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($applications as $app)
                        <tr>
                            <td>{{ $app->id }}</td>
                            <td>{{ ucfirst($app->processing_type) }}</td>
                            <td>{{ $app->nationality }}</td>
                            <td>{{ $app->created_at->format('Y-m-d') }}</td>
                            <td>{{ $app->status ?? 'Pending' }}</td> {{-- Adjust if you track status --}}
                            <td>
                                <a href="{{ route('applications.show', $app->id) }}" class="btn btn-primary btn-sm">View Details</a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>

    <!-- Bootstrap 5 JS Bundle (Popper + JS) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
