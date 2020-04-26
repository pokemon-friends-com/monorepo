<?php

namespace Tests\Feature\Http\Controllers\Anonymous\Files;

use Illuminate\Support\Facades\File;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use template\Domain\Files\Medias\Media;
use template\Domain\Users\Profiles\Profile;
use template\Domain\Users\Users\User;
use template\Infrastructure\Contracts\Traits\SecurityHashTrait;
use Tests\OAuthTestCaseTrait;
use Tests\TestCase;

class MediasControllerTest extends TestCase
{
    use OAuthTestCaseTrait;
    use DatabaseMigrations;
    use SecurityHashTrait;

    public function testMediaEndpoint()
    {
        $this->markTestSkipped('need to be fixed');
        $user = factory(User::class)->create();
        $profile = factory(Profile::class)->create([
            'user_id' => $user->id
        ]);
        $media = factory(Media::class)->create([
            'disk' => 'public',
            'file_name' => 'file001.jpg',
            'model_id' => $profile->id,
            'model_type' => Profile::class,
        ]);

        File::makeDirectory(storage_path("app/public/{$media->id}"));
        File::copy(
            '/' . base_path('resources/images/test.jpg'),
            '/' . storage_path("app/public/{$media->id}/file001.jpg")
        );

        $hash = $this->createHash([
            'id' => $media->id,
            'timestamp' => time(),
        ]);

        $this
            ->get("files/media/{$hash}")
            ->assertSuccessful()
            ->assertHeader('Content-Type', 'image/jpeg');

        File::delete('/' . storage_path("app/public/{$media->id}/file001.jpg"));
        File::deleteDirectory('/' . storage_path("app/public/{$media->id}"));
    }

    public function testMediaEndpointWithBadHash()
    {
        $this->markTestSkipped('need to be fixed');
        $this->get('/files/media/bad_hash')->assertStatus(404);
    }
}
