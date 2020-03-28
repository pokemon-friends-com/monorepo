<?php

namespace template\Domain\Users\Users\Repositories;

use Illuminate\Support\Facades\Validator;
use Illuminate\Contracts\Validation\Validator as ContractsValidator;
use template\Infrastructure\Interfaces\Domain\Users\Users\UserCivilitiesInterface;
use template\Domain\Users\Users\{
    User,
    Repositories\UsersRegistrationsRepositoryInterface
};

class UsersRegistrationsRepositoryEloquent extends UsersRepositoryEloquent implements
    UsersRegistrationsRepositoryInterface
{

    /**
     * @var array
     */
    protected $registrationRules = [
        'civility' => 'in:'
            . User::CIVILITY_MADAM . ','
            . User::CIVILITY_MISS . ','
            . User::CIVILITY_MISTER,
        'first_name' => 'max:100',
        'last_name' => 'max:100',
        'friend_code' => 'required|min:12|max:12',
        'email' => 'required|email|max:80|unique:users',
        'password' => 'required|confirmed|min:8',
    ];

    /**
     * {@inheritdoc}
     */
    public function registrationValidator(array $data): ContractsValidator
    {
        $rules = $this->registrationRules;
        $rules['g-recaptcha-response'] = 'required';

        if (
            app()->environment('local')
            || app()->environment('testing')
        ) {
            unset($rules['g-recaptcha-response']);
        }

        return Validator::make($data, $rules);
    }

    /**
     * {@inheritdoc}
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function registerUser(
        string $email,
        string $password,
        string $civility = UserCivilitiesInterface::CIVILITY_MADAM,
        string $first_name = null,
        string $last_name = null,
        string $locale = User::DEFAULT_LOCALE,
        string $timezone = User::DEFAULT_TZ
    ): User {
        return $this
            ->create(
                [
                    'civility' => $civility,
                    'first_name' => $first_name,
                    'last_name' => $last_name,
                    'email' => $email,
                    'role' => User::ROLE_CUSTOMER,
                    'password' => bcrypt($password),
                    'locale' => $locale,
                    'timezone' => $timezone,
                ]
            )
            ->addProfile();
    }
}
