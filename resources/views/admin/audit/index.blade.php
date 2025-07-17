 
<div class="container">
    <h4 class="mb-4 fw-bold text-dark">
        <i class="mdi mdi-history text-warning me-2"></i> Audit Trail
    </h4>

    <div class="card shadow-sm">
        <div class="card-body table-responsive">
            <table class="table table-striped table-hover">
                <thead class="table-warning text-dark">
                    <tr>
                        <th>#</th>
                        <th>User</th>
                        <th>Event</th>
                        <th>Model</th>
                        <th>Old Values</th>
                        <th>New Values</th>
                        <th>IP</th>
                        <th>Device</th>
                        <th>Time</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($logs as $log)
                        <tr>
                            <td>{{ $loop->iteration + ($logs->currentPage() - 1) * $logs->perPage() }}</td>
                            <td>{{ $log->user?->name ?? 'System' }}</td>
                            <td class="text-primary">{{ $log->action }}</td>
                            <td>{{ class_basename($log->auditable_type) }} #{{ $log->auditable_id }}</td>
                            <td><pre>{{ json_encode($log->old_values, JSON_PRETTY_PRINT) }}</pre></td>
                            <td><pre>{{ json_encode($log->new_values, JSON_PRETTY_PRINT) }}</pre></td>
                            <td>{{ $log->ip_address }}</td>
                            <td style="max-width: 150px;">{{ Str::limit($log->user_agent, 60) }}</td>
                            <td>{{ $log->created_at->diffForHumans() }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="9" class="text-center text-muted">No audit logs found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

            <div class="mt-3">
                {{ $logs->links() }}
            </div>
        </div>
    </div>
</div>
 
