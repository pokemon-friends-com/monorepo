<?php namespace obsession\Domain\Users\ProvidersTokens\Repositories;

use Illuminate\Container\Container as Application;
use obsession\Infrastructure\Contracts\
{
    Repositories\RepositoryEloquentAbstract,
    Request\RequestAbstract
};
use obsession\Domain\Users\Users\{
    User,
    Repositories\UsersRepositoryEloquent
};
use obsession\Domain\Users\ProvidersTokens\{
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
     * @event obsession\Domain\Users\ProvidersTokens\Events\ProviderTokenCreatedEvent
     * @return \obsession\Domain\Users\ProvidersTokens\ProviderToken
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
     * @event obsession\Domain\Users\ProvidersTokens\Events\ProviderTokenUpdatedEvent
     * @return \obsession\Domain\Users\ProvidersTokens\ProviderToken
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
     * @event obsession\Domain\Users\ProvidersTokens\Events\ProviderTokenDeletedEvent
     * @return \obsession\Domain\Users\ProvidersTokens\ProviderToken
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
     * @return ProviderToken|null
     */
    public function saveUserTokenForProvider(User $user, $provider, $provider_id, $provider_token)
    {
        try {
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
        } catch (\Prettus\Validator\Exceptions\ValidatorException $exception) {
            app('sentry')->captureException($exception);
        }

        return null;
    }

    /**
     * Check if the requested token is allowed to be used by the user.
     *
     * @param User $user
     * @param $provider_id
     * @param $provider
     *
     * @return bool
     */
    public function checkIfTokenIsAvailableForUser(User $user, $provider_id, $provider)
    {
        try {
            $provider_token = $this
                ->skipPresenter()
                ->filterByProvider($provider_id, $provider)
                ->all();
        } catch (\Prettus\Repository\Exceptions\RepositoryException $exception) {
            app('sentry')->captureException($exception);
        }

        return (
            (0 === $provider_token->count())
            || (1 === $provider_token->count() && $provider_token->first()->user->id === $user->id)
        );
    }

    /**
     * Find the user by token for specified provider.
     *
     * @param $provider_id
     * @param $provider
     *
     * @return ProviderToken|null
     */
    public function findUserForProvider($provider_id, $provider)
    {
        try {
            $provider_token = $this
                ->skipPresenter()
                ->filterByProvider($provider_id, $provider)
                ->all();
        } catch (\Prettus\Repository\Exceptions\RepositoryException $exception) {
            app('sentry')->captureException($exception);
        }

        return 1 === $provider_token->count()
            ? $provider_token->first()
            : null;
    }
}
