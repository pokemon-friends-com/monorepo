<?php

namespace template\Domain\Users\Users\Repositories;

use Illuminate\Support\Collection;
use template\Domain\Users\Users\User;
use template\Infrastructure\Contracts\Request\RequestAbstract;
use template\Infrastructure\Interfaces\Repositories\RepositoryInterface;

interface UsersRepositoryInterface extends RepositoryInterface
{

    /**
     * Create User request and fire event "UserCreatedEvent".
     *
     * @param array $attributes
     *
     * @event template\Domain\Users\Users\Events\UserCreatedEvent
     * @return \template\Domain\Users\Users\User
     */
    public function create(array $attributes): User;

    /**
     * Update User request and fire event "UserUpdatedEvent".
     *
     * @param array $attributes
     * @param integer $id
     *
     * @event template\Domain\Users\Users\Events\UserUpdatedEvent
     * @return \template\Domain\Users\Users\User
     */
    public function update(array $attributes, $id): User;

    /**
     * Delete User request and fire event "UserDeletedEvent".
     *
     * @param integer $id
     *
     * @event template\Domain\Users\Users\Events\UserDeletedEvent
     * @return \template\Domain\Users\Users\User
     */
    public function delete($id): User;

    /**
     * @param User $user
     */
    public function refreshSession(User $user): void;

    /**
     * @return Collection
     */
    public function getRoles(): Collection;

    /**
     * @return Collection
     */
    public function getCivilities(): Collection;

    /**
     * @return Collection
     */
    public function getLocales(): Collection;

    /**
     * @return Collection
     */
    public function getTimezones(): Collection;

    /**
     * Get the list of all users, active and soft deleted users.
     *
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public function allWithTrashed();

    /**
     * Get only users that was soft deleted.
     *
     * @return Collection
     */
    public function onlyTrashed(): Collection;

    /**
     * Filter users by uniqid.
     *
     * @param string|null $uniqid The user uniqid
     *
     * @return self
     */
    public function filterByUniqueId(?string $uniqid): self;

    /**
     * Filter users by uniqid different than the one as argument.
     *
     * @param string|null $uniqid The user uniqid
     *
     * @return UsersRepositoryEloquent
     */
    public function filterByUniqueIdDifferentThan(?string $uniqid): self;

    /**
     *
     * Filter users by name.
     *
     * @param string|null $name The user last name or lead first name
     *
     * @return UsersRepositoryEloquent
     */
    public function filterByName(?string $name): self;

    /**
     * Filter users by emails.
     *
     * @param string|null $email The user email
     *
     * @return UsersRepositoryEloquent
     */
    public function filterByEmail(?string $email): self;

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
     */
    public function createUser(
        string $civility,
        string $first_name,
        string $last_name,
        string $email,
        string $role = User::ROLE_CUSTOMER,
        string $locale = User::DEFAULT_LOCALE,
        string $timezone = User::DEFAULT_TZ
    ): User;

    /**
     * @return array
     */
    public function getPaginatedUsers(): array;

    /**
     * @param RequestAbstract $request
     *
     * @return array
     */
    public function getPaginatedAndFilteredUsers(RequestAbstract $request): array;

    /**
     * @param int $id
     *
     * @return array
     */
    public function getUser(int $id): array;

    /**
     * @param User $currentUser
     * @param User $user
     *
     * @return bool
     */
    public function isUserDeletingHisAccount(
        User $currentUser,
        User $user
    ): bool;

    /**
     * @param RequestAbstract $request
     *
     * @return array
     */
    public function isUserEmailExists(RequestAbstract $request): array;
}
