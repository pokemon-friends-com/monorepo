<?php

namespace template\Http\Controllers\Anonymous\Users;

use Illuminate\Support\Facades\Auth;
use Spatie\Honeypot\ProtectAgainstSpam;
use template\Domain\Users\Users\Repositories\UsersRepositoryEloquent;
use template\Domain\Users\Users\Transformers\TrainerTransformer;
use template\Domain\Users\Users\User;
use template\Infrastructure\Contracts\Controllers\ControllerAbstract;

class UsersController extends ControllerAbstract
{

    /**
     * @var UsersRepositoryEloquent
     */
    protected $r_users;

    /**
     * UsersController constructor.
     *
     * @param UsersRepositoryEloquent $r_users
     */
    public function __construct(UsersRepositoryEloquent $r_users)
    {
        $this
            ->middleware(ProtectAgainstSpam::class)
            ->only('index');

        $this->r_users = $r_users;
    }

    /**
     * Display resources list.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $metadata = [
            'title' => trans('users.trainer.meta.title'),
            'description' => config('app.description'),
        ];
        $users = $this->r_users->getTrainers(!Auth::check())->paginate(48);

        return view('anonymous.users.users.index', compact(
            'metadata',
            'users',
        ));
    }

    /**
     * Show the specified resource.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show(User $user)
    {
        if (!$user || $user->deleted_at || !$user->profile || !$user->profile->sponsored) {
            abort(404);
        }

        $metadata = [
            'title' => trans('users.trainer.meta.title'),
            'description' => trans(
                'users.trainer.meta.description',
                [
                    'friend_code' => $user->profile->formated_friend_code
                ]
            ),
        ];
        $friend_code = $user->profile->formated_friend_code;
        $qr = route('v1.users.qr', ['user' => $user->uniqid]);

        return view('anonymous.users.users.show', compact(
            'metadata',
            'friend_code',
            'qr',
        ));
    }

    /**
     * Display users dashboard.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function dashboard()
    {
        $metadata = [
            'title' => config('app.name'),
            'description' => config('app.description'),
        ];
        $users = $this->r_users->getTrainers()->paginate(12);

        return view('anonymous.users.users.dashboard', compact(
            'metadata',
            'users',
        ));
    }

    /**
     * Display users terms.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function terms()
    {
        $metadata = [
            'title' => trans('users.terms'),
            'description' => trans('users.anonymous.meta.description_terms'),
        ];

        return view('anonymous.users.users.terms', compact('metadata'));
    }
}
