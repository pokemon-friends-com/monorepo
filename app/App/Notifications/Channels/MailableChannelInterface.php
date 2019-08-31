<?php namespace obsession\App\Notifications\Channels;

use Illuminate\Notifications\Notification;

interface MailableChannelInterface
{

    /**
     * Send the given notification.
     *
     * @param  mixed $notifiable
     * @param  \Illuminate\Notifications\Notification $notification
     */
    public function send($notifiable, Notification $notification);
}
