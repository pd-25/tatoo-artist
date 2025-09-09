<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Barryvdh\DomPDF\Facade\Pdf as FacadePdf;

class PaymentInvoiceMail extends Mailable
{
    use Queueable, SerializesModels;

    public $data;

    /**
     * Create a new message instance.
     */
    public function __construct($data)
    {
        $this->data = $data;
    }

    /**
     * Build the message.
     */
    public function build()
    {
        // Generate PDF from a separate blade view
        $pdf = FacadePdf::loadView('admin.email.payment-invoice-pdf', ['data' => $this->data]);

        return $this->subject('Payment Invoice')
            ->view('admin.email.payment-invoice-mail')
            ->with(['data' => $this->data])
            ->attachData($pdf->output(), 'invoice.pdf', [
                'mime' => 'application/pdf',
            ]);
    }
}
