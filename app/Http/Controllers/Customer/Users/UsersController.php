<?php

namespace pkmnfriends\Http\Controllers\Customer\Users;

use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\ResetsPasswords;
use Illuminate\Support\Facades\Auth;
use pkmnfriends\Domain\Users\Profiles\Repositories\ProfilesRepositoryEloquent;
use pkmnfriends\Domain\Users\Users\Repositories\UsersRepositoryEloquent;
use pkmnfriends\Domain\Users\Users\Transformers\TrainerTransformer;
use pkmnfriends\Domain\Users\Users\User;
use pkmnfriends\Http\Request\Customer\Users\Profiles\ProfileFormRequest;
use pkmnfriends\Http\Request\Customer\Users\Users\PasswordFormRequest;
use pkmnfriends\Http\Request\Customer\Users\Users\ChangeEmailFormRequest;
use pkmnfriends\Infrastructure\Contracts\Controllers\ControllerAbstract;

class UsersController extends ControllerAbstract
{
    use ResetsPasswords;

    /**
     * @var UsersRepositoryEloquent
     */
    protected $rUsers;

    /**
     * @var ProfilesRepositoryEloquent
     */
    protected $rProfiles;

    /**
     * UsersController constructor.
     *
     * @param UsersRepositoryEloquent $rUsers
     */
    public function __construct(
        UsersRepositoryEloquent $rUsers,
        ProfilesRepositoryEloquent $rProfiles
    ) {
        $this->rUsers = $rUsers;
        $this->rProfiles = $rProfiles;
    }

    /**
     * @param User $user
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Exception
     */
    public function edit(User $user)
    {
        $profile = $this->rProfiles->getUserProfile($user);
        $teams = $this->rProfiles->getTeamsColors();
        $families_situations = $this
            ->rProfiles
            ->getFamilySituations()
            ->mapWithKeys(function ($item) {
                return [$item => trans("users.profiles.family_situation.{$item}")];
            });
        $timezones = $this->rUsers->getTimezones();
        $locales = $this->rUsers->getLocales();
        $civilities = $this
            ->rUsers
            ->getCivilities()
            ->mapWithKeys(function ($item) {
                return [$item => trans("users.civility.{$item}")];
            });

        return view('customer.users.users.edit', compact(
            'profile',
            'teams',
            'families_situations',
            'timezones',
            'locales',
            'civilities',
        ));
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
        $this->rProfiles->updateUserProfileWithRequest($request, $user);

        return redirect(route('customer.users.edit', ['user' => $user->uniqid]));
    }

    /**
     * @param Request $request
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function dashboard(Request $request)
    {
        $users = $this->rUsers->getTrainers(false)->paginate(12);
        $user = (new TrainerTransformer())->transform(Auth::user());

        return view('customer.users.users.dashboard', compact(
            'users',
            'user',
        ));
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

        return redirect(route('customer.users.edit', ['user' => $user->uniqid]));
    }

    /**
     * Request email update.
     *
     * @param User $user
     * @param ChangeEmailFormRequest $request
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function email(User $user, ChangeEmailFormRequest $request)
    {
        $user->resetEmail($request->get('email'));

        return redirect(route('customer.users.edit', ['user' => $user->uniqid]))
            ->with('message-success', trans('auth.message_email_validation'));
    }
}
