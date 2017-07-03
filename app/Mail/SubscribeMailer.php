<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class SubscribeMailer extends Mailable
{
    use Queueable, SerializesModels;

    protected $email;
    protected $token;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($reciever_email, $confirmation_token)
    {
        $this->email = $reciever_email;
        $this->token = $confirmation_token;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('emails.subscriber')->with(['email'=>$this->email, 'token'=>$this->token]);
    }
}
