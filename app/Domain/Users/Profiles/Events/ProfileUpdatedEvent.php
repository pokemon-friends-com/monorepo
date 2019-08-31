<?php

namespace obsession\Domain\Users\Profiles\Events;

use obsession\Infractucture\Contracts\Events\EventAbstract;
use obsession\Domain\Users\Profiles\Profile;

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
