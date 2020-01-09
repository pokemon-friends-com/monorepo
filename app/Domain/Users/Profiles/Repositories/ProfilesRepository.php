<?php namespace obsession\Domain\Users\Profiles\Repositories;

use Illuminate\Support\Collection;
use obsession\Infrastructure\Interfaces\Repositories\RepositoryInterface;
use obsession\Domain\Users\Users\User;

interface ProfilesRepository extends RepositoryInterface
{

    /**
     * @return Collection
     */
    public function getFamilySituations(): Collection;

    /**
     * @param User $user
     * @param array $parameters
     *
     * @return User
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function createUserProfile(User $user, $parameters = []): User;
}
