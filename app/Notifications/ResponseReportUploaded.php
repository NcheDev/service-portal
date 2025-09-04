<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ResponseReportUploaded extends Notification implements ShouldQueue
{
    use Queueable;

    protected $message;
    protected $link;

    public function __construct($message, $link = null)
    {
        $this->message = $message;
        $this->link = $link;
    }

    // Notification channels
    public function via($notifiable)
    {
        return ['mail', 'database'];
    }

    // Email notification
    public function toMail($notifiable)
    {
        return (new MailMessage)
                    ->subject('New Message / Response Received')
                    ->line($this->message)
                    ->action('View', $this->link ?? url('/'))
                    ->line('Thank you for using our portal!');
    }

    // Database notification
    public function toArray($notifiable)
    {
        return [
            'message' => $this->message,
            'link' => $this->link,
        ];
    }
}
