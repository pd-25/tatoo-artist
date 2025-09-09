<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class AfterCareInstruction extends Mailable
{
    use Queueable, SerializesModels;

    public $customer;

    /**
     * Create a new message instance.
     */
    public function __construct($customer)
    {
        $this->customer = $customer;
    }

    /**
     * Build the message.
     */
    public function build()
    {
        return $this->subject('After Care Instruction')
                    ->view('admin.email.aftercare-instruction')
                    ->with(['customer' => $this->customer])
                    ->attach(public_path('aftercare.pdf'), [
                        'as' => 'aftercare.pdf',
                        'mime' => 'application/pdf',
                    ]);
    }
}
