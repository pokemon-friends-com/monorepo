<?php

namespace pkmnfriends\Domain\Users\Users\Repositories;

use Illuminate\Contracts\Validation\Validator as ContractsValidator;
use pkmnfriends\Infrastructure\Interfaces\Repositories\RepositoryInterface;
use pkmnfriends\Domain\Users\Users\User;

interface UsersRegistrationsRepositoryInterface extends RepositoryInterface
{

    /**
     * Get a validator for an incoming registration request.
     *
     * @param array $data
     *
     * @return ContractsValidator
     */
    public function registrationValidator(array $data): ContractsValidator;

    /**
     * Register a new user.
     *
     * @param string $civility
     * @param string $first_name
     * @param string $last_name
     * @param string $email
     * @param string $password
     * @param string $locale
     * @param string $timezone
     *
     * @return User
     */
    public function registerUser(
        string $civility,
        string $first_name,
        string $last_name,
        string $email,
        string $password,
        string $locale = User::DEFAULT_LOCALE,
        string $timezone = User::DEFAULT_TZ
    ): User;
}
