<?php

namespace template\Domain\Users\Users\Repositories;

use template\Domain\Users\Users\{
    Repositories\UsersResetPasswordRepositoryInterface
};

class UsersResetPasswordRepositoryEloquent extends UsersRepositoryEloquent implements
    UsersResetPasswordRepositoryInterface
{

    /**
     * @var array
     */
    protected $resetPasswordRules = [
        'token' => 'required',
        'email' => 'required|email|max:80',
        'password' => 'required|confirmed|min:8',
    ];

    /**
     * @var array
     */
    protected $changePasswordRules = [
        'current_password' => 'required|validpassword',
        'password' => 'required|confirmed|min:8',
    ];

    /**
     * {@inheritdoc}
     */
    public function getResetPasswordRules(): array
    {
        return $this->resetPasswordRules;
    }

    /**
     * {@inheritdoc}
     */
    public function getChangePasswordRules(): array
    {
        return $this->changePasswordRules;
    }
}
