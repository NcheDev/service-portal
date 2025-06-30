<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

 class UserStatusNotificationMail extends Mailable
{
    use Queueable, SerializesModels;

    public $user;
    public $status;
    public $application;

    public function __construct($user, $application, $status)
    {
        $this->user = $user;
        $this->application = $application;
        $this->status = $status;
    }

    public function build()
    {
        $subject = $this->status === 'validated'
            ? 'Your Application Has Been Validated'
            : 'Your Application Could Not Be Verified';

        return $this->subject($subject)
                    ->view('emails.user_status_notification')
                    ->with([
                        'name' => $this->user->name,
                        'status' => $this->status,
                        'url' => url('/applications/' . $this->application->id), 
                    ]);
    }
}
