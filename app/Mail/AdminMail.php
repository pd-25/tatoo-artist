<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class AdminMail extends Mailable
{
    use Queueable, SerializesModels;
    
    public $userEmail;
    public $subscriptionData;
    public $salesdata;
    public $mailsubject ;

    public function __construct($userEmail, $subscriptionData,$salesdata,$mailsubject)
    {
        $this->userEmail = $userEmail;
        $this->subscriptionData = $subscriptionData;
        $this->salesdata = $salesdata;
        $this->mailsubject = $mailsubject;
    }

    public function build()
    {
        return $this->subject($this->mailsubject)
        ->view('emails.salesjoning')
        ->with([
            'userdata' => $this->userEmail,
            'subscriptionData' => $this->subscriptionData,
            'salesdata' => $this->salesdata,
        ]);
    }
}
