<div class="container mt-4">
    <h4 class="mb-3">💳 My Payment Invoices</h4>

    @if($invoices->isEmpty())
        <div class="alert alert-info">You don’t have any invoices yet.</div>
    @else
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Invoice</th>
                    <th>Amount</th>
                    <th>Status</th>
                    <th>View</th>
                </tr>
            </thead>
            <tbody>
                @foreach($invoices as $invoice)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $invoice->invoice_number }}</td>
                        <td>${{ number_format($invoice->fee, 2) }}</td>
                        <td>
                            @if ($invoice->proof_path)
                                <span class="badge bg-success">Paid</span>
                            @else
                                <span class="badge bg-warning text-dark">Pending</span>
                            @endif
                        </td>
                        <td>
                            <a href="{{ route('invoices.show', $invoice->id) }}" class="btn btn-sm btn-outline-primary ajax-link">Details</a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
</div>
