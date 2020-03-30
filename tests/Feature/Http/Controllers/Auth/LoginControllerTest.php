<?php

namespace Tests\Feature\Http\Controllers\Auth;

use Laravel\Socialite\{
    Contracts\Provider as SocialiteProvider,
    Facades\Socialite,
    One\User as SocialiteOAuthOneUser,
    Two\User as SocialiteOAuthTwoUser
};
use template\Domain\Users\ProvidersTokens\ProviderToken;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\Event;
use Illuminate\Auth\Events\Login as LoginEvent;
use template\Domain\Users\Users\{
    Events\UserRefreshSessionEvent,
    User
};

class LoginControllerTest extends TestCase
{
    use DatabaseMigrations;

    public function testToVisitLoginPage()
    {
        $this
            ->get('/login')
            ->assertSuccessful()
            ->assertSeeText('Login')
            ->assertSeeText('Change your password')
            ->assertSeeText('Register');
    }

    public function testToVisitLoginPageInFrench()
    {
        $this
            ->get('/login?locale=fr')
            ->assertSuccessful()
            ->assertSeeText('Se connecter')
            ->assertSeeText('Changer votre mot de passe')
            ->assertSeeText(e('S\'inscrire'));
    }

    public function testToVisitLoginPageInGerman()
    {
        $this
            ->get('/login?locale=de')
            ->assertSuccessful()
            ->assertSeeText('Einloggen')
            ->assertSeeText('Ändern Sie Ihr Passwort')
            ->assertSeeText('Registrieren');
    }

    public function testToVisitLoginPageInSpanish()
    {
        $this
            ->get('/login?locale=es')
            ->assertSuccessful()
            ->assertSeeText('Iniciar sesión')
            ->assertSeeText('Cambia tu contraseña')
            ->assertSeeText('Registrarse');
    }

    public function testToVisitLoginPageInRussian()
    {
        $this
            ->get('/login?locale=ru')
            ->assertSuccessful()
            ->assertSeeText('Авторизоваться')
            ->assertSeeText('Изменить пароль')
            ->assertSeeText('регистр');
    }

    public function testToVisitLoginPageInChinese()
    {
        $this
            ->get('/login?locale=zh-CN')
            ->assertSuccessful()
            ->assertSeeText('登录')
            ->assertSeeText('更改您的密码')
            ->assertSeeText('寄存器');
    }

    public function testToLogAsAdministrator()
    {
        $user = factory(User::class)->states(User::ROLE_ADMINISTRATOR)->create();
        Event::fake();
        $this
            ->from('/login')
            ->post('/login', [
                'email' => $user->email,
                'password' => $this->getDefaultPassword(),
            ])
            ->assertRedirect('/');
        Event::assertDispatched(UserRefreshSessionEvent::class, function ($event) use ($user) {
            return $event->user->id === $user->id;
        });
        Event::assertDispatched(LoginEvent::class, function ($event) use ($user) {
            return $event->user->id === $user->id;
        });
    }

    public function testToLogAsCustomer()
    {
        $user = factory(User::class)->states(User::ROLE_CUSTOMER)->create();
        Event::fake();
        $this
            ->from('/login')
            ->post('/login', [
                'email' => $user->email,
                'password' => $this->getDefaultPassword(),
            ])
            ->assertRedirect('/');
        Event::assertDispatched(UserRefreshSessionEvent::class, function ($event) use ($user) {
            return $event->user->id === $user->id;
        });
        Event::assertDispatched(LoginEvent::class, function ($event) use ($user) {
            return $event->user->id === $user->id;
        });
    }

    public function testToSubmitEmptyLoginForm()
    {
        $this
            ->followingRedirects()
            ->from('/login')
            ->post('/login', [
                'email' => null,
                'password' => null,
            ])
            ->assertSuccessful()
            ->assertSeeText('The email field is required.')
            ->assertSeeText('The password field is required.');
    }

