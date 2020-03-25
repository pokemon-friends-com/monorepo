<?php

namespace template\Domain\Users\Users\Events;

use template\Infrastructure\Contracts\Events\EventAbstract;
use template\Domain\Users\Users\User;

class UserTriedToDeleteHisOwnAccountEvent extends EventAbstract
{

    /**
     * The current user.
     *
     * @var User|null
     */
    public $user = null;

    /**
     * TrainingCreatedEvent constructor.
     *
     * @param User $training
     */
    public function __construct(User $user)
    {
        $this->user = $user;
    }
}
