<?php

namespace obsession\Domain\Users\Users\Events;

use obsession\Infractucture\Contracts\Events\EventAbstract;
use obsession\Domain\Users\Users\User;

class UserDeletedEvent extends EventAbstract
{

    /**
     * @var User|null
     */
    public $user = null;

    /**
     * UserUpdatedEvent constructor.
     *
     * @param User $user
     */
    public function __construct(User $user)
    {
        $this->user = $user;
    }
}
