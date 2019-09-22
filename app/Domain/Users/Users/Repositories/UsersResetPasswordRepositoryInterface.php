<?php namespace obsession\Domain\Users\Users\Repositories;

use obsession\Infrastructure\Interfaces\Repositories\RepositoryInterface;

interface UsersResetPasswordRepositoryInterface extends RepositoryInterface
{

    /**
     * @return array
     */
    public function getResetPasswordRules(): array;
}
