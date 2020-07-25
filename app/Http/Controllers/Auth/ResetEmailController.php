<?php

namespace pkmnfriends\Http\Controllers\Auth;

use pkmnfriends\Infrastructure\Contracts\Controllers\ControllerAbstract;
use Yaquawa\Laravel\EmailReset\ResetEmail;

class ResetEmailController extends ControllerAbstract
{
    use ResetEmail;

    /**
     * This method will be called if the token is invalid.
     * Should return a response that representing the token is invalid.
     *
     * @param $status
     *
     * @return mixed
     */
    protected function sendResetFailedResponse(string $status)
    {
        abort(404);

        return false;
    }

    /**
     * This method will be called if the token is valid.
     * New email will be set for the user.
     * Should return a response that representing the email reset has succeeded.
     *
     * @param $status
     *
     * @return mixed
     */
    protected function sendResetResponse(string $status)
    {
        return redirect(route('anonymous.dashboard'))
            ->with('message-success', trans('auth.message_email_changed'));
    }
}
