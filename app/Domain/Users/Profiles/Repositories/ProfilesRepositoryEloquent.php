<?php namespace obsession\Domain\Users\Profiles\Repositories;

use Illuminate\Container\Container as Application;
use obsession\Infrastructure\
{
    Contracts\Request\RequestAbstract,
    Contracts\Repositories\RepositoryEloquentAbstract
};
use obsession\Domain\Users\
{
    Profiles\Profile,
    ProfilesEmails\ProfileEmail,
    ProfilesPhones\ProfilePhone,
    Profiles\Events\ProfileUpdatedEvent,
    Profiles\Presenters\ProfilesListPresenter,
    Profiles\Repositories\ProfilesRepository,
    Users\User,
    Users\Repositories\UsersRepositoryEloquent
};
use Carbon\Carbon;

class ProfilesRepositoryEloquent extends RepositoryEloquentAbstract implements ProfilesRepository
{

    /**
     * @var array Family situation available to fill family_situation field in
     *     profiles table.
     */
    protected $family_situations = [
        Profile::FAMILY_SITUATION_SINGLE => 'profiles.family_situation.'.Profile::FAMILY_SITUATION_SINGLE,
        Profile::FAMILY_SITUATION_MARRIED => 'profiles.family_situation.'.Profile::FAMILY_SITUATION_MARRIED,
        Profile::FAMILY_SITUATION_CONCUBINAGE => 'profiles.family_situation.'.Profile::FAMILY_SITUATION_CONCUBINAGE,
        Profile::FAMILY_SITUATION_DIVORCEE => 'profiles.family_situation.'.Profile::FAMILY_SITUATION_DIVORCEE,
        Profile::FAMILY_SITUATION_WIDOW_ER => 'profiles.family_situation.'.Profile::FAMILY_SITUATION_WIDOW_ER,
    ];

    /**
     * @var UsersRepositoryEloquent|null
     */
    protected $r_users = null;

    /**
     * LeadsRepositoryEloquent constructor.
     *
     * @param Application $app
     * @param UsersRepositoryEloquent $r_users
     */
    public function __construct(Application $app, UsersRepositoryEloquent $r_users)
    {
        parent::__construct($app);

        $this->r_users = $r_users;
    }

    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Profile::class;
    }

    /**
     * Create trainer profile.
     *
     * @param array $attributes
     *
     * @event None
     * @return \obsession\Domain\Users\Profiles\Profile
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function create(array $attributes)
    {
        $profile = parent::create($attributes);

        return $profile;
    }

    /**
     * Update trainer profile.
     *
     * @param array $attributes
     * @param integer $id
     *
     * @event ProfileUpdatedEvent
     * @return \obsession\Domain\Users\Profiles\Profile
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function update(array $attributes, $id)
    {
        $profile = parent::update($attributes, $id);

        event(new ProfileUpdatedEvent($profile));

        return $profile;
    }

    /**
     * Delete trainer profile.
     *
     * @param $id
     *
     * @event None
     * @return int
     */
    public function delete($id)
    {
        $profile = parent::delete($id);

        return $profile;
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function getFamilySituationsList()
    {
        return collect($this->family_situations)
            ->map(
                function ($translation_key, $family_situation_key) {
                    return trans($translation_key);
                }
            );
    }

    /**
     * @param User $user
     * @param array $parameters
     * @param array $emails
     * @param array $phones
     * @return User
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function createUserProfile(
        User $user,
        $parameters = [],
        $emails = [],
        $phones = []
    ): User {
        $profile = $this
            ->create(
                array_merge(
                    [
                        'user_id' => $user->id,
                    ],
                    $parameters
                )
            );

        return $user;
    }

    /**
     * @param User $user
     * @param array $parameters
     * @param array $emails
     * @param array $phones
     * @return User
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function updateUserProfile(
        User $user,
        $parameters = [],
        $emails = [],
        $phones = []
    ): User {
        $this->update($parameters, $user->profile->id);

        return $user;
    }

    /**
     * @param User $user
     * @return ProfilesRepositoryEloquent
     */
    public function deleteUserProfile(User $user): self
    {
        $user->profile->delete();

        return $this;
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Exception
     */
    public function backendIndexView()
    {
        $profile = $this->getCurrentUserProfile();

        return view(
            'backend.users.profiles.index',
            [
                'profile' => $profile,
                'families_situations' => $this->getFamilySituationsList(),
                'timezones' => $this->r_users->getTimezones(),
                'locales' => $this->r_users->getLocales(),
            ]
        );
    }

    /**
     * @param RequestAbstract $request
     * @param                 $id
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function backendUpdateWithRedirection(RequestAbstract $request, $id)
    {
        $this->updateUserProfileWithRequest($request, $id);

        return redirect(route('backend.users.profile.index'));
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function accountantIndexView()
    {
        $profile = $this->getCurrentUserProfile();

        return view(
            'accountant.users.profiles.index',
            [
                'profile' => $profile,
                'families_situations' => $this->getFamilySituationsList(),
                'timezones' => $this->r_users->getTimezones(),
                'locales' => $this->r_users->getLocales(),
            ]
        );
    }

    /**
     * @param RequestAbstract $request
     * @param                 $id
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function accountantUpdateWithRedirection(RequestAbstract $request, $id)
    {
        $this->updateUserProfileWithRequest($request, $id);

        return redirect(route('accountant.profile.index'));
    }

    /**
     * @return Profile
     * @throws \Exception
     */
    protected function getCurrentUserProfile()
    {
        return $this
            ->setPresenter(new ProfilesListPresenter())
            ->find(\Auth::user()->profile->id);
    }

    /**
     * @param RequestAbstract $request
     * @param                 $id
     */
    protected function updateUserProfileWithRequest(RequestAbstract $request, $id)
    {
        try {
            $profile = $this
                ->update(
                    [
                        'birth_date' => $request->has('birth_date')
                            ? Carbon::createFromFormat(
                                trans('global.date_format'),
                                $request->get('birth_date')
                            )->format('Y-m-d')
                            : null,
                        'family_situation' => $request->get('family_situation'),
                        'maiden_name' => $request->get('maiden_name'),
                    ],
                    $id
                );

            $user = $this
                ->r_users
                ->update(
                    [
                        'timezone' => $request->get('timezone'),
                        'locale' => $request->get('locale'),
                    ],
                    $profile->user->id
                );

            $this->r_users->refreshSession($user);
        } catch (\Prettus\Validator\Exceptions\ValidatorException $exception) {
            app('sentry')->captureException($exception);
        }
    }
}
