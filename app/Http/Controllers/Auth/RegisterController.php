<?php

namespace template\Http\Controllers\Auth;

use GuzzleHttp\Client as GuzzleHttpClient;
use Illuminate\Auth\Events\Registered;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Http\Request;
use template\Domain\Users\Profiles\Repositories\ProfilesRepositoryEloquent;
use template\Domain\Users\Users\Repositories\UsersRegistrationsRepositoryEloquent;
use template\Infrastructure\Contracts\Controllers\ControllerAbstract;
use template\Domain\Users\Users\User;

class RegisterController extends ControllerAbstract
{
    use RegistersUsers;

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

    /**
     * @var UsersRegistrationsRepositoryEloquent
     */
    protected $rUsers;

    /**
     * @var ProfilesRepositoryEloquent
     */
    protected $rProfiles;

    /**
     * @var string
     */
    protected $redirectTo = '/';

    /**
     * RegisterController constructor.
     *
     * @param UsersRegistrationsRepositoryEloquent $rUsers
     * @param ProfilesRepositoryEloquent $rProfiles
     */
    public function __construct(
        UsersRegistrationsRepositoryEloquent $rUsers,
        ProfilesRepositoryEloquent $rProfiles
    ) {
        $this->middleware('guest');
        $this->rUsers = $rUsers;
        $this->rProfiles = $rProfiles;
    }

    /**
     * Show the application registration form.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function showRegistrationForm()
    {
        return view('auth.register', [
            'civilities' => $this->rUsers->getCivilities(),
        ]);
    }

    /**
     * Handle a registration request for the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function register(Request $request)
    {
        $validator = $this->validator($request->all());

        if ($validator->fails()) {
            return redirect(route('register'))
                ->withErrors($validator)
                ->withInput();
        }

        $user = $this->create($request->all());
        event(new Registered($user));

        $this->guard()->login($user);

        return $this->registered($request, $user)
            ?: redirect($this->redirectPath());
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
        return $this->rUsers->registrationValidator($data);
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
        $profile = $this
            ->rProfiles
            ->findByField('friend_code', $data['friend_code']);

        if ($profile->count() && $profile->first()->is_claimable) {
            return $this
                ->rUsers
                ->update(
                    [
                        'civility' => User::CIVILITY_MADAM,
                        'first_name' => null,
                        'last_name' => null,
                        'role' => User::ROLE_CUSTOMER,
                        'locale' => User::DEFAULT_LOCALE,
                        'timezone' => User::DEFAULT_TZ,
                        'email' => $data['email'],
                        'password' => bcrypt($data['password']),
                    ],
                    $profile->first()->user->id
                );
        }

        $user = $this
            ->rUsers
            ->registerUser(
                $data['email'],
                $data['password']
            );

        $user->profile->friend_code = $data['friend_code'];
        $user->profile->save();

        return $user;
    }
}
