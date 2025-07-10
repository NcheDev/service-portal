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
    <div class="row justify-content-center">
        <div class="col-md-8">

            {{-- Card --}}
            <div class="card shadow rounded">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">💳 Invoice Payment - Total: <strong>$200 USD</strong></h5>
                </div>

                <div class="card-body">

                    {{-- Payment Instructions --}}
                    <div class="alert alert-info">
                        Please choose your preferred payment method. Upload proof of payment if applicable. <br>
                        <strong>Note:</strong> For PayChangu, confirmation is automatic, no need to upload.
                    </div>

                    {{-- Payment Form --}}
                  <form id="payment-form" action="{{ route('invoices.submitPayment', $invoice->id) }}" method="POST" enctype="multipart/form-data">
    @csrf

                        {{-- Payment Method --}}
                        <div class="mb-3">
                            <label for="payment_method" class="form-label">Select Payment Method <span class="text-danger">*</span></label>
                            <select name="payment_method" id="payment_method" class="form-select" required>
                                <option value="">-- Choose --</option>
                                <option value="PayChangu">PayChangu</option>
                                <option value="Mpamba">Mpamba</option>
                                <option value="Airtel Money">Airtel Money</option>
                                <option value="Bank Deposit">Bank Deposit</option>
                            </select>
                        </div>

                        {{-- Proof Upload --}}
                        <div class="mb-3">
                            <label for="proof" class="form-label">Upload Proof of Payment</label>
                            <input type="file" name="proof" class="form-control">
                            <div class="form-text">Optional for PayChangu; required for Mpamba, Airtel Money, or Bank.</div>
                        </div>

                        {{-- Submit --}}
                        <button type="submit" class="btn btn-success w-100">Submit Payment</button>
                    </form>

                </div>
            </div>

            {{-- Optional: Add a visual footer or note --}}
            <div class="text-center text-muted mt-3">
                Need help? Contact support@nche.mw
            </div>

        </div>
    </div>
</div>
 <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
 <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(document).ready(function () {
    $('#payment-form').on('submit', function (e) {
        e.preventDefault();

        let form = $(this)[0];
        let formData = new FormData(form);
        let url = $(this).attr('action');

        $.ajax({
            type: 'POST',
            url: url,
            data: formData,
            contentType: false,
            processData: false,
            success: function () {
                alert('✅ Payment processed successfully. Please wait as we work on processing your application.');

                // Load the invoices.index page into .main-panel
                $.get("{{ route('invoices.index') }}", function (response) {
                    $('.main-panel').html(response);
                });
            },
            error: function () {
                alert('❌ Payment submission failed. Please check your input and try again.');
            }
        });
    });
});
</script>

</body>
</html>