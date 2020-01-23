<?php namespace template\Domain\Users\Users\Repositories;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Validator;
use Illuminate\Contracts\Validation\Validator as ContractsValidator;
use template\Infrastructure\Contracts\
{
    Repositories\RepositoryEloquentAbstract,
    Request\RequestAbstract
};
use template\Domain\Users\Users\{
    Repositories\UsersRepositoryInterface,
    User,
    Criterias\EmailLikeCriteria,
    Criterias\FullNameLikeCriteria,
    Criterias\WhereUniqIdIsCriteria,
    Criterias\WhereUniqIdIsDifferentCriteria,
    Events\UserCreatedEvent,
    Events\UserUpdatedEvent,
    Events\UserDeletedEvent,
    Events\UserRefreshSessionEvent,
    Events\UserTriedToDeleteHisOwnAccountEvent,
    Presenters\UsersListPresenter
};
use template\Domain\Users\Leads\Lead;

class UsersRepositoryEloquent extends RepositoryEloquentAbstract implements UsersRepositoryInterface
{

    /**
     * Specify Model class name.
     *
     * @return string
     */
    public function model(): string
    {
        return User::class;
    }

    /**
     * Create User request and fire event "UserCreatedEvent".
     *
     * @param array $attributes
     *
     * @event template\Domain\Users\Users\Events\UserCreatedEvent
     * @return \template\Domain\Users\Users\User
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function create(array $attributes): User
    {
        if (
            !array_key_exists('uniqid', $attributes)
            || !$attributes['uniqid']
        ) {
            $attributes['uniqid'] = uniqid();
        }

        if (
            !array_key_exists('password', $attributes)
            || !$attributes['password']
        ) {
            // Temporary password.
            $attributes['password'] = bcrypt(md5(uniqid()));
        }

        if (
            !array_key_exists('role', $attributes)
            || !$attributes['role']
        ) {
            $attributes['role'] = User::ROLE_CUSTOMER;
        }

        $user = parent::create($attributes);

        event(new UserCreatedEvent($user));

        return $user;
    }

    /**
     * Update User request and fire event "UserUpdatedEvent".
     *
     * @param array $attributes
     * @param integer $id
     *
     * @event template\Domain\Users\Users\Events\UserUpdatedEvent
     * @return \template\Domain\Users\Users\User
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function update(array $attributes, $id): User
    {
        $user = parent::update($attributes, $id);

        event(new UserUpdatedEvent($user));

        return $user;
    }

    /**
     * Delete User request and fire event "UserDeletedEvent".
     *
     * @param integer $id
     *
     * @event template\Domain\Users\Users\Events\UserDeletedEvent
     * @return \template\Domain\Users\Users\User
     */
    public function delete($id): User
    {
        $user = $this->find($id);

        parent::delete($user->id);

        event(new UserDeletedEvent($user));

        return $user;
    }

    /**
     * @param User $user
     */
    public function refreshSession(User $user): void
    {
        event(new UserRefreshSessionEvent($user));
    }

    /**
     * @return Collection
     */
    public function getRoles(): Collection
    {
        return collect([
            User::ROLE_ADMINISTRATOR => trans('users.role.' . User::ROLE_ADMINISTRATOR),
            User::ROLE_ACCOUNTANT => trans('users.role.' . User::ROLE_ACCOUNTANT),
            User::ROLE_CUSTOMER => trans('users.role.' . User::ROLE_CUSTOMER),
        ]);
    }

    /**
     * @return Collection
     */
    public function getCivilities(): Collection
    {
        return collect([
            User::CIVILITY_MADAM => trans('users.civility.' . User::CIVILITY_MADAM),
            User::CIVILITY_MISS => trans('users.civility.' . User::CIVILITY_MISS),
            User::CIVILITY_MISTER => trans('users.civility.' . User::CIVILITY_MISTER),
        ]);
    }

    /**
     * @return Collection
     */
    public function getLocales(): Collection
    {
        return collect(User::LOCALES);
    }

    /**
     * @return Collection
     */
    public function getTimezones(): Collection
    {
        return collect(timezones());
    }

    /**
     * Get the list of all users, active and soft deleted users.
     *
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public function allWithTrashed()
    {
        return User::withTrashed()->get();
    }

    /**
     * Get only users that was soft deleted.
     *
     * @return Collection
     */
    public function onlyTrashed(): Collection
    {
        return User::onlyTrashed()->get();
    }

    /**
     * Filter users by uniqid.
     *
     * @param string $uniqid The user uniqid
     *
     * @return self
     * @throws \Prettus\Repository\Exceptions\RepositoryException
     */
    public function filterByUniqueId(string $uniqid): self
    {
        if (!is_null($uniqid) && !empty($uniqid)) {
            $this->pushCriteria(new WhereUniqIdIsCriteria($uniqid));
        }

        return $this;
    }

