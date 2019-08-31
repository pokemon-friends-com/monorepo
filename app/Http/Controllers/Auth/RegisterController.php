<?php namespace obsession\Http\Controllers\Auth;

use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use obsession\Domain\Users\Users\Repositories\UsersRepositoryEloquent;
use obsession\Infrastructure\Contracts\Controllers\ControllerAbstract;
use obsession\Http\Controllers\Auth\AuthRedirectTrait;
use obsession\Domain\Users\Users\User;

class RegisterController extends ControllerAbstract
{

    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;
    use AuthRedirectTrait;

    /**
     * @var UsersRepositoryEloquent|null
     */
    protected $r_users = null;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(UsersRepositoryEloquent $r_users)
    {
        $this->middleware('guest');

        $this->r_users = $r_users;
    }

    /**
     * Show the application registration form.
     *
     * @return \Illuminate\Http\Response
     */
    public function showRegistrationForm()
    {
        return view('auth.register', [
            'civilities' => $this->r_users->getCivilities()
        ]);
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
        return Validator::make($data, [
            'civility' => 'required|in:' . User::CIVILITY_MADAM . ',' . User::CIVILITY_MISS . ',' . User::CIVILITY_MISTER,
            'first_name' => 'required|max:100',
            'last_name' => 'required|max:100',
            'email' => 'required|email|max:80|unique:users',
            'password' => 'required|min:6|confirmed',
        ]);
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
