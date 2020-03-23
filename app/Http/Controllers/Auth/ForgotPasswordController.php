<?php

namespace template\Http\Controllers\Auth;

use GuzzleHttp\Client as GuzzleHttpClient;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;
use Illuminate\Http\Request;
use template\Infrastructure\Contracts\Controllers\ControllerAbstract;

class ForgotPasswordController extends ControllerAbstract
{
    use SendsPasswordResetEmails;

    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset emails and
    | includes a trait which assists in sending these notifications from
    | your application to your users. Feel free to explore this trait.
    |
    */

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Validate the email for the given request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return void
     */
    protected function validateEmail(Request $request)
    {
        $rules = [
            'email' => 'required|email',
            'g-recaptcha-response' => 'required',
        ];

        if (
            app()->environment('local')
            || app()->environment('testing')
        ) {
            unset($rules['g-recaptcha-response']);
        } else {
            $remoteUrl = sprintf(
                'https://www.google.com/recaptcha/api/siteverify?secret=%s&response=%s&remoteip=%s',
                config('services.google_recaptcha.serverkey'),
                $request->get('g-recaptcha-response'),
                $_SERVER['REMOTE_ADDR']
            );

            $response = (new GuzzleHttpClient())
                ->request('GET', $remoteUrl);

            if (200 !== $response->getStatusCode()) {
                abort(403, 'Recaptcha verification failed!');
            }
        }

        $request->validate($rules);
    }
}
