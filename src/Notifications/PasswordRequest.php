<?php

namespace Joesama\Profile\Notifications;

use Throwable;
use Carbon\Carbon;
use Illuminate\Support\Str;
use Illuminate\Bus\Queueable;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\Config;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class PasswordRequest extends Notification
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
                    ->subject(Str::title(config('app.name')) .' : '. __('profile::forgot.email.subject'))
                    ->success()
                    ->line(__('profile::forgot.request') . ' has success.')
                    ->line('Please use this verification key : ' . $this->profileRequest['key'])
                    ->action(__('profile::forgot.request'), $this->verificationUrl($notifiable))
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
        return URL::temporarySignedRoute(
            'profile.password',
            now()->addMinutes(60),
            [
                'identity' => $notifiable->user_id
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
