<?php

namespace template\Http\Controllers\Customer\Users;

use template\Infrastructure\Contracts\Controllers\ControllerAbstract;
use template\Http\Request\Customer\Users\Profiles\ProfileFormRequest;
use template\Domain\Users\Profiles\Repositories\ProfilesRepositoryEloquent;
use template\Domain\Users\Users\User;

class ProfilesController extends ControllerAbstract
{

    /**
     * @var ProfilesRepositoryEloquent|null
     */
    protected $r_profiles = null;

    /**
     * ProfilesController constructor.
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
            'customer.users.profiles.edit',
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

        return redirect(route('customer.users.profiles.edit', ['id' => $user->uniqid]));
    }
}
