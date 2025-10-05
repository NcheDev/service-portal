@extends('layouts.user-dashboard')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-7 col-md-9">

            {{-- Payment Card --}}
            <div class="card shadow-lg border-0 rounded-4">
                <div class="card-header text-white" style="background-color:#52074f;">
                    <h5 class="mb-0 d-flex align-items-center justify-content-between">
                        <span>💳 Invoice Payment</span>
@php
    $isForeigner = strtolower($invoice->application->nationality) !== 'malawian';
    $currency = $isForeigner ? 'USD' : 'MWK';
    $amount = $invoice->amount ?? $invoice->fee ?? 0;
@endphp

<span class="badge" style="background-color:#dd8027; color:white; font-size:1rem; padding:0.5rem 1rem; border-radius:8px;">
    Total: 
    <strong>
        @if($currency === 'USD')
            ${{ number_format($amount, 2) }} USD
        @else
            MK {{ number_format($amount, 0) }} MWK
        @endif
    </strong>
</span>

                    </h5>
                </div>

                <div class="card-body bg-light">

                    {{-- Info Alert --}}
                    <div class="alert alert-warning border-0 rounded-3" style="background-color:#fff5eb; color:#52074f;">
                        <strong>Note:</strong> For <b>PayChangu</b> payments, confirmation is automatic — no need to upload proof.  
                        <br>For mobile money or bank deposits, please upload proof of payment.
                    </div>

                    {{-- Payment Form --}}
                    <form id="payment-form" action="{{ route('invoices.submitPayment', $invoice->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        {{-- Payment Method --}}
                        <div class="mb-3">
                            <label for="payment_method" class="form-label fw-semibold text-dark">Payment Method <span class="text-danger">*</span></label>
                            <select name="payment_method" id="payment_method" class="form-select border-secondary" required>
                                <option value="">-- Choose Method --</option>
                                <option value="PayChangu">PayChangu</option>
                                <option value="Mpamba">Mpamba</option>
                                <option value="Airtel Money">Airtel Money</option>
                                <option value="Bank Deposit">Bank Deposit</option>
                            </select>
                        </div>

                        {{-- Proof Upload --}}
                        <div class="mb-4">
                            <label for="proof" class="form-label fw-semibold text-dark">Upload Proof of Payment</label>
                            <input type="file" name="proof" class="form-control border-secondary">
                            <small class="text-muted">Optional for PayChangu. Required for Mpamba, Airtel Money, or Bank Deposit.</small>
                        </div>

                        {{-- Submit --}}
                        <button type="submit" class="btn w-100 py-2 text-white fw-bold" style="background-color:#dd8027;">
                            Submit Payment
                        </button>
                    </form>
                </div>
            </div>

            {{-- Footer --}}
            <div class="text-center mt-4 small text-muted">
                Need help? Email <a href="mailto:support@nche.mw" class="text-decoration-none" style="color:#52074f;">support@nche.mw</a>
            </div>
        </div>
    </div>
</div>

{{-- Scripts --}}
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
                Swal.fire({
                    icon: 'success',
                    title: 'Payment Successful',
                    text: 'Please wait as we process your application.',
                    confirmButtonColor: '#52074f'
                });

                // Load invoice index page dynamically into main panel
               window.location.href = "{{ route('invoices.index') }}";

            },
            error: function () {
                Swal.fire({
                    icon: 'error',
                    title: 'Payment Failed',
                    text: 'Please check your input and try again.',
                    confirmButtonColor: '#52074f'
                });
            }
        });
    });
});
</script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
@endsection
