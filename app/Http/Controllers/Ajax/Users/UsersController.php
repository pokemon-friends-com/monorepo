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
        $this->before();
        $this->middleware('role:customer,administrator');
        $this->r_users = $r_users;
    }

    /**
     * Get an users list.
     *
     * @param UsersAjaxList $request
     *
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function index(UsersAjaxList $request)
    {
        $users = $this->r_users->getPaginatedAndFilteredUsers($request);

        return response()->json($users);
    }

    /**
     * Get an users list filtered by FormRequest.
     *
     * @param CheckUserEmailFormRequest $request
     *
     * @return \Illuminate\Http\JsonResponse
     * @throws \Prettus\Repository\Exceptions\RepositoryException
     */
    public function checkUserEmail(CheckUserEmailFormRequest $request)
    {
        $data = $this->r_users->isUserEmailExists($request);

        return response()->json($data);
    }
}
