<?php

namespace App\Notifications;

use App\Mail\EasyttmMail;
use App\Models\MessageMail;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class EasyTtmNotification extends Notification
{
    use Queueable;

    public MessageMail $message;

    public $url;

    public $path_to_attach = array();

    /**
     * Create a new notification instance.
     */
    public function __construct(MessageMail $message, string $url, array $path_to_attach)
    {
        //
        $this->message = $message;
        $this->url = $url;
        $this->path_to_attach = $path_to_attach;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable)
    {
        return (new EasyttmMail("emmanuelbadibanga250@gmail.com", $this->message, $this->url, $this->path_to_attach))
            ->to($notifiable->email);
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }
}