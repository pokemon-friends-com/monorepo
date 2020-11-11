<?php

namespace pkmnfriends\Domain\Users\Users\Events;

use pkmnfriends\Infrastructure\Contracts\Events\EventAbstract;
use pkmnfriends\Domain\Users\Users\User;

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