    /**
     * Filter users by uniqid different than the one as argument.
     *
     * @param string $uniqid The user uniqid
     *
     * @return UsersRepositoryEloquent
     * @throws \Prettus\Repository\Exceptions\RepositoryException
     */
    public function filterByUniqueIdDifferentThan(string $uniqid): self
    {
        if (!is_null($uniqid) && !empty($uniqid)) {
            $this->pushCriteria(new WhereUniqIdIsDifferentCriteria($uniqid));
        }

        return $this;
    }

    /**
     *
     * Filter users by name.
     *
     * @param string $name The user last name or lead first name
     *
     * @return UsersRepositoryEloquent
     * @throws \Prettus\Repository\Exceptions\RepositoryException
     */
    public function filterByName(string $name): self
    {
        if (!is_null($name) && !empty($name)) {
            $this->pushCriteria(new FullNameLikeCriteria($name));
        }

        return $this;
    }

    /**
     * Filter users by emails.
     *
     * @param string $email The user email
     *
     * @return UsersRepositoryEloquent
     * @throws \Prettus\Repository\Exceptions\RepositoryException
     */
    public function filterByEmail(string $email): self
    {
        if (!is_null($email) && !empty($email)) {
            $this->pushCriteria(new EmailLikeCriteria($email));
        }

        return $this;
    }

    /**
     * Create a new user.
     *
     * @param string $civility
     * @param string $first_name
     * @param string $last_name
     * @param string $email
     * @param string $role
     * @param string $locale
     * @param string $timezone
     *
     * @return User
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function createUser(
        string $civility,
        string $first_name,
        string $last_name,
        string $email,
        string $role = User::ROLE_CUSTOMER,
        string $locale = User::DEFAULT_LOCALE,
        string $timezone = User::DEFAULT_TZ
    ): User {
        return $this
            ->create(
                [
                    'civility' => $civility,
                    'first_name' => $first_name,
                    'last_name' => $last_name,
                    'email' => $email,
                    'role' => $role,
                    'locale' => $locale,
                    'timezone' => $timezone,
                ]
            )
            ->addProfile()
            ->sendCreatedAccountByAdministratorNotification();
    }

    /**
     * @return array
     * @throws \Exception
     */
    public function getPaginatedUsers(): array
    {
        return $this
            ->with(['lead'])
            ->setPresenter(new UsersListPresenter())
            ->paginate();
    }

    /**
     * @param RequestAbstract $request
     *
     * @return array
     * @throws \Exception
     */
    public function getPaginatedAndFilteredUsers(RequestAbstract $request): array
    {
        return $this
            ->with(['lead'])
            ->setPresenter(new UsersListPresenter())
            ->scopeQuery(function ($model) use ($request) {
                return $model
                    ->where(function ($query) use ($request) {
                        if ($request->has('user_id')) {
                            $query->where('id', '=', $request->get('user_id'));
                        }

                        if ($request->has('users_ids')) {
                            $query->whereIn('id', $request->get('users_ids'));
                        }

                        if ($request->has('term')) {
                            $query->where(function ($query) use ($request) {
                                $query
                                    ->where(
                                        'last_name',
                                        'LIKE',
                                        '%' . $request->get('term') . '%'
                                    )
                                    ->orWhere(
                                        'first_name',
                                        'LIKE',
                                        '%' . $request->get('term') . '%'
                                    )
                                    ->orWhere(
                                        'email',
                                        'LIKE',
                                        '%' . $request->get('term') . '%'
                                    );
                            });
                        }
                    });
            })
            ->paginate();
    }

    /**
     * @param $id
     *
     * @return array
     * @throws \Exception
     */
    public function getUser($id): array
    {
        return $this
            ->with(['lead'])
            ->setPresenter(new UsersListPresenter())
            ->find($id);
    }

    /**
     * @param User $currentUser
     * @param User $user
     *
     * @return bool
     */
    public function isUserDeletingHisAccount(
        User $currentUser,
        User $user
    ): bool {
        $isUserDeletingHisAccount = $user->id === $currentUser->id;

        if ($isUserDeletingHisAccount) {
            event(new UserTriedToDeleteHisOwnAccountEvent($currentUser));
        }

        return $isUserDeletingHisAccount;
    }

    /**
     * @param RequestAbstract $request
     *
     * @return array
     * @throws \Prettus\Repository\Exceptions\RepositoryException
     */
    public function isUserEmailExists(RequestAbstract $request)
    {
        $data = ['data' => ['count' => 0]];
        $data['data']['count'] = $this
            ->skipPresenter()
            ->filterByEmail($request->get('email'))
            ->filterByUniqueIdDifferentThan($request->get('not_user_id'))
            ->scopeQuery(function ($model) use ($request) {
                // we need to return trashed items because email field is
                // unique. Like this, we make sure to do not validate an
                // email already existing for a soft deleted user.
                return $model->withTrashed();
            })
            ->count();

        return $data;
    }
}
