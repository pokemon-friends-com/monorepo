<?php namespace obsession\Http\Controllers\OAuth;

use Illuminate\Auth\Events\Registered;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Http\Request;
use obsession\Domain\Users\Users\Repositories\UsersRepositoryEloquent;
use obsession\Domain\Users\Users\User;
use obsession\Http\Controllers\OAuth\LoginResponseTrait;
use obsession\Infrastructure\Contracts\Controllers\ControllerAbstract;

class RegisterController extends ControllerAbstract
{

    use LoginResponseTrait;
    use RegistersUsers;

    /**
     * @var UsersRepositoryEloquent|null
     */
    protected $r_users = null;

    /**
     * RegisterController constructor.
     *
     * @param UsersRepositoryEloquent $r_users
     */
    public function __construct(UsersRepositoryEloquent $r_users)
    {
        $this->before();
        $this->r_users = $r_users;
    }

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
     */
    protected function create(array $data)
    {
        return $this
            ->r_users
            ->registerUser(
                $data['civility'],
                $data['first_name'],
                $data['last_name'],
                $data['email'],
                $data['password']
            );
    }
}
