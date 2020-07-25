<?php

namespace pkmnfriends\Http\Controllers\Auth;

use Illuminate\Foundation\Auth\ResetsPasswords;
use pkmnfriends\Domain\Users\Users\Repositories\UsersResetPasswordRepositoryEloquent;
use pkmnfriends\Infrastructure\Contracts\Controllers\ControllerAbstract;

class ResetPasswordController extends ControllerAbstract
{
    use ResetsPasswords;

    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset requests
    | and uses a simple trait to include this behavior. You're free to
    | explore this trait and override any methods you wish to tweak.
    |
    */

    /**
     * @var UsersResetPasswordRepositoryEloquent
     */
    protected $rUsers;

    /**
     * @var string
     */
    protected $redirectTo = '/';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(UsersResetPasswordRepositoryEloquent $rUsers)
    {
        $this->middleware('guest');
        $this->rUsers = $rUsers;
    }

    /**
     * Get the password reset validation rules.
     *
     * @return array
     */
    protected function rules()
    {
        return $this->rUsers->getResetPasswordRules();
    }
}
