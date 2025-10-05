@extends('layouts.user-dashboard')
@section('content')

@if(session('success'))
    <div class="alert shadow-sm border-0 mt-3" style="background-color:#dd8027; color:white;">
        {{ session('success') }}
    </div>
@endif

<div class="container mt-4">
    <h4 class="mb-4 text-center fw-bold" style="color:#52074f; letter-spacing:1px;">
        💳 My Payment Invoices
    </h4>

    @if($invoices->isEmpty())
        <div class="alert alert-info shadow-sm border-0">
            You don’t have any invoices yet.
        </div>
    @else
        <div class="table-responsive shadow-sm rounded">
            <table class="table align-middle">
                <thead style="background-color:#52074f; color:white;">
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
                            <td style="font-weight:500; color:#dd8027;">MK {{ number_format($invoice->fee, 2) }}</td>
                            <td>
                                @if ($invoice->proof_path)
                                    <span class="badge rounded-pill" style="background-color:#28a745; color:white;">Paid</span>
                                @else
                                    <span class="badge rounded-pill" style="background-color:#ffc107; color:#52074f;">Pending</span>
                                @endif
                            </td>
                            <td>
                                <a href="{{ route('invoices.show', $invoice->id) }}" 
                                   class="btn btn-sm" 
                                   style="background-color:#52074f; color:white; border:none;">
                                    Details
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
