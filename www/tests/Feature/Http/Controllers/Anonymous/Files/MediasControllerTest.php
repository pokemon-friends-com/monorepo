<?php

namespace Tests\Feature\Http\Controllers\Anonymous\Files;

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\Storage;
use pkmnfriends\Domain\Files\Medias\Media;
use pkmnfriends\Domain\Users\Profiles\Profile;
use pkmnfriends\Domain\Users\Users\User;
use pkmnfriends\Infrastructure\Contracts\Traits\SecurityHashTrait;
use Tests\OAuthTestCaseTrait;
use Tests\TestCase;

class MediasControllerTest extends TestCase
{
    use OAuthTestCaseTrait;
    use DatabaseMigrations;
    use SecurityHashTrait;

    public function testMediaEndpoint()
    {
        $user = factory(User::class)->create();
        $profile = factory(Profile::class)->create([
            'user_id' => $user->id
        ]);
        $media = factory(Media::class)->create([
            'file_name' => 'file001.jpg',
            'mime_type' => 'image/jpeg',
            'model_id' => $profile->id,
            'model_type' => Profile::class,
        ]);

        $cloudFilePath = "{$media->id}/file001.jpg";
        $cloudFileContent = file_get_contents(base_path('resources/images/test.jpg'));

        Storage::fake('object-storage');
        Storage::cloud()->put($cloudFilePath, $cloudFileContent);

        $hash = $this->createHash([
            'id' => $media->id,
            'timestamp' => time(),
        ]);

        $this
            ->get("files/media/{$hash}")
            ->assertSuccessful()
            ->assertHeader('Content-Type', 'image/jpeg');
    }

    public function testMediaEndpointWithBadHash()
    {
        $this->get('/files/media/bad_hash')->assertStatus(404);
    }
}
