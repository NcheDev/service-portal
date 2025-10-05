 @extends('layouts.user-dashboard')
 @section('content')
 <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>NCHE Portal</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body> 
<div class="container mt-5">
    <div class="card shadow rounded">

        <!-- Header -->
        <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
            <h4 class="mb-0">🧾 Invoice #{{ $invoice->invoice_number }}</h4>
            <span class="fw-light">{{ $invoice->created_at->format('d M Y') }}</span>
        </div>

        <!-- Body -->
        <div class="card-body">

            <!-- Applicant Info -->
            <div class="mb-4">
                <h5 class="text-secondary">👤 Applicant Information</h5>
                <p><strong>Name:</strong> {{ $invoice->application->user->name }}</p>
                <p><strong>Email:</strong> {{ $invoice->application->user->email }}</p>
            </div>

            <!-- Application Info -->
            <div class="mb-4">
                <h5 class="text-secondary">📄 Application Details</h5>
                <p><strong>Processing Type:</strong> {{ ucfirst($invoice->processing_type) }}</p>
                <p><strong>Nationality:</strong> {{ $invoice->application->nationality }}</p>
            </div>

            <!-- Fee Info -->
            <div class="mb-4">
                <h5 class="text-secondary">💵 Invoice Summary</h5>
                <table class="table table-bordered">
                    <thead class="table-light">
                        <tr>
                            <th>Description</th>
                            <th class="text-end">Amount (USD)</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>{{ ucfirst($invoice->processing_type) }} Application Fee</td>
                            <td class="text-end">${{ number_format($invoice->fee, 2) }}</td>
                        </tr>
                    </tbody>
                    <tfoot class="table-light">
                        <tr>
                            <th>Total</th>
                            <th class="text-end">${{ number_format($invoice->fee, 2) }}</th>
                        </tr>
                    </tfoot>
                </table>
            </div>

            <!-- Payment Proof -->
            @if($invoice->proof_path)
                <div class="mb-4">
                    <h5 class="text-secondary">📎 Payment Proof</h5>
                    <a href="{{ Storage::url($invoice->proof_path) }}" target="_blank" class="btn btn-outline-primary btn-sm">
                        View Uploaded Proof
                    </a>
                </div>
            @endif

            <!-- Action Buttons -->
            <div class="d-flex justify-content-end gap-2 flex-wrap">
                <a href="{{ route('invoices.pdf', $invoice->id) }}" class="btn btn-outline-secondary">
                    <i class="bi bi-download"></i> Download PDF
                </a>

                <a href="{{ route('invoices.payment', $invoice->id) }}" class="btn btn-success ajax-link">
    💰 Proceed to Payment
</a>

            </div>

        </div>
    </div>
</div>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
<script>
$(document).ready(function () {
    function loadPanel(url) {
        $.get(url, function (response) {
            $('.main-panel').html(response);
        }).fail(function () {
            alert('Failed to load content.');
        });
    }

    // AJAX link handler
    $(document).on('click', 'a.ajax-link', function (e) {
        e.preventDefault();
        const url = $(this).attr('href');
        loadPanel(url);
    });
});
</script>

</html>
@endsection