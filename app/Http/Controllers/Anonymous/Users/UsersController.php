<?php

namespace template\Http\Controllers\Anonymous\Users;

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
     * Display anonymous users dashboard.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function dashboard()
    {
        return view(
            'anonymous.users.users.dashboard',
            [
                'metadata' => [
                    'title' => config('app.name'),
                    'description' => config('app.description'),
                ],
            ]
        );
    }

    /**
     * Display users terms.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function terms()
    {
        return view('anonymous.users.users.terms', [
            'metadata' => [
                'title' => trans('users.terms'),
                'description' => trans('users.anonymous.meta.description_terms'),
            ],
        ]);
    }
}
