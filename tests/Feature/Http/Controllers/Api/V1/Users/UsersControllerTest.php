<?php

namespace template\Http\Controllers\Api\V1\Users;

use Carbon\Carbon;
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

    public function testToGetUser()
    {
        $user = factory(User::class)->create();
        factory(Profile::class)->create(['user_id' => $user->id]);
        Passport::actingAs($user);
        $this
            ->getJson('/api/v1/users/user')
            ->assertSuccessful()
            ->assertExactJson((new UserTransformer())->transform($user));
    }

    public function testToGetUserAsAnonymous()
    {
        $this
            ->getJson('/api/v1/users/user')
            ->assertStatus(401)
            ->assertExactJson(['error' => 'Unauthenticated.']);
    }

    public function testToGetUserQrCode()
    {
        $user = factory(User::class)->create();
        factory(Profile::class)->create(['user_id' => $user->id]);
        Passport::actingAs($user);
        $this
            ->get("/api/v1/users/qr/{$user->uniqid}.gif")
            ->assertSuccessful()
            ->assertHeader('Content-Type', 'image/gif');
    }

    public function testToGetUserQrCodeAsAnonymous()
    {
        $user = factory(User::class)->create();
        factory(Profile::class)->create(['user_id' => $user->id]);
        $this
            ->get("/api/v1/users/qr/{$user->uniqid}.gif")
            ->assertSuccessful()
            ->assertHeader('Content-Type', 'image/gif');
    }

    public function testToGetUserQrCodeWhenUserDoesNotExist()
    {
        $this
            ->get('/api/v1/users/qr/DOESNOTEXIST.gif')
            ->assertNotFound();
    }

    public function testToGetUserQrCodeWhenUserNotSponsored()
    {
        $user = factory(User::class)->states(User::ROLE_CUSTOMER)->create();
        factory(Profile::class)->create(['user_id' => $user->id, 'friend_code' => null]);
        $this
            ->get("/api/v1/users/qr/{$user->uniqid}.gif")
            ->assertNotFound();
    }

    public function testToGetUserQrCodeWhenUserDeleted()
    {
        $user = factory(User::class)
            ->states(User::ROLE_CUSTOMER)
            ->create([
                'deleted_at' => Carbon::now()->format('Y-m-d h:i:s'),
            ]);
        factory(Profile::class)->create(['user_id' => $user->id]);
        $this
            ->get("/api/v1/users/qr/{$user->uniqid}.gif")
            ->assertNotFound();
    }
}
