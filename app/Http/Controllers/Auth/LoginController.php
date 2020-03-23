<?php

namespace template\Http\Controllers\Auth;

use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;
use template\Infrastructure\Contracts\Controllers\ControllerAbstract;
use template\Domain\Users\ProvidersTokens\Repositories\ProvidersTokensRepositoryEloquent;
use template\Domain\Users\Users\Repositories\UsersRepositoryEloquent;

class LoginController extends ControllerAbstract
{
    use AuthenticatesUsers;
    use AuthRedirectTrait;

    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles \Authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    /**
     * @var UsersRepositoryEloquent|null
     */
    protected $r_users = null;

    /**
     * @var ProvidersTokensRepositoryEloquent|null
     */
    protected $r_providers_tokens = null;

    /**
     * LoginController constructor.
     *
     * @param UsersRepositoryEloquent $r_users
     * @param ProvidersTokensRepositoryEloquent $r_providers_tokens
     */
    public function __construct(
        UsersRepositoryEloquent $r_users,
        ProvidersTokensRepositoryEloquent $r_providers_tokens
    ) {
        $this->middleware('guest', [
            'except' => [
                'logout',
                'redirectToProvider',
                'handleProviderCallback',
            ],
        ]);

        $this->r_users = $r_users;
        $this->r_providers_tokens = $r_providers_tokens;
    }

    /**
     * Validate the user login request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return void
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    protected function validateLogin(Request $request)
    {
        $request->validate([
            $this->username() => 'required|string',
            'password' => 'required|string',
        ]);
    }

    /**
     * The user has been authenticated.
     *
     * @param  Request $request
     * @param  mixed $user
     *
     * @return mixed
     */
    protected function authenticated(Request $request, $user)
    {
        $this->r_users->refreshSession($user);

        return redirect()->intended($this->redirectTo());
    }

    /**
     * Redirect the user to the OAuth Provider.
     *
     * @param $provider
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function redirectToProvider($provider)
    {
        try {
            return Socialite::driver($provider)->redirect();
        } catch (\InvalidArgumentException $exception) {
            app('sentry')->captureException($exception);

            return redirect(route('anonymous.dashboard'))
                ->with(
                    'message-error',
                    sprintf(
                        trans('auth.link_provider_failed'),
                        ucfirst(strtolower($provider))
                    )
                );
        }
    }

    /**
     * Obtain the user information from provider if user exists.
     * No registration here, login only.
     *
     * @param $provider
     *
     * @return \Illuminate\Routing\Redirector|\Illuminate\Http\RedirectResponse
     */
    public function handleProviderCallback($provider)
    {
        $providerUser = null;

        try {
            $providerUser = Socialite::driver($provider)->user();
        } catch (\InvalidArgumentException $exception) {
            app('sentry')->captureException($exception);

            return redirect(route('anonymous.dashboard'))
                ->with(
                    'message-error',
                    sprintf(
                        trans('auth.link_provider_failed'),
                        ucfirst(strtolower($provider))
                    )
                );
        }

        if (!empty($providerUser) && Auth::check()) {
            $isTokenAvailableForUser = $this
                ->r_providers_tokens
                ->checkIfTokenIsAvailableForUser(
                    Auth::user(),
                    $providerUser->id,
                    $provider
                );

            if ($isTokenAvailableForUser) {
                $this
                    ->r_providers_tokens
                    ->saveUserTokenForProvider(
                        Auth::user(),
                        $provider,
                        $providerUser->id,
                        $providerUser->token
                    );

                return redirect($this->redirectTo())
                    ->with(
                        'message-success',
                        sprintf(
                            trans('auth.link_provider_success'),
                            ucfirst(strtolower($provider))
                        )
                    );
            }

            return redirect($this->redirectTo())
                ->with(
                    'message-error',
                    sprintf(
                        trans('auth.link_provider_failed'),
                        ucfirst(strtolower($provider))
                    )
                );
        }

        $providerToken = $this
            ->r_providers_tokens
            ->findUserForProvider($providerUser->id, $provider);

        if (!is_null($providerToken)) {
            $this
                ->r_providers_tokens
                ->update(
                    [
                        'provider_token' => $providerUser->token,
                    ],
                    $providerToken->id
                );

            Auth::login($providerToken->user, true);

            return redirect($this->redirectTo());
        }

        /*
         * @xabe todo : try to link account via provider user mail, create token and login the user
         */

        return redirect(route('login'))
            ->with(
                'message-error',
                sprintf(
                    trans('auth.login_with_provider_failed'),
                    ucfirst(strtolower($provider))
                )
            );
    }
}
