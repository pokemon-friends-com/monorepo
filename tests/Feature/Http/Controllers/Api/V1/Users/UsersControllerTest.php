<?php

namespace template\Http\Controllers\Api\V1\Users;

use Tests\TestCase;
use Tests\OAuthTestCaseTrait;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Laravel\Passport\Passport;
use template\Domain\Users\Profiles\Profile;
use template\Domain\Users\Users\User;
use template\Domain\Users\Users\Transformers\UserTransformer;

class UsersControllerTest extends TestCase
{
    use OAuthTestCaseTrait;
    use DatabaseMigrations;

    public function testUserEndpoint()
    {
        $user = factory(User::class)->create();
        factory(Profile::class)->create(['user_id' => $user->id]);
        Passport::actingAs($user);

        $this
            ->getJson('/api/v1/users/user')
            ->assertSuccessful()
            ->assertExactJson((new UserTransformer())->transform($user));
    }

    public function testUserAsAnonymousEndpoint()
    {
        // Do not act as anyone to get Unauthenticated exception.
        $this
            ->getJson('/api/v1/users/user')
            ->assertStatus(401)
            ->assertExactJson(['error' => 'Unauthenticated.']);
    }
}
