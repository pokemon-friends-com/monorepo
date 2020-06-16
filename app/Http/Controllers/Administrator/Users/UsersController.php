<?php

namespace template\Http\Controllers\Administrator\Users;

use Carbon\Carbon;
use League\Csv\Writer;
use Illuminate\Support\Facades\Auth;
use template\Domain\Users\Profiles\Repositories\ProfilesRepositoryEloquent;
use template\Domain\Users\Users\User;
use template\Infrastructure\Contracts\Controllers\ControllerAbstract;
use template\Http\Request\Administrator\Users\Users\
{
    UserUpdateFormRequest,
    UsersFiltersFormRequest
};
use template\Domain\Users\Users\Repositories\UsersRepositoryEloquent;

class UsersController extends ControllerAbstract
{

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
     * @param ProfilesRepositoryEloquent $rProfiles
     */
    public function __construct(
        UsersRepositoryEloquent $rUsers,
        ProfilesRepositoryEloquent $rProfiles
    ) {
        $this->rUsers = $rUsers;
        $this->rProfiles = $rProfiles;
    }

    /**
     * Current user dashboard.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View|void
     */
    public function dashboard()
    {
        return view('administrator.users.users.dashboard');
    }

    /**
     * Display list of resources.
     *
     * @param UsersFiltersFormRequest $request
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Exception
     */
    public function index(UsersFiltersFormRequest $request)
    {
        $f_email = $request->get('email');
        $f_full_name = $request->get('full_name');
        $users = $this
            ->rUsers
            ->filterByEmail($f_email)
            ->filterByName($f_full_name)
            ->getPaginatedUsers();

        return view(
            'administrator.users.users.index',
            compact('users', 'f_email', 'f_full_name')
        );
    }

    /**
     * Display the specified resource.
     *
     * @param User $user
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Exception
     */
    public function show(User $user)
    {
        $user = $this->rUsers->getUser($user->id);

        return view(
            'administrator.users.users.show',
            compact('user')
        );
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        return view(
            'administrator.users.users.create',
            [
                'civilities' => $this->rUsers->getCivilities(),
                'roles' => $this->rUsers->getRoles(),
                'locales' => $this->rUsers->getLocales(),
                'locale' => User::DEFAULT_LOCALE,
                'timezones' => $this->rUsers->getTimezones(),
                'timezone' => User::DEFAULT_TZ,
            ]
        );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param UserUpdateFormRequest $request
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function store(UserUpdateFormRequest $request)
    {
        $this
            ->rUsers
            ->createUser(
                $request->get('civility'),
                $request->get('first_name'),
                $request->get('last_name'),
                $request->get('email'),
                $request->get('role'),
                $request->get('locale'),
                $request->get('timezone')
            );

        return redirect(route('administrator.users.index'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param User $user
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Exception
     */
    public function edit(User $user)
    {
        $user = $this->rUsers->getUser($user->id);

        return view(
            'administrator.users.users.edit',
            [
                'user' => $user,
                'roles' => $this->rUsers->getRoles(),
                'civilities' => $this->rUsers->getCivilities(),
                'locales' => $this->rUsers->getLocales(),
                'timezones' => $this->rUsers->getTimezones(),
                'teams' => $this->rProfiles->getTeamsColors(),
                'families_situations' => $this
                    ->rProfiles
                    ->getFamilySituations()
                    ->mapWithKeys(function ($item) {
                        return [
                            $item => trans("users.profiles.family_situation.{$item}")
                        ];
                    }),
            ]
        );
    }

    /**
     * Update the specified resource in storage.
     *
     * @param User $user
     * @param UserUpdateFormRequest $request
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function update(User $user, UserUpdateFormRequest $request)
    {
        $redirectTo = redirect(route('administrator.users.index'));

        try {
            $this
                ->rUsers
                ->update(
                    [
                        'role' => $request->get('role'),
                        'civility' => $request->get('civility'),
                        'first_name' => $request->get('first_name'),
                        'last_name' => $request->get('last_name'),
                        'email' => $request->get('email'),
                        'locale' => $request->get('locale'),
                        'timezone' => $request->get('timezone'),
                    ],
                    $user->id
                )
                ->updateProfile([
                    'birth_date' => $request->has('birth_date')
                        ? Carbon::createFromFormat(
                            trans('global.date_format'),
                            $request->get('birth_date')
                        )->format('Y-m-d')
                        : null,
                    'family_situation' => $request->get('family_situation'),
                    'maiden_name' => $request->get('maiden_name'),
                    'friend_code' => $request->get('friend_code'),
                    'team_color' => $request->get('team_color'),
                ]);
        } catch (\Prettus\Validator\Exceptions\ValidatorException $exception) {
            app('sentry')->captureException($exception);
            $redirectTo->withException($exception);
        }

        return $redirectTo;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param User $user
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function destroy(User $user)
    {
        if ($this->rUsers->isUserDeletingHisAccount(Auth::user(), $user)) {
            return redirect(route('administrator.users.index'));
        }

        $this->rUsers->delete($user->id);

        return redirect(route('administrator.users.index'));
    }

    /**
     * Export filtered resources.
     *
     * @param UsersFiltersFormRequest $request
     *
     * @throws \League\Csv\CannotInsertRecord
     * @throws \League\Csv\Exception
     */
    public function export(UsersFiltersFormRequest $request)
    {
        $f_email = $request->get('email');
        $f_full_name = $request->get('full_name');
        $fileName = trans('users.export_sheet_title', [
            'date' => date('Y-m-d_H-i')
        ]);

        $this
            ->rUsers
            ->filterByEmail($f_email)
            ->filterByName($f_full_name);

        $csv = Writer::createFromFileObject(new \SplTempFileObject(128));
        $csv->setDelimiter(';');
        $csv->chunk(1024);
        $csv->insertOne([
            trans('global.id'),
            trans('users.civility'),
            trans('users.last_name'),
            trans('users.first_name'),
            trans('users.profiles.family_situation'),
            trans('users.profiles.maiden_name'),
            trans('users.profiles.birth_date'),
            trans('users.email'),
            trans('users.role'),
            trans('users.locale'),
            trans('users.timezone'),
        ]);

        $callback = function () use ($csv) {
            $this
                ->rUsers
                ->chunk(100, function ($users) use ($csv) {
                    $users->each(function ($model) use ($csv) {
                        $csv->insertOne([
                            $model->uniqid,
                            trans('users.civility.' . $model->civility),
                            $model->last_name,
                            $model->first_name,
                            trans('profiles.family_situation.' . $model->profile->family_situation),
                            $model->profile->maiden_name,
                            is_null($model->profile->birth_date_carbon)
                                ?: $model
                                ->profile
                                ->birth_date_carbon
                                ->format(trans('global.date_format')),
                            $model->email,
                            trans('users.role.' . $model->role),
                            $model->locale,
                            $model->timezone,
                        ]);
                    });

                    echo $csv->getContent();
                    flush();
                });
        };

        return response()->streamDownload($callback, $fileName);
    }
}
