<?php

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class UserValidatedMail extends Mailable
{
    use Queueable, SerializesModels;

    public $user;

    public function __construct($user)
    {
        $this->user = $user;
    }

    public function build()
    {
        return $this->subject('Your Application Has Been Validated')
                    ->view('emails.user_validated')
                    ->with([
                        'name' => $this->user->name,
                        'url' => url('/my-applications'), 
                    ]);
    }
}
