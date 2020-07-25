<?php

namespace pkmnfriends\Infrastructure\Interfaces\App\Notifications\Channels;

use pkmnfriends\Infrastructure\Contracts\Notifications\Notification;

interface MailableChannelInterface
{

    /**
     * Send the given notification.
     *
     * @param  mixed $notifiable
     * @param  Notification $notification
     */
    public function send($notifiable, Notification $notification);
}
