<?php

namespace template\Domain\Users\Users\Events;

use template\Infrastructure\Contracts\Events\EventAbstract;
use template\Domain\Users\Users\User;

class UserRefreshSessionEvent extends EventAbstract
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
