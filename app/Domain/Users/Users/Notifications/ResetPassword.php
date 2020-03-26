<?php

namespace template\Domain\Users\Users\Notifications;

use template\Infrastructure\Interfaces\Queues\ShouldQueueInterface;
use template\Infrastructure\Contracts\{
    Queues\QueueableTrait,
    Notifications\Notification
};
use template\App\Notifications\Messages\CustomerMailMessage;

class ResetPassword extends Notification
{

    /**
     * The password reset token.
     *
     * @var string
     */
    public $token;

    /**
     * Create a notification instance.
     *
     * @param string $token
     *
     * @return void
     */
    public function __construct($token)
    {
        $this->token = $token;
    }

    /**
     * Get the notification's channels.
     *
     * @param mixed $notifiable
     *
     * @return array|string
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Build the mail representation of the notification.
     *
     * @param mixed $notifiable
     *
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new CustomerMailMessage())
            ->subject(trans('auth.password_reset_title'))
            ->view(
                'emails.users.users.reset_password',
                ['token' => $this->token]
            );
    }
}
