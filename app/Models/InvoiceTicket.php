<?php
namespace App\Mail; 

use App\Models\Invoice;
use Illuminate\Mail\Mailable;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Queue\SerializesModels;
use Illuminate\Foundation\Queue\Queueable;

class InvoiceTicket extends Mailable
{
    use Queueable, SerializesModels;

    public $invoice;

    public function __construct(Invoice $invoice)
    {
        $this->invoice = $invoice;
    }

    public function build()
    {
        return $this->subject('Your Invoice Ticket')
            ->markdown('emails.invoice.ticket')
            ->attachData(
                Pdf::loadView('invoice-pdf', ['invoice' => $this->invoice])->output(),
                "Invoice_{$this->invoice->invoice_number}.pdf"
            );
    }
}
