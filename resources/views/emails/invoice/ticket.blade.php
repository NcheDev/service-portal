@component('mail::message')
# Hello {{ $invoice->user->name }},

Thank you for your submission. Attached is your invoice ticket.

- **Invoice Number:** {{ $invoice->invoice_number }}
- **Amount:** {{ $invoice->total_amount }} {{ $invoice->currency }}
- **Status:** {{ ucfirst($invoice->status) }}

@component('mail::button', ['url' => route('invoice.show', $invoice->id)])
View Invoice
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
