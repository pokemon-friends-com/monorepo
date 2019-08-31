<?php namespace obsession\App\Notifications\Channels;

use Illuminate\Notifications\Notification;

class AdministratorMailableChannel implements MailableChannelInterface
{

    /**
     * Send the given notification.
     *
     * @param  mixed $notifiable
     * @param  \Illuminate\Notifications\Notification $notification
     *
     * @return void
     */
    public function send($notifiable, Notification $notification)
    {
        $notification
            ->toAdministrator($notifiable)
            ->to(
                config('mail.from.address'),
                config('mail.from.name')
            )
            ->from(
                config('mail.from.address'),
                config('mail.from.name')
            )
            ->send(app('mailer'));
    }
}
