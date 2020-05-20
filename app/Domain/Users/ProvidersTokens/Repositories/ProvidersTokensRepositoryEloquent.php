<?php

namespace template\Domain\Users\ProvidersTokens\Repositories;

use Illuminate\Container\Container as Application;
use Illuminate\Support\Collection;
use PhpParser\ErrorHandler\Collecting;
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
    protected $rUsers = null;

    /**
     * ProvidersTokensRepositoryEloquent constructor.
     *
     * @param Application $app
     * @param UsersRepositoryEloquent $rUsers
     */
    public function __construct(Application $app, UsersRepositoryEloquent $rUsers)
    {
        parent::__construct($app);

        $this->rUsers = $rUsers;
    }

    /**
     * {@inheritdoc}
     */
    public function model(): string
    {
        return ProviderToken::class;
    }

    /**
     * {@inheritdoc}
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function create(array $attributes): ProviderToken
    {
        $provider_token = parent::create($attributes);

        event(new ProviderTokenCreatedEvent($provider_token));

        return $provider_token;
    }

    /**
     * {@inheritdoc}
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function update(array $attributes, $id): ProviderToken
    {
        $provider_token = parent::update($attributes, $id);

        event(new ProviderTokenUpdatedEvent($provider_token));

        return $provider_token;
    }

    /**
     * {@inheritdoc}
     */
    public function delete($id): ProviderToken
    {
        $provider_token = $this->find($id);

        parent::delete($provider_token->id);

        event(new ProviderTokenDeletedEvent($provider_token));

        return $provider_token;
    }

    /**
     * {@inheritdoc}
     */
    public function getProviders(): Collection
    {
        return collect(ProviderToken::PROVIDERS);
    }

    /**
     * {@inheritdoc}
     * @throws \Prettus\Repository\Exceptions\RepositoryException
     */
    public function filterByProvider($provider_id, $provider): ProvidersTokensRepositoryInterface
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
     * {@inheritdoc}
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function saveUserTokenForProvider(
        User $user,
        $provider,
        $provider_id,
        $provider_token
    ): ProviderToken {
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
     * {@inheritdoc}
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
     * {@inheritdoc}
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
