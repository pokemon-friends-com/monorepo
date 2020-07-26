<?php

namespace pkmnfriends\Domain\Users\Profiles\Events;

use pkmnfriends\Infrastructure\Contracts\Events\EventAbstract;
use pkmnfriends\Domain\Users\Profiles\Profile;

class ProfileUpdatedEvent extends EventAbstract
{

    /**
     * @var Profile|null
     */
    public $profile = null;

    /**
     * UserUpdatedEvent constructor.
     *
     * @param Profile $profile
     */
    public function __construct(Profile $profile)
    {
        $this->profile = $profile;
    }
}
