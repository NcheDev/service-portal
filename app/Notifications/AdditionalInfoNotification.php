<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;

class AdditionalInfoNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public $message;
    public $url;

    public function __construct($message, $url = null)
    {
        $this->message = $message;
        $this->url = $url;
    }

    public function via($notifiable)
    {
        return ['database', 'mail']; // both in-app & email
    }

    public function toArray($notifiable)
    {
        return [
            'message' => $this->message,
            'url'     => $this->url,
        ];
    }

    public function toMail($notifiable)
    {
        return (new \Illuminate\Notifications\Messages\MailMessage)
            ->subject('Additional Information Update')
            ->line($this->message)
            ->action('View Details', $this->url ?? url('/'))
            ->line('Thank you for using our system.');
    }
}
