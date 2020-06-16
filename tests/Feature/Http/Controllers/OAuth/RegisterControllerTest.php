<?php

namespace Tests\Feature\Http\Controllers\OAuth;

use template\Domain\Users\Profiles\Profile;
use Tests\TestCase;
use Tests\OAuthTestCaseTrait;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use template\Domain\Users\Users\User;

class RegisterControllerTest extends TestCase
{
    use OAuthTestCaseTrait;
    use DatabaseMigrations;

    public function testRegistration()
    {
        $this->markTestSkipped('need to be fixed');
        $user = factory(User::class)->states(User::ROLE_CUSTOMER)->make();
        $profile = factory(Profile::class)->make();
        $this
            ->postJson(
                '/api/oauth/register',
                $user->toArray()
                + $profile->toArray()
                + [
                    'password' => $this->getDefaultPassword(),
                    'password_confirmation' => $this->getDefaultPassword(),
                ]
            )
            ->assertStatus(201)
            ->assertJsonStructure(['access_token', 'token_type', 'expires_at']);
    }
}
