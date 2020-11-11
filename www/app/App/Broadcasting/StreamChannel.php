<?php

namespace pkmnfriends\App\Broadcasting;

use pkmnfriends\Domain\Users\Users\User;

class StreamChannel
{

    /**
     * Authenticate the user's access to the channel.
     *
     * @param  \pkmnfriends\Domain\Users\Users\User  $user
     * @return array|bool
     */
    public function join(User $user)
    {
        return true;
    }
}
