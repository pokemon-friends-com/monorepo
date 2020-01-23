<?php

namespace template\Http\Controllers\Customer\Users;

use template\Infrastructure\Contracts\Controllers\ControllerAbstract;
use template\Domain\Users\Users\Repositories\UsersRepositoryEloquent;

class UsersController extends ControllerAbstract
{

    /**
     * @var null
     */
    protected $r_users = null;

    /**
     * UsersController constructor.
     *
     * @param UsersRepositoryEloquent $r_users
     */
    public function __construct(UsersRepositoryEloquent $r_users)
    {
        $this->r_users = $r_users;
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View|void
     */
    public function dashboard()
    {
        try {
            return view('customer.users.users.dashboard', []);
        } catch (\Exception $exception) {
            app('sentry')->captureException($exception);
        }

        return abort('404');
    }
}
