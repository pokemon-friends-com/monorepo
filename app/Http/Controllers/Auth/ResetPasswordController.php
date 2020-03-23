<?php

namespace template\Http\Controllers\Auth;

use Illuminate\Foundation\Auth\ResetsPasswords;
use template\Domain\Users\Users\Repositories\UsersResetPasswordRepositoryEloquent;
use template\Infrastructure\Contracts\Controllers\ControllerAbstract;

class ResetPasswordController extends ControllerAbstract
{
    use ResetsPasswords;
    use AuthRedirectTrait;

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
    protected $r_users;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(UsersResetPasswordRepositoryEloquent $r_users)
    {
        $this->middleware('guest');
        $this->r_users = $r_users;
    }

    /**
     * Get the password reset validation rules.
     *
     * @return array
     */
    protected function rules()
    {
        return $this->r_users->getResetPasswordRules();
    }
}
