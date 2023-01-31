<?php

namespace App\Notifications\Admin\Donation;

use App\Models\DonationRequest;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class RequestVerificationExpired extends Notification implements ShouldQueue
{
    use Queueable;

    public $donationRequest;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(DonationRequest $donationRequest)
    {
        $this->donationRequest = $donationRequest;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->greeting('Hye ' . $notifiable->name)
            ->line('A donation request called "' . $this->donationRequest->title . '" that belongs to user called ' . $this->donationRequest->user->name .  '(' . $this->donationRequest->user->email . ')' . 'are failed to provide required prove within the dateline.')
            ->line('Hope you can take an action to this user.')
            ->line('Thank you for using contribute in this team!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
