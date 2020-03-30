<?php

namespace template\Http\Controllers\Customer\Users;

use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\ResetsPasswords;
use template\Domain\Users\Profiles\Repositories\ProfilesRepositoryEloquent;
use template\Domain\Users\Users\User;
use template\Http\Request\Customer\Users\Profiles\ProfileFormRequest;
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
     * @param User $user
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Exception
     */
    public function edit(User $user)
    {
        return view(
            'customer.users.users.edit',
            [
                'profile' => $this->r_profiles->getUserProfile($user),
                'teams' => $this->r_profiles->getTeamsColors(),
                'families_situations' => $this
                    ->r_profiles
                    ->getFamilySituations()
                    ->mapWithKeys(function ($item) {
                        return [$item => trans("users.profiles.family_situation.{$item}")];
                    }),
                'timezones' => $this->r_profiles->getTimezones(),
                'locales' => $this->r_profiles->getLocales(),
                'civilities' => $this->r_profiles->getCivilities(),
            ]
        );
    }

    /**
     * Update the specified resource in storage.
     *
     * @param User $user
     * @param ProfileFormRequest $request
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function update(User $user, ProfileFormRequest $request)
    {
        $this->r_profiles->updateUserProfileWithRequest($request, $user);

        return redirect(route('customer.users.edit', ['id' => $user->uniqid]));
    }

    /**
     * @param Request $request
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function dashboard(Request $request)
    {
        return view('customer.users.users.dashboard');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param User $user
     * @param PasswordFormRequest $request
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function password(User $user, PasswordFormRequest $request)
    {
        $this->resetPassword($user, $request->get('password'));

        event(new PasswordReset($user));

        return redirect(route('customer.users.edit', ['id' => $user->uniqid]));
    }
}
