<?php

namespace template\Http\Controllers\Anonymous\Users;

use Illuminate\Support\Collection;
use template\Domain\Users\Profiles\Presenters\ProfilesListPresenter;
use template\Domain\Users\Profiles\Profile;
use template\Domain\Users\Profiles\Repositories\ProfilesRepositoryEloquent;
use template\Infrastructure\Contracts\Controllers\ControllerAbstract;

class UsersController extends ControllerAbstract
{

    /**
     * @var ProfilesRepositoryEloquent
     */
    protected $r_profile;

    /**
     * UsersController constructor.
     *
     * @param ProfilesRepositoryEloquent $r_profile
     */
    public function __construct(ProfilesRepositoryEloquent $r_profile)
    {
        $this->r_profile = $r_profile;
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function dashboard()
    {
        return view(
            'anonymous.users.users.dashboard',
            [
                'metadata' => [
                    'title' => 'Template www',
                ],
            ]
        );
    }
}
