<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NewBookingNotify extends Notification implements ShouldQueue
{
    use Queueable;

    private $notify_details;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($notify_details)
    {
        $this->notify_details = $notify_details;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param mixed $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail', 'database'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param mixed $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject("New Booking Notify, Booking No: {$this->notify_details['booking_no']}")
            ->greeting($this->notify_details['greeting'])
            ->line($this->notify_details['body'])
            ->action($this->notify_details['actionText'], $this->notify_details['actionURL'])
            ->line($this->notify_details['thanks']);
    }

    /**
     * Get the array representation of the notification.
     *
     * @param mixed $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            'booking_no' => $this->notify_details['booking_no']
        ];
    }
}
