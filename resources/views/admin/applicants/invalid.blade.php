<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>All Applicants</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container mt-5">
    <h2 class="mb-4 text-success">Unrecognised Applications</h2>

    @if($users->count() > 0)
        <table class="table table-bordered table-striped">
            <thead class="table-dark">
                <tr>
                    <th>#</th>
                    <th>Full Name</th>
                    <th>Email</th>
                    <th>Status</th>
                    <th>View</th>
                </tr>
            </thead>
            <tbody>
                @foreach($users as $user)
                    @if($user->applications->count())
                        @foreach($user->applications as $app)
                            <tr>
                                <td>{{ $loop->parent->iteration }}.{{ $loop->iteration }}</td>
                                <td>{{ $user->name }}</td>
                                <td>{{ $user->email }}</td>
                                <td>
                                    <span class="badge bg-{{ 
                                        $app->status === 'validated' ? 'success' : 
                                        ($app->status === 'pending' ? 'warning text-dark' : 
                                        ($app->status === 'invalid' ? 'danger' : 'secondary')) 
                                    }}">
                                    {{ $app->status === 'invalid' ? 'Unrecognised' : ucfirst($app->status) }}
                                    </span>
                                </td>
                                <td>
                           <a href="{{ route('admin.applicants.viewApplication', [$user->id, $app->id]) }}" 
                            class="btn btn-sm btn-primary btn-view-application" 
                            data-url="{{ route('admin.applicants.viewApplication', [$user->id, $app->id]) }}">
                            View Application
                            </a>
                                </td>
                            </tr>
                        @endforeach
                    @else
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->email }}</td>
                            <td><span class="badge bg-secondary">No Applications</span></td>
                            <td>
                                <a href="#" class="btn btn-sm btn-secondary disabled">N/A</a>
                            </td>
                        </tr>
                    @endif
                @endforeach
            </tbody>
        </table>

        <!-- Pagination -->
        <div class="d-flex justify-content-center">
            {{ $users->links() }}
        </div>
    @else
        <div class="alert alert-info">No applicants found.</div>
    @endif
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
$(document).ready(function() {
    $('.btn-view-user').on('click', function(e) {
        e.preventDefault();

        var userId = $(this).data('user-id');
        var url = '/admin/users/' + userId;

        $.ajax({
            url: url,
            method: 'GET',
            success: function(response) {
                $('.main-panel').html(response);
            },
            error: function(xhr) {
                alert('Failed to load user details.');
                console.error(xhr);
            }
        });
    });
});
</script>
<script>
$(document).ready(function() {
    $('.btn-view-application').on('click', function(e) {
        e.preventDefault();

        var url = $(this).data('url');

        $.ajax({
            url: url,
            method: 'GET',
            success: function(response) {
                $('.main-panel').html(response);
            },
            error: function(xhr) {
                alert('Failed to load application details.');
                console.error(xhr);
            }
        });
    });
});
</script>

</body>
</html>
