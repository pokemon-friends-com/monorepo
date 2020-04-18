<?php

namespace template\Domain\Users\Users\Repositories;

use Illuminate\Support\Collection;
use template\Infrastructure\Contracts\
{
    Repositories\RepositoryEloquentAbstract,
    Request\RequestAbstract
};
use template\Domain\Users\Users\{
    Presenters\TrainerPresenter,
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

class UsersRepositoryEloquent extends RepositoryEloquentAbstract implements UsersRepositoryInterface
{

    /**
     * {@inheritdoc}
     */
    public function model(): string
    {
        return User::class;
    }

    /**
     * {@inheritdoc}
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
     * {@inheritdoc}
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function update(array $attributes, $id): User
    {
        $user = parent::update($attributes, $id);

        event(new UserUpdatedEvent($user));

        return $user;
    }

    /**
     * {@inheritdoc}
     */
    public function delete($id): User
    {
        $user = $this->find($id);

        parent::delete($user->id);

        event(new UserDeletedEvent($user));

        return $user;
    }

    /**
     * {@inheritdoc}
     */
    public function refreshSession(User $user): void
    {
        event(new UserRefreshSessionEvent($user));
    }

    /**
     * {@inheritdoc}
     */
    public function getRoles(): Collection
    {
        return collect(User::ROLES);
    }

    /**
     * {@inheritdoc}
     */
    public function getCivilities(): Collection
    {
        return collect(User::CIVILITIES);
    }

    /**
     * {@inheritdoc}
     */
    public function getLocales(): Collection
    {
        return collect(User::LOCALES);
    }

    /**
     * {@inheritdoc}
     */
    public function getTimezones(): Collection
    {
        return collect(timezones());
    }

    /**
     * {@inheritdoc}
     */
    public function allWithTrashed()
    {
        return User::withTrashed()->get();
    }

    /**
     * {@inheritdoc}
     */
    public function onlyTrashed(): Collection
    {
        return User::onlyTrashed()->get();
    }

    /**
     * {@inheritdoc}
     * @throws \Prettus\Repository\Exceptions\RepositoryException
     */
    public function filterByUniqueId(?string $uniqid): UsersRepositoryInterface
    {
        if (!is_null($uniqid) && !empty($uniqid)) {
            $this->pushCriteria(new WhereUniqIdIsCriteria($uniqid));
        }

        return $this;
    }

    /**
     * {@inheritdoc}
     * @throws \Prettus\Repository\Exceptions\RepositoryException
     */
    public function filterByUniqueIdDifferentThan(?string $uniqid): UsersRepositoryInterface
    {
        if (!is_null($uniqid) && !empty($uniqid)) {
            $this->pushCriteria(new WhereUniqIdIsDifferentCriteria($uniqid));
        }

        return $this;
    }

    /**
     * {@inheritdoc}
     * @throws \Prettus\Repository\Exceptions\RepositoryException
     */
    public function filterByName(?string $name): UsersRepositoryInterface
    {
        if (!is_null($name) && !empty($name)) {
            $this->pushCriteria(new FullNameLikeCriteria($name));
        }

        return $this;
    }

    /**
     * {@inheritdoc}
     * @throws \Prettus\Repository\Exceptions\RepositoryException
     */
    public function filterByEmail(?string $email): UsersRepositoryInterface
    {
        if (!is_null($email) && !empty($email)) {
            $this->pushCriteria(new EmailLikeCriteria($email));
        }

        return $this;
    }

    /**
     * {@inheritdoc}
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
     * {@inheritdoc}
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
     * @param bool $sponsoredOnly
     *
     * @return $this
     */
    public function getTrainers(bool $sponsoredOnly = true): self
    {
        return $this
            ->with('profile')
            ->setPresenter(TrainerPresenter::class)
            ->whereHas('profile', function ($model) use ($sponsoredOnly) {
                if ($sponsoredOnly) {
                    $model->where('sponsored', '=', '1');
                }

                return $model->orderBy('sponsored', 'desc');
            });
    }

    /**
     * {@inheritdoc}
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
     * {@inheritdoc}
     * @throws \Exception
     */
    public function getUser(int $id): array
    {
        return $this
            ->with(['lead', 'profile'])
            ->setPresenter(new UsersListPresenter())
            ->find($id);
    }

    /**
     * {@inheritdoc}
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
     * {@inheritdoc}
     * @throws \Prettus\Repository\Exceptions\RepositoryException
     */
    public function isUserEmailExists(RequestAbstract $request): array
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
