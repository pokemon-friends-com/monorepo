<?php

namespace pkmnfriends\Domain\Users\Users\Repositories;

use pkmnfriends\Infrastructure\Interfaces\Repositories\RepositoryInterface;

interface UsersResetPasswordRepositoryInterface extends RepositoryInterface
{

    /**
     * @return array
     */
    public function getResetPasswordRules(): array;
}