    public function testToSubmitLoginFormWithInvalidEmail()
    {
        $this
            ->followingRedirects()
            ->from('/login')
            ->post('/login', [
                'email' => $this->faker->text,
                'password' => $this->getDefaultPassword(),
            ])
            ->assertSuccessful()
            ->assertSeeText('These credentials do not match our records.');
    }

    public function testToSubmitLoginFormWithUnknownCredentials()
    {
        $this
            ->followingRedirects()
            ->from('/login')
            ->post('/login', [
                'email' => $this->faker->email,
                'password' => $this->getDefaultPassword(),
            ])
            ->assertSuccessful()
            ->assertSeeText('These credentials do not match our records.');
    }

    public function testToLogOnSocialProvider()
    {
        $url = $this->faker->url;
        $provider = \Mockery::mock(SocialiteProvider::class);
        $provider
            ->shouldReceive('redirect')
            ->andReturn(redirect($url));

        Socialite::shouldReceive('driver')
            ->with(ProviderToken::TWITTER)
            ->andReturn($provider);

        $this
            ->from('/login')
            ->get('/login/twitter')
            ->assertRedirect()
            ->assertLocation($url);
    }

    public function testToLogOnUnknownSocialProvider()
    {
        Socialite::shouldReceive('driver')
            ->with('unknown')
            ->andThrowExceptions([new \InvalidArgumentException()]);

        $this
            ->from('/login')
            ->get('/login/unknown')
            ->assertRedirect('/login')
            ->assertSessionHas(
                'message-error',
                "The link of your unknown account with your user account could not be done"
            );
    }

    public function testToLogOnSocialProviderUser()
    {
        $user = factory(User::class)
            ->states(User::ROLE_CUSTOMER)
            ->create();
        $provider_token = factory(ProviderToken::class)
            ->states(ProviderToken::TWITTER)
            ->create(['user_id' => $user->id]);
        $abstractUser = \Mockery::mock(SocialiteOAuthOneUser::class);
        $abstractUser->token = $provider_token->provider_token;
        $abstractUser->id = $provider_token->provider_id;
        $abstractUser
            ->shouldReceive('getId')
            ->andReturn($abstractUser->id)
            ->shouldReceive('getEmail')
            ->andReturn($this->faker->email)
            ->shouldReceive('getNickname')
            ->andReturn($this->faker->userName)
            ->shouldReceive('getName')
            ->andReturn($this->faker->name)
            ->shouldReceive('getAvatar')
            ->andReturn('https://en.gravatar.com/userimage');

        $provider = \Mockery::mock(SocialiteProvider::class);
        $provider
            ->shouldReceive('user')
            ->andReturn($abstractUser);

        Socialite::shouldReceive('driver')
            ->with(ProviderToken::TWITTER)
            ->andReturn($provider);

        $this
            ->from('/login')
            ->get("/login/twitter/callback")
            ->assertRedirect('/login')
            ->assertSessionDoesntHaveErrors('message-error');
    }

    public function testToLogSocialProviderUserWithoutLinkedAccount()
    {
        $abstractUser = \Mockery::mock(SocialiteOAuthOneUser::class);
        $abstractUser
            ->shouldReceive('getId')
            ->andReturn($this->faker->uuid)
            ->shouldReceive('getEmail')
            ->andReturn($this->faker->email)
            ->shouldReceive('getNickname')
            ->andReturn($this->faker->userName)
            ->shouldReceive('getName')
            ->andReturn($this->faker->name)
            ->shouldReceive('getAvatar')
            ->andReturn('https://en.gravatar.com/userimage');

        $provider = \Mockery::mock(SocialiteProvider::class);
        $provider
            ->shouldReceive('user')
            ->andReturn($abstractUser);

        Socialite::shouldReceive('driver')
            ->with('twitter')
            ->andReturn($provider);

        $this
            ->from('/login')
            ->get('/login/twitter/callback')
            ->assertRedirect('/login')
            ->assertSessionHas(
                'message-error',
                'This twitter account is not linked to any user account,'
                . ' please log in with your usual credentials then link your account to use the social login system'
            );
    }

