<?php

namespace template\Http\Controllers\Anonymous\Users;

use Carbon\Carbon;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Cache;
use template\Domain\Users\Profiles\Repositories\ProfilesRepositoryEloquent;
use template\Domain\Users\Users\User;
use template\Infrastructure\Contracts\Controllers\ControllerAbstract;

class UsersController extends ControllerAbstract
{

    /**
     * @var ProfilesRepositoryEloquent
     */
    protected $r_profiles;

    /**
     * UsersController constructor.
     *
     * @param ProfilesRepositoryEloquent $r_profile
     */
    public function __construct(ProfilesRepositoryEloquent $r_profiles)
    {
        $this->r_profiles = $r_profiles;
    }

    /**
     * Show the specified resource.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show(User $user)
    {
        if (!$user || $user->deleted_at || !$user->profile->sponsored) {
            abort(404);
        }

        return view(
            'anonymous.users.users.show',
            [
                'metadata' => [
                    'title' => trans('users.trainer.meta.title'),
                    'description' => trans(
                        'users.trainer.meta.description',
                        [
                            'friend_code' => $user->profile->formated_friend_code
                        ]
                    ),
                ],
                'friend_code' => $user->profile->formated_friend_code,
                'qr' => route('v1.users.qr', ['user' => $user->uniqid]),
            ]
        );
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
