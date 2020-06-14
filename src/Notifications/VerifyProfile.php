<?php

namespace Joesama\Profile\Notifications;

use Throwable;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\Config;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class VerifyProfile extends Notification
{
    use Queueable;

    /**
     * Request for profile registeration.
     *
     * @var array
     */
    protected $profileRequest;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(array $parameter)
    {
        $this->profileRequest = $parameter;
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
                    ->subject('Profile Verification')
                    ->line('Profile registeration has success. Your profile need to be verified before activated.')
                    ->line('Please use this verification key : ' . $this->profileRequest['password'])
                    ->action('Verify Profile', $this->verificationUrl($notifiable))
                    ->line('Thank you for using our application!');
    }

    /**
     * Get the verification URL for the given notifiable.
     *
     * @param  mixed  $notifiable
     * @return string
     */
    protected function verificationUrl($notifiable)
    {
        return URL::signedRoute(
            'profile.verify',
            [
                'identity' => $this->profileRequest['uuid']
            ]
        );
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
