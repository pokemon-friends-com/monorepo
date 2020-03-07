<?php

namespace template\Http\Controllers\Customer\Users;

use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\ResetsPasswords;
use template\Domain\Users\Profiles\Repositories\ProfilesRepositoryEloquent;
use template\Domain\Users\Users\User;
use template\Http\Request\Customer\Users\Users\PasswordFormRequest;
use template\Infrastructure\Contracts\Controllers\ControllerAbstract;

class UsersController extends ControllerAbstract
{
    use ResetsPasswords;

    /**
     * @var null|ProfilesRepositoryEloquent
     */
    protected $r_profiles = null;

    /**
     * UsersController constructor.
     *
     * @param ProfilesRepositoryEloquent $r_profiles
     */
    public function __construct(ProfilesRepositoryEloquent $r_profiles)
    {
        $this->r_profiles = $r_profiles;
    }

    /**
     * @param Request $request
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function dashboard(Request $request)
    {
        return redirect(route('customer.users.profiles.edit', ['user' => $request->user()]));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param User $user
     * @param PasswordFormRequest $request
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function updatePassword(User $user, PasswordFormRequest $request)
    {
        $this->resetPassword($user, $request->get('password'));

        return redirect(route('customer.users.profiles.edit', ['id' => $user->uniqid]));
    }
}
