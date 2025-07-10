<?php
// app/Http/Controllers/InvoiceController.php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Invoice;
use Barryvdh\DomPDF\Facade\Pdf;

class InvoiceController extends Controller
{
    public function show($id)
    {
        $invoice = Invoice::with('application.user')->findOrFail($id);
        return view('invoices.show', compact('invoice'));
    }

    public function downloadPdf(Invoice $invoice)
    {
        $invoice->load('application.user');

        $pdf = Pdf::loadView('invoices.pdf', compact('invoice'));
        return $pdf->download('Invoice_' . $invoice->invoice_number . '.pdf');
    }

    public function printPdf(Invoice $invoice)
    {
        $invoice->load('application.user');

        $pdf = Pdf::loadView('invoices.pdf', compact('invoice'));
        return $pdf->stream('Invoice_' . $invoice->invoice_number . '.pdf');
    }

    public function paymentForm(Invoice $invoice)
    {
        return view('invoices.payment', compact('invoice'));
    }

    public function submitPayment(Request $request, Invoice $invoice)
    {
        $request->validate([
            'payment_method' => 'required|string',
            'proof' => 'required|file|mimes:jpg,jpeg,png,pdf|max:2048',
        ]);

        // Store the file in public/payments directory

        $path = $request->file('proof')->store('payments', 'public');


        // Clean path for URL usage: remove 'public/' prefix
        $cleanPath = str_replace('public/', '', $path);
        $invoice->payment_method = $request->payment_method;
        $invoice->proof_path = $cleanPath;
        $invoice->save();

      return response()->json(['message' => 'Payment submitted.']);

    }



}
