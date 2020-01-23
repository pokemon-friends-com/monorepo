<?php namespace template\Domain\Users\Users\Repositories;

use template\Domain\Users\Users\{
    Repositories\UsersResetPasswordRepositoryInterface
};

class UsersResetPasswordRepositoryEloquent extends UsersRepositoryEloquent implements UsersResetPasswordRepositoryInterface
{

    /**
     * @var array
     */
    protected $resetPasswordRules = [
        'token' => 'required',
        'email' => 'required|email|max:80',
        'password' => 'required|min:6|confirmed',
    ];

    /**
     * {@inheritdoc}
     */
    public function getResetPasswordRules(): array
    {
        return $this->resetPasswordRules;
    }
}
