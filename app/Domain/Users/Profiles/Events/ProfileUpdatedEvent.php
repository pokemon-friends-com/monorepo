<?php

namespace template\Domain\Users\Profiles\Events;

use template\Infrastructure\Contracts\Events\EventAbstract;
use template\Domain\Users\Profiles\Profile;

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
