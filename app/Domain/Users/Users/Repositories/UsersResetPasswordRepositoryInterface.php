<?php

namespace template\Domain\Users\Users\Repositories;

use template\Infrastructure\Interfaces\Repositories\RepositoryInterface;

interface UsersResetPasswordRepositoryInterface extends RepositoryInterface
{

    /**
     * @return array
     */
    public function getResetPasswordRules(): array;
}
