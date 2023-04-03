<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SendMail extends Mailable
{
    use Queueable, SerializesModels;

    public $data;
    //public $subject;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($data = NULL)
    {
        //
        $this->data = $data;
        //$this->subject = $subject;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('frontend.emails.SendMail')->with('data',$this->data)->subject('Support Query');
    }
}
