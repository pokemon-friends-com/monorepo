<?php namespace obsession\Http\Controllers\Ajax\Users;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use obsession\Domain\Users\Users\User;
use obsession\Infrastructure\Contracts\Controllers\ControllerAbstract;
use obsession\Http\Request\Ajax\Users\
{
    Users\UsersAjaxList,
    Users\CheckUserEmailFormRequest
};
use obsession\Domain\Users\Users\Repositories\UsersRepositoryEloquent;

class UsersController extends ControllerAbstract
{

    /**
     * @var UsersRepositoryEloquent|null
     */
    protected $r_users = null;

    /**
     * @param UsersRepositoryEloquent $r_users
     */
    public function __construct(UsersRepositoryEloquent $r_users)
    {
        $this->r_users = $r_users;

        $this->before();
    }

    /**
     * Get an users list.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(UsersAjaxList $request)
    {
        if (
            Gate::allows(User::ROLE_CUSTOMER, Auth::user())
            || Gate::allows(User::ROLE_ADMINISTRATOR, Auth::user())
        ) {
            return abort(403);
        }

        $users = $this->r_users->getPaginatedAndFilteredUsers($request);

        return response()->json($users);
    }

    /**
     * Get an users list filtered by FormRequest.
     *
     * @param CheckUserEmailFormRequest $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function checkUserEmail(CheckUserEmailFormRequest $request)
    {
        $data = [];

        try {
            $data = $this->r_users->isUserEmailExists($request);
        } catch (\Prettus\Repository\Exceptions\RepositoryException $exception) {
            app('sentry')->captureException($exception);
        }

        return response()->json($data);
    }
}
