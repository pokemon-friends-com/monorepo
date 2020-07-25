<?php

namespace Tests\Unit\Domain\Users\ProvidersTokens\Repositories;

use pkmnfriends\Domain\Users\ProvidersTokens\Events\ProviderTokenCreatedEvent;
use pkmnfriends\Domain\Users\ProvidersTokens\Events\ProviderTokenDeletedEvent;
use pkmnfriends\Domain\Users\ProvidersTokens\Events\ProviderTokenUpdatedEvent;
use pkmnfriends\Domain\Users\ProvidersTokens\ProviderToken;
use pkmnfriends\Domain\Users\Users\User;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Notification;
use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use pkmnfriends\Domain\Users\ProvidersTokens\Repositories\ProvidersTokensRepositoryEloquent;

class ProvidersTokensRepositoryEloquentTest extends TestCase
{
    use DatabaseMigrations;

    protected $rProvidersTokens = null;

    public function __construct()
    {
        parent::__construct();

        $this->rProvidersTokens = app()->make(ProvidersTokensRepositoryEloquent::class);
    }

    public function testCheckIfRepositoryIsCorrectlyInstantiated()
    {
        $this->assertTrue($this->rProvidersTokens instanceof ProvidersTokensRepositoryEloquent);
    }

    public function testModel()
    {
        $this->assertEquals(ProviderToken::class, $this->rProvidersTokens->model());
    }

    public function testCreate()
    {
        $user = factory(User::class)->create();
        $providerToken = factory(ProviderToken::class)->raw(['user_id' => $user->id]);
        Event::fake();
        $providerToken = $this->rProvidersTokens->create($providerToken);
        Event::assertDispatched(ProviderTokenCreatedEvent::class, function ($event) use ($providerToken) {
            return $event->provider_token->id === $providerToken->id;
        });
        $this->assertDatabaseHas('users_providers_tokens', $providerToken->toArray());
    }

    public function testUpdate()
    {
        $user = factory(User::class)->create();
        $providerToken = factory(ProviderToken::class)->create(['user_id' => $user->id]);
        $newProviderToken = factory(ProviderToken::class)->raw(['user_id' => $user->id]);
        Event::fake();
        $providerToken = $this->rProvidersTokens->update($newProviderToken, $providerToken->id);
        Event::assertDispatched(ProviderTokenUpdatedEvent::class, function ($event) use ($providerToken) {
            return $event->provider_token->id === $providerToken->id;
        });
        $this->assertDatabaseHas('users_providers_tokens', $providerToken->toArray());
    }

    public function testDelete()
    {
        $user = factory(User::class)->create();
        $providerToken = factory(ProviderToken::class)->create(['user_id' => $user->id]);
        Event::fake();
        $providerToken = $this->rProvidersTokens->delete($providerToken->id);
        Event::assertDispatched(ProviderTokenDeletedEvent::class, function ($event) use ($providerToken) {
            return $event->provider_token->id === $providerToken->id;
        });
        $this->assertDatabaseMissing('users_providers_tokens', $providerToken->toArray());
    }

    public function testGetProviders()
    {
        $this->assertEquals(ProviderToken::PROVIDERS, $this->rProvidersTokens->getProviders()->toArray());
    }

    public function testFilterByProvider()
    {
        $user = factory(User::class)->create();
        factory(ProviderToken::class)->state(ProviderToken::GOOGLE)->create(['user_id' => $user->id]);
        $providerToken = factory(ProviderToken::class)->state(ProviderToken::TWITTER)->create(['user_id' => $user->id]);
        $repositoryProviderToken = $this
            ->rProvidersTokens
            ->skipPresenter()
            ->filterByProvider($providerToken->provider_id, $providerToken->provider)
            ->get();
        $this->assertEquals(1, $repositoryProviderToken->count());
    }

    public function testSaveUserTokenForProvider()
    {
        $user = factory(User::class)->create();
        $providerToken = factory(ProviderToken::class)->raw();
        Event::fake();
        $providerToken = $this
            ->rProvidersTokens
            ->saveUserTokenForProvider(
                $user,
                $providerToken['provider'],
                $providerToken['provider_id'],
                $providerToken['provider_token']
            );
        Event::assertDispatched(ProviderTokenUpdatedEvent::class, function ($event) use ($providerToken) {
            return $event->provider_token->id === $providerToken->id;
        });
        $this->assertDatabaseHas('users_providers_tokens', $providerToken->toArray());
    }

    public function testCheckIfTokenIsAvailableForUser()
    {
        $user = factory(User::class)->create();
        $providerToken = factory(ProviderToken::class)->create(['user_id' => $user->id]);
        $providerToken = $this
            ->rProvidersTokens
            ->checkIfTokenIsAvailableForUser(
                $user,
                $providerToken['provider_id'],
                $providerToken['provider']
            );
        $this->assertTrue($providerToken);
    }

    public function testFindUserForProvider()
    {
        $user = factory(User::class)->create();
        $providerToken = factory(ProviderToken::class)->create(['user_id' => $user->id]);
        $providerToken = $this
            ->rProvidersTokens
            ->findUserForProvider(
                $providerToken['provider_id'],
                $providerToken['provider']
            );
        $this->assertDatabaseHas('users_providers_tokens', $providerToken->toArray());
    }
}
