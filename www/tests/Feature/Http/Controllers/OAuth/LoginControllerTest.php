<?php

namespace Tests\Feature\Http\Controllers\OAuth;

use Tests\TestCase;
use Tests\OAuthTestCaseTrait;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\Artisan;
use Laravel\Passport\Passport;
use pkmnfriends\Domain\Users\Users\User;

class LoginControllerTest extends TestCase
{
    use OAuthTestCaseTrait;
    use DatabaseMigrations;

    public function testLogin()
    {
        $user = factory(User::class)->states(User::ROLE_CUSTOMER)->create();

        $this
            ->postJson('/api/oauth/login', [
                'email' => $user->email,
                'password' => $this->getDefaultPassword()
            ])
            ->assertSuccessful()
            ->assertJsonStructure(['access_token', 'token_type', 'expires_at']);
    }

    public function testLoginWithWrongUser()
    {
        $user = factory(User::class)->create();

        $this
            ->postJson('/api/oauth/login', [
                'email' => $user['email'],
                'password' => $this->faker->password
            ])
            ->assertStatus(401)
            ->assertExactJson(['message' => 'Unauthorized']);
    }

    public function testLogout()
    {
        Passport::actingAs(factory(User::class)->create());

        $this
            ->getJson('/api/oauth/logout')
            ->assertStatus(204);
    }
}
