<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>All Applicants</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container mt-5">
    <h2 class="mb-4 text-success">Un Recognised Applications</h2>

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
                @foreach($users as $index => $user)
                    <tr>
                        <td>{{ $loop->iteration + ($users->currentPage() - 1) * $users->perPage() }}</td>
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->email }}</td>
                        <td>
                            @if($user->applications->count())
                                @foreach($user->applications as $app)
                                    <div class="mb-1">
                                        <span class="badge bg-{{ 
                                            $app->status === 'validated' ? 'success' : 
                                            ($app->status === 'pending' ? 'warning text-dark' : 
                                            ($app->status === 'invalid' ? 'danger' : 'secondary')) 
                                        }}">
                                            {{ ucfirst($app->status) }}
                                        </span>
                                    </div>
                                @endforeach
                            @else
                                <span class="badge bg-secondary">No Applications</span>
                            @endif
                        </td>
                        <td>
<a href="#" class="btn btn-sm btn-primary btn-view-user" data-user-id="{{ $user->id }}">View</a>
                        </td>
                    </tr>
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

</body>
</html>
