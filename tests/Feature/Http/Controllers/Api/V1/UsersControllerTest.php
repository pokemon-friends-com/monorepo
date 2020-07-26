<?php

namespace Tests\Feature\Http\Controllers\Api\V1;

use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;
use pkmnfriends\Domain\Files\Medias\Media;
use Tests\TestCase;
use Tests\OAuthTestCaseTrait;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Laravel\Passport\Passport;
use pkmnfriends\Domain\Users\Profiles\Profile;
use pkmnfriends\Domain\Users\Users\User;
use pkmnfriends\Domain\Users\Users\Transformers\UserTransformer;

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
            ->get("/api/v1/users/qr/{$user->uniqid}.png")
            ->assertSuccessful()
            ->assertHeader('Content-Type', 'image/png');
    }

    public function testToGetUserQrCodeAsAnonymous()
    {
        $user = factory(User::class)->create();
        factory(Profile::class)->create(['user_id' => $user->id]);
        $this
            ->get("/api/v1/users/qr/{$user->uniqid}.png")
            ->assertSuccessful()
            ->assertHeader('Content-Type', 'image/png');
    }

    public function testToGetUserQrCodeWhenQrCodeAlreadyExists()
    {
        $user = factory(User::class)->create();
        $profile = factory(Profile::class)->create(['user_id' => $user->id]);
        $media = factory(Media::class)->create([
            'file_name' => 'file001.png',
            'mime_type' => 'image/png',
            'model_id' => $profile->id,
            'model_type' => Profile::class,
        ]);

        $cloudFilePath = "{$media->id}/file001.png";
        $cloudFileContent = file_get_contents(base_path('resources/images/test.jpg'));

        Storage::fake('object-storage');
        Storage::cloud()->put($cloudFilePath, $cloudFileContent);

        Passport::actingAs($user);
        $this
            ->get("/api/v1/users/qr/{$user->uniqid}.png")
            ->assertSuccessful()
            ->assertHeader('Content-Type', 'image/png');
    }

    public function testToGetUserQrCodeWhenUserDoesNotExist()
    {
        $this
            ->get('/api/v1/users/qr/DOESNOTEXIST.png')
            ->assertNotFound();
    }

    public function testToGetUserQrCodeWhenUserHasNoFriendCode()
    {
        $user = factory(User::class)->states(User::ROLE_CUSTOMER)->create();
        factory(Profile::class)->create(['user_id' => $user->id, 'friend_code' => null]);
        $this
            ->get("/api/v1/users/qr/{$user->uniqid}.png")
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
            ->get("/api/v1/users/qr/{$user->uniqid}.png")
            ->assertNotFound();
    }
}
