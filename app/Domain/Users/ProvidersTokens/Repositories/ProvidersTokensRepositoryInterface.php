<?php

namespace pkmnfriends\Domain\Users\ProvidersTokens\Repositories;

use Illuminate\Support\Collection;
use pkmnfriends\Domain\Users\ProvidersTokens\ProviderToken;
use pkmnfriends\Domain\Users\Users\User;
use pkmnfriends\Infrastructure\Interfaces\Repositories\RepositoryInterface;

interface ProvidersTokensRepositoryInterface extends RepositoryInterface
{

    /**
     * Create ProviderToken request and fire event "ProviderTokenCreatedEvent".
     *
     * @param array $attributes
     *
     * @event pkmnfriends\Domain\Users\ProvidersTokens\Events\ProviderTokenCreatedEvent
     * @return \pkmnfriends\Domain\Users\ProvidersTokens\ProviderToken
     */
    public function create(array $attributes): ProviderToken;

    /**
     * Update ProviderToken request and fire event "ProviderTokenUpdatedEvent".
     *
     * @param array $attributes
     * @param integer $id
     *
     * @event pkmnfriends\Domain\Users\ProvidersTokens\Events\ProviderTokenUpdatedEvent
     * @return \pkmnfriends\Domain\Users\ProvidersTokens\ProviderToken
     *
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function update(array $attributes, $id): ProviderToken;

    /**
     * Delete ProviderToken request and fire event "ProviderTokenDeletedEvent".
     *
     * @param integer $id
     *
     * @event pkmnfriends\Domain\Users\ProvidersTokens\Events\ProviderTokenDeletedEvent
     * @return \pkmnfriends\Domain\Users\ProvidersTokens\ProviderToken
     */
    public function delete($id): ProviderToken;

    /**
     * @return Collection
     */
    public function getProviders(): Collection;

    /**
     * Filter provider_tokens by name.
     *
     * @param string $name The provider_token last name and/or provider_token first name
     */
    public function filterByProvider($provider_id, $provider): self;

    /**
     * Create or update the user token for specified provider.
     *
     * @param User $user
     * @param $provider
     * @param $provider_id
     * @param $provider_token
     *
     * @return ProviderToken
     */
    public function saveUserTokenForProvider(
        User $user,
        $provider,
        $provider_id,
        $provider_token
    ): ProviderToken;

    /**
     * Check if the requested token is allowed to be used by the user.
     *
     * @param User $user
     * @param $provider_id
     * @param $provider
     *
     * @return bool
     */
    public function checkIfTokenIsAvailableForUser(User $user, $provider_id, $provider): bool;

    /**
     * Find the user by token for specified provider.
     *
     * @param $provider_id
     * @param $provider
     *
     * @return null|ProviderToken
     */
    public function findUserForProvider($provider_id, $provider): ?ProviderToken;
}
