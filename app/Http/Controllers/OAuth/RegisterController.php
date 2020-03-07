<?php

namespace template\Http\Controllers\OAuth;

use Illuminate\Auth\Events\Registered;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Http\Request;
use template\Domain\Users\Users\Repositories\UsersRegistrationsRepositoryEloquent;
use template\Domain\Users\Users\User;
use template\Infrastructure\Contracts\Controllers\ControllerAbstract;

class RegisterController extends ControllerAbstract
{
    use LoginResponseTrait;
    use RegistersUsers;

    /**
     * @var UsersRegistrationsRepositoryEloquent|null
     */
    protected $r_users = null;

    /**
     * RegisterController constructor.
     *
     * @param UsersRegistrationsRepositoryEloquent $r_users
     */
    public function __construct(UsersRegistrationsRepositoryEloquent $r_users)
    {
        $this->r_users = $r_users;
    }

    /**
     * Handle a registration request for the application.
     *
     * @param Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function register(Request $request)
    {
        $this->validator($request->all())->validate();
        $user = $this->create($request->all());
        $userToken = $user->createToken('Personal Access Token');
        event(new Registered($user));

        return $this->createLoginResponse($userToken, 201);
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param array $data
     *
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return $this->r_users->registrationValidator($data);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param array $data
     *
     * @return User
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    protected function create(array $data)
    {
        $user = $this
            ->r_users
            ->registerUser(
                $data['email'],
                $data['password']
            );

        $user->profile->friend_code = $data['friend_code'];
        $user->profile->save();

        return $user;
    }
}
