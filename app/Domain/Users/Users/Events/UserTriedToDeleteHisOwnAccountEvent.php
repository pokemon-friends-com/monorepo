<?php

namespace obsession\Domain\Users\Users\Events;

use obsession\Infractucture\Contracts\Events\EventAbstract;
use obsession\Domain\Users\Users\User;

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
