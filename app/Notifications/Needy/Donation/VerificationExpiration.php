<?php

namespace App\Notifications\Needy\Donation;

use App\Models\DonationRequest;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class VerificationExpiration extends Notification implements ShouldQueue
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
            ->line('Your donation request with title (' . $this->donationRequest->title . ') has successfully reached donation target amount.')
            ->line('In order to ensure you are not a scammer that trying to take advantage of our application, 
            you must verify your donation at ' . $this->donationRequest->verification_expiry_at . ' request by providing some 
            prove of your request (receipt, transaction history, etc)
            and send it through this email go.sedekah0711@gmail.com.'
            )
            ->line('if you fail to provide required prove within that duration, you account privelage to make donation request will be taken.')
            ->line('Thank you for using our application!');
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
