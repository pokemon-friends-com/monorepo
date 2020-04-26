<?php

namespace template\Http\Controllers\OAuth;

use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Validation\ValidationException;
use Illuminate\Http\Request;
use template\Domain\Users\Users\Repositories\UsersRepositoryEloquent;
use template\Infrastructure\Contracts\Controllers\ControllerAbstract;

class LoginController extends ControllerAbstract
{
    use LoginResponseTrait;
    use AuthenticatesUsers;

    /**
     * @var UsersRepositoryEloquent|null
     */
    protected $r_users = null;

    /**
     * LoginController constructor.
     *
     * @param UsersRepositoryEloquent $r_users
     */
    public function __construct(UsersRepositoryEloquent $r_users)
    {
        $this->r_users = $r_users;
    }

    /**
     * Handle a login request to the application.
     *
     * @param Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     * @throws ValidationException
     */
    public function login(Request $request)
    {
        $this->validateLogin($request);

        if ($this->attemptLogin($request)) {
            return $this->sendLoginResponse($request);
        }

        return $this->sendFailedLoginResponse($request);
    }

    /**
     * Send the response after the user was authenticated.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function sendLoginResponse(Request $request)
    {
        $userToken = $request->user()->createToken('Personal Access Token');

        return $this->createLoginResponse($userToken);
    }

    /**
     * Get the failed login response instance.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function sendFailedLoginResponse(Request $request)
    {
        return response()->json(['message' => 'Unauthorized'], 401);
    }

    /**
     * Log the user out of the application.
     *
     * @param Request $request
     *
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     */
    public function logout(Request $request)
    {
        $request->user()->token()->revoke();

        return response(null, 204);
    }
}
