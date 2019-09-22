<?php namespace obsession\Http\Controllers\Auth;

use Illuminate\Foundation\Auth\ResetsPasswords;
use obsession\Domain\Users\Users\Repositories\UsersResetPasswordRepositoryEloquent;
use obsession\Infrastructure\Contracts\Controllers\ControllerAbstract;
use obsession\Http\Controllers\Auth\AuthRedirectTrait;

class ResetPasswordController extends ControllerAbstract
{

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

    use ResetsPasswords;
    use AuthRedirectTrait;

    /**
     * @var UsersResetPasswordRepositoryEloquent|null
     */
    protected $r_users = null;

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
