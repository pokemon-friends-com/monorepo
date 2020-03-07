<?php

namespace template\Domain\Users\Profiles\Repositories;

use Illuminate\Support\Collection;
use template\Domain\Users\Profiles\Profile;
use template\Infrastructure\Contracts\Request\RequestAbstract;
use template\Infrastructure\Interfaces\Repositories\RepositoryInterface;
use template\Domain\Users\Users\User;

interface ProfilesRepository extends RepositoryInterface
{

    /**
     * Create user profile.
     *
     * @param array $attributes
     *
     * @return Profile
     */
    public function create(array $attributes): Profile;

    /**
     * Update user profile.
     *
     * @param array $attributes
     * @param integer $id
     *
     * @event ProfileUpdatedEvent
     * @return Profile
     */
    public function update(array $attributes, $id): Profile;

    /**
     * Delete user profile.
     *
     * @param $id
     *
     * @event None
     * @return int
     */
    public function delete($id): int;

    /**
     * @return \Illuminate\Support\Collection
     */
    public function getFamilySituations(): Collection;

    /**
     * @param User $user
     * @param array $parameters
     *
     * @return User
     */
    public function createUserProfile(
        User $user,
        $parameters = []
    ): User;

    /**
     * @param User $user
     * @param array $parameters
     *
     * @return User
     */
    public function updateUserProfile(
        User $user,
        $parameters = []
    ): User;

    /**
     * @param User $user
     *
     * @return ProfilesRepositoryEloquent
     */
    public function deleteUserProfile(User $user): self;

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
     * @return array
     */
    public function getUserProfile(User $user): array;

    /**
     * Update the specified resource in storage.
     *
     * @param RequestAbstract $request
     * @param User $user
     *
     * @return void
     */
    public function updateUserProfileWithRequest(
        RequestAbstract $request,
        User $user
    ): void;
}
