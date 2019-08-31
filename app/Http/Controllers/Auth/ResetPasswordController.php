<?php namespace obsession\Http\Controllers\Auth;

use Illuminate\Foundation\Auth\ResetsPasswords;
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
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }
}
