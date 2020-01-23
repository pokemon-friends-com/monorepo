<?php namespace template\Domain\Users\ProvidersTokens\Repositories;

use Illuminate\Container\Container as Application;
use template\Infrastructure\Contracts\
{
    Repositories\RepositoryEloquentAbstract,
    Request\RequestAbstract
};
use template\Domain\Users\Users\{
    User,
    Repositories\UsersRepositoryEloquent
};
use template\Domain\Users\ProvidersTokens\{
    Repositories\ProvidersTokensRepositoryInterface,
    ProviderToken,
    Criterias\TokenByProviderCriteria,
    Events\ProviderTokenCreatedEvent,
    Events\ProviderTokenUpdatedEvent,
    Events\ProviderTokenDeletedEvent
};

class ProvidersTokensRepositoryEloquent extends RepositoryEloquentAbstract implements ProvidersTokensRepositoryInterface
{

    /**
     * @var UsersRepositoryEloquent|null
     */
    protected $r_users = null;

    /**
     * ProvidersTokensRepositoryEloquent constructor.
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
    public function model(): string
    {
        return ProviderToken::class;
    }

    /**
     * Create ProviderToken request and fire event "ProviderTokenCreatedEvent".
     *
     * @param array $attributes
     *
     * @event template\Domain\Users\ProvidersTokens\Events\ProviderTokenCreatedEvent
     * @return \template\Domain\Users\ProvidersTokens\ProviderToken
     *
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function create(array $attributes): ProviderToken
    {
        $provider_token = parent::create($attributes);

        event(new ProviderTokenCreatedEvent($provider_token));

        return $provider_token;
    }

    /**
     * Update ProviderToken request and fire event "ProviderTokenUpdatedEvent".
     *
     * @param array $attributes
     * @param integer $id
     *
     * @event template\Domain\Users\ProvidersTokens\Events\ProviderTokenUpdatedEvent
     * @return \template\Domain\Users\ProvidersTokens\ProviderToken
     *
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function update(array $attributes, $id): ProviderToken
    {
        $provider_token = parent::update($attributes, $id);

        event(new ProviderTokenUpdatedEvent($provider_token));

        return $provider_token;
    }

    /**
     * Delete ProviderToken request and fire event "ProviderTokenDeletedEvent".
     *
     * @param integer $id
     *
     * @event template\Domain\Users\ProvidersTokens\Events\ProviderTokenDeletedEvent
     * @return \template\Domain\Users\ProvidersTokens\ProviderToken
     */
    public function delete($id): ProviderToken
    {
        $provider_token = $this->find($id);

        parent::delete($provider_token->id);

        event(new ProviderTokenDeletedEvent($provider_token));

        return $provider_token;
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function getProviders()
    {
        return collect(ProviderToken::PROVIDERS);
    }

    /**
     * Filter provider_tokens by name.
     *
     * @param string $name The provider_token last name and/or provider_token first name
     *
     * @throws \Prettus\Repository\Exceptions\RepositoryException
     */
    public function filterByProvider($provider_id, $provider)
    {
        if (
            !is_null($provider_id) && !empty($provider_id)
            && !is_null($provider) && !empty($provider)
        ) {
            $this->pushCriteria(new TokenByProviderCriteria($provider_id, $provider));
        }

        return $this;
    }

    /**
     * Create or update the user token for specified provider.
     *
     * @param User $user
     * @param $provider
     * @param $provider_id
     * @param $provider_token
     *
     * @return ProviderToken
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function saveUserTokenForProvider(User $user, $provider, $provider_id, $provider_token): ProviderToken
    {
        $provider_token = $this
            ->skipPresenter()
            ->updateOrCreate(
                [
                    'user_id' => $user->id,
                    'provider' => $provider,
                ],
                [
                    'provider_id' => $provider_id,
                    'provider_token' => $provider_token,
                ]
            );

        event(new ProviderTokenUpdatedEvent($provider_token));

        return $provider_token;
    }

    /**
     * Check if the requested token is allowed to be used by the user.
     *
     * @param User $user
     * @param $provider_id
     * @param $provider
     *
     * @return bool
     * @throws \Prettus\Repository\Exceptions\RepositoryException
     */
    public function checkIfTokenIsAvailableForUser(User $user, $provider_id, $provider): bool
    {
        $provider_token = $this
            ->skipPresenter()
            ->filterByProvider($provider_id, $provider)
            ->all();

        return (
            0 === $provider_token->count()
            || (
                1 === $provider_token->count()
                && $provider_token->first()->user->id === $user->id
            )
        );
    }

    /**
     * Find the user by token for specified provider.
     *
     * @param $provider_id
     * @param $provider
     *
     * @return null|ProviderToken
     * @throws \Prettus\Repository\Exceptions\RepositoryException
     */
    public function findUserForProvider($provider_id, $provider): ?ProviderToken
    {
        $provider_token = $this
            ->skipPresenter()
            ->filterByProvider($provider_id, $provider)
            ->all();

        return 1 === $provider_token->count()
            ? $provider_token->first()
            : null;
    }
}