    public function testToLinkAccountOnSocialProviderUser()
    {
        $user = $this->actingAsCustomer();
        $abstractUser = \Mockery::mock(SocialiteOAuthOneUser::class);
        $abstractUser->token = $this->faker->uuid;
        $abstractUser->id = $this->faker->uuid;
        $abstractUser
            ->shouldReceive('getId')
            ->andReturn($abstractUser->id)
            ->shouldReceive('getEmail')
            ->andReturn($this->faker->email)
            ->shouldReceive('getNickname')
            ->andReturn($this->faker->userName)
            ->shouldReceive('getName')
            ->andReturn($this->faker->name)
            ->shouldReceive('getAvatar')
            ->andReturn('https://en.gravatar.com/userimage');

        $provider = \Mockery::mock(SocialiteProvider::class);
        $provider
            ->shouldReceive('user')
            ->andReturn($abstractUser);

        Socialite::shouldReceive('driver')
            ->with(ProviderToken::TWITTER)
            ->andReturn($provider);

        $this
            ->from('/login')
            ->get("/login/twitter/callback")
            ->assertRedirect('/login')
            ->assertSessionHas(
                'message-success',
                'The link between your twitter account and your user account is correctly completed'
            );

        $this->assertDatabaseHas('users_providers_tokens', [
           'user_id' => $user->id,
            'provider' => ProviderToken::TWITTER,
            'provider_id' => $abstractUser->id,
            'provider_token' => $abstractUser->token,
        ]);
    }

    public function testToLinkAccountOnSocialProviderUserWithAlreadyLinkedAccount()
    {
        $user = factory(User::class)
            ->states(User::ROLE_CUSTOMER)
            ->create();
        $provider_token = factory(ProviderToken::class)
            ->states(ProviderToken::TWITTER)
            ->create(['user_id' => $user->id]);
        $user = $this->actingAsCustomer();
        $abstractUser = \Mockery::mock(SocialiteOAuthOneUser::class);
        $abstractUser->token = $provider_token->provider_token;
        $abstractUser->id = $provider_token->provider_id;
        $abstractUser
            ->shouldReceive('getId')
            ->andReturn($abstractUser->id)
            ->shouldReceive('getEmail')
            ->andReturn($this->faker->email)
            ->shouldReceive('getNickname')
            ->andReturn($this->faker->userName)
            ->shouldReceive('getName')
            ->andReturn($this->faker->name)
            ->shouldReceive('getAvatar')
            ->andReturn('https://en.gravatar.com/userimage');

        $provider = \Mockery::mock(SocialiteProvider::class);
        $provider
            ->shouldReceive('user')
            ->andReturn($abstractUser);

        Socialite::shouldReceive('driver')
            ->with(ProviderToken::TWITTER)
            ->andReturn($provider);

        $this
            ->from('/login')
            ->get("/login/twitter/callback")
            ->assertRedirect('/login')
            ->assertSessionHas(
                'message-error',
                'The link of your twitter account with your user account could not be done'
            );

        $this->assertDatabaseMissing('users_providers_tokens', [
            'user_id' => $user->id,
            'provider' => ProviderToken::TWITTER,
            'provider_id' => $abstractUser->id,
            'provider_token' => $abstractUser->token,
        ]);
    }

    public function testToLinkAccountOnSocialProviderUserWithUnknownSocialProvider()
    {
        Socialite::shouldReceive('driver')
            ->with('unknown')
            ->andThrowExceptions([new \InvalidArgumentException()]);

        $this
            ->from('/login')
            ->get('/login/unknown/callback')
            ->assertRedirect('/login')
            ->assertSessionHas(
                'message-error',
                "The link of your unknown account with your user account could not be done"
            );
    }
}
