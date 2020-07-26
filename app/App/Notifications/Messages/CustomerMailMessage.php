<?php

namespace pkmnfriends\App\Notifications\Messages;

use Illuminate\Notifications\Messages\MailMessage;

class CustomerMailMessage extends MailMessage
{

    /**
     * CustomerMailMessage constructor.
     */
    public function __construct()
    {
        $this
            ->from(
                config('mail.from.address'),
                config('mail.from.name')
            );
    }
}
