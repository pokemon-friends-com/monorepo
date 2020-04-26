<?php

namespace Tests\Feature\Http\Controllers\Anonymous\Files;

use Illuminate\Support\Facades\File;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\OAuthTestCaseTrait;
use Tests\TestCase;

class FilesControllerTest extends TestCase
{
    use OAuthTestCaseTrait;
    use DatabaseMigrations;

    public function testToGetDocument()
    {
        $this->markTestSkipped('need to be fixed');
        File::copy(
            '/' . base_path('resources/images/test.jpg'),
            '/' . storage_path('app/public/file001.jpg')
        );

        $this
            ->get('files/document/file001.jpg')
            ->assertSuccessful()
            ->assertHeader('Content-Type', 'image/jpeg');

        File::delete(storage_path('app/public/file001.jpg'));
    }

    public function testToGetDocumentWhenDocumentDoesNotExist()
    {
        $this->markTestSkipped('need to be fixed');
        $this->get('files/document/file003.jpg')->assertStatus(404);
    }

    public function testToGetThumbnail()
    {
        $this->markTestSkipped('need to be fixed');
        File::copy(
            base_path('resources/images/test.jpg'),
            storage_path('app/public/file002.jpg')
        );

        $this
            ->get('files/thumbnail/file002.jpg')
            ->assertSuccessful()
            ->assertHeader('Content-Type', 'image/jpeg');

        File::delete([
            storage_path('app/public/file002.jpg'),
            storage_path('app/thumbnails/file002.jpg'),
        ]);
    }

    public function testToGetThumbnailWhenDocumentDoesNotExist()
    {
        $this->markTestSkipped('need to be fixed');
        $this->get('files/thumbnail/file004.jpg')->assertStatus(404);
    }
}
