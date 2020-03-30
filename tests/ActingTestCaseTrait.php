<?php

namespace Tests;

use template\Domain\Users\{
    Users\User,
    Profiles\Profile
};

trait ActingTestCaseTrait
{

    protected function getDefaultPassword(): string
    {
        return 'azerty42';
    }

    protected function getDefaultPasswordBcrypted(): string
    {
        return bcrypt($this->getDefaultPassword());
    }

    /**
     * Acting as logged in administrator user.
     *
     * @return User
     */
    protected function actingAsAdministrator(): User
    {
        return $this->actingAsUser(User::ROLE_ADMINISTRATOR);
    }

    /**
     * Acting as logged in customer user.
     *
     * @return User
     */
    protected function actingAsCustomer(): User
    {
        return $this->actingAsUser(User::ROLE_CUSTOMER);
    }

    /**
     * Acting as logged in user.
     *
     * @param string $role
     *
     * @return User
     */
    protected function actingAsUser(string $role = User::ROLE_CUSTOMER): User
    {
        $user = factory(User::class)->states($role)->create();
        factory(Profile::class)->create(['user_id' => $user->id]);
        $this->actingAs($user);

        return $user;
    }
}
