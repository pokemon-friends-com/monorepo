<?php namespace template\Domain\Users\Users\Repositories;

use Illuminate\Support\Facades\Validator;
use Illuminate\Contracts\Validation\Validator as ContractsValidator;
use template\Domain\Users\Users\{
    User,
    Repositories\UsersRegistrationsRepositoryInterface
};

class UsersRegistrationsRepositoryEloquent extends UsersRepositoryEloquent implements UsersRegistrationsRepositoryInterface
{

    /**
     * @var array
     */
    protected $registrationRules = [
        'civility' => 'required|in:' . User::CIVILITY_MADAM . ','
            . User::CIVILITY_MISS . ',' . User::CIVILITY_MISTER,
        'first_name' => 'required|max:100',
        'last_name' => 'required|max:100',
        'email' => 'required|email|max:80|unique:users',
        'password' => 'required|min:6|confirmed',
    ];

    /**
     * {@inheritdoc}
     */
    public function registrationValidator(array $data): ContractsValidator
    {
        return Validator::make($data, $this->registrationRules);
    }

    /**
     * {@inheritdoc}
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function registerUser(
        string $civility,
        string $first_name,
        string $last_name,
        string $email,
        string $password,
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
