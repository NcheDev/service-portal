@extends('layouts.user-dashboard')
@section('content')
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Invoice Details - NCHE</title>
    <style>
    body {
        background-color: #f8f9fc;
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }

    .card {
        border: none;
        border-radius: 15px;
        overflow: hidden; 
    }

    .card-header {
        background: linear-gradient(90deg, #52074f, #dd8027);
        color: white;
        padding: 1.5rem;
    }

    .card-header h4 {
        font-weight: 700;
        margin: 0;
        font-size: 1.25rem;
    }

    .card-header span {
        font-size: 0.9rem;
        color: #f8f9fc;
    }

    h5.text-secondary {
        color: #52074f !important;
        font-weight: 600;
        border-left: 4px solid #dd8027;
        padding-left: 10px;
        margin-bottom: 1rem;
    }

    .table thead th {
        background-color: #f3f2f7;
        color: #333;
    }

    .table-bordered {
        border-radius: 10px;
        overflow: hidden;
    }

    .btn-success {
        background-color: #dd8027;
        border: none;
        font-weight: 600;
    }

    .btn-success:hover {
        background-color: #c06e22;
    }

    .btn-outline-secondary {
        border-color: #52074f;
        color: #52074f;
    }

    .btn-outline-secondary:hover {
        background-color: #52074f;
        color: white;
    }

    .btn-outline-primary {
        color: #dd8027;
        border-color: #dd8027;
    }

    .btn-outline-primary:hover {
        background-color: #dd8027;
        color: white;
    }

    .invoice-footer {
        text-align: center;
        color: #888;
        margin-top: 2rem;
        font-size: 0.9rem;
    }

    .card-body {
        padding: 2rem;
    }

    .currency-tag {
        background-color: #e6e6e6;
        padding: 2px 8px;
        border-radius: 5px;
        font-size: 0.85rem;
        color: #555;
    }

    @media (max-width: 768px) {
        .card-body {
            padding: 1.25rem;
        }
        .d-flex.justify-content-end {
            flex-direction: column;
            gap: 0.75rem !important;
        }
    }
  </style>
</head>
<body>

<div class="container mt-5 mb-5">
  <div class="card shadow-lg">

    <!-- Header -->
    <div class="card-header d-flex justify-content-between align-items-center">
      <h4>🧾 Invoice #{{ $invoice->invoice_number }}</h4>
      <span>{{ $invoice->created_at->format('d M Y') }}</span>
    </div>

    <!-- Body -->
    <div class="card-body">

      <!-- Applicant Info -->
      <div class="mb-4">
        <h5 class="text-secondary">Applicant Information</h5>
        <p><strong>Name:</strong> {{ $invoice->application->user->name }}</p>
        <p><strong>Email:</strong> {{ $invoice->application->user->email }}</p>
      </div>

      <!-- Application Info -->
      <div class="mb-4">
        <h5 class="text-secondary">Application Details</h5>
        <p><strong>Processing Type:</strong> {{ ucfirst($invoice->processing_type) }}</p>
        <p><strong>Nationality:</strong> {{ $invoice->application->nationality }}</p>
      </div>

      <!-- Fee Info -->
      <div class="mb-4">
        <h5 class="text-secondary">Invoice Summary</h5>
        <table class="table table-bordered align-middle">
          <thead>
            <tr>
              <th>Description</th>
              <th class="text-end">Amount</th>
            </tr>
          </thead>
          <tbody>
           @php
    $isForeigner = strtolower($invoice->application->nationality) !== 'malawian';
    $currency = $isForeigner ? 'USD' : 'MWK';
    $amount = $invoice->fee ?? 0;
@endphp

<tr>
    <td>{{ ucfirst($invoice->processing_type) }} Application Fee</td>
    <td class="text-end">
        @if($currency === 'USD')
            ${{ number_format($amount, 2) }} <span class="currency-tag">USD</span>
        @else
            MK {{ number_format($amount, 0) }} <span class="currency-tag">MWK</span>
        @endif
    </td>
</tr>

          </tbody>
          <tfoot>
            <tr>
              <th>Total</th>
              @if($invoice->currency === 'USD')
                <th class="text-end text-success">${{ number_format($invoice->fee, 2) }} USD</th>
              @else
                <th class="text-end text-success">MK {{ number_format($invoice->fee, 0) }} MWK</th>
              @endif
            </tr>
          </tfoot>
        </table>
      </div>

      <!-- Payment Proof -->
      @if($invoice->proof_path)
      <div class="mb-4">
        <h5 class="text-secondary">Payment Proof</h5>
        <a href="{{ Storage::url($invoice->proof_path) }}" target="_blank" class="btn btn-outline-primary btn-sm">
          📎 View Uploaded Proof
        </a>
      </div>
      @endif

      <!-- Buttons -->
      <div class="d-flex justify-content-end gap-3 flex-wrap mt-4">
        <a href="{{ route('invoices.pdf', $invoice->id) }}" class="btn btn-outline-secondary">
          <i class="bi bi-download"></i> Download PDF
        </a>
        <a href="{{ route('invoices.payment', $invoice->id) }}" class="btn btn-success ajax-link">
          💰 Proceed to Payment
        </a>
      </div>

    </div>
  </div>

  <div class="invoice-footer">
    Need help? Contact <a href="mailto:support@nche.mw" style="color:#52074f; text-decoration:none;">support@nche.mw</a>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(document).ready(function () {
    $(document).on('click', 'a.ajax-link', function (e) {
        e.preventDefault();
        window.location.href = $(this).attr('href'); // Full page load now
    });
});
</script>

</body>
</html>
@endsection
