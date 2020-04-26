<?php

namespace Tests\Feature\Http\Controllers\Anonymous\Files;

use Illuminate\Support\Facades\File;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\Storage;
use Tests\OAuthTestCaseTrait;
use Tests\TestCase;

class FilesControllerTest extends TestCase
{
    use OAuthTestCaseTrait;
    use DatabaseMigrations;

    public function testToGetDocument()
    {
        $cloudFilePath = 'file001.jpg';
        $cloudFileContent = file_get_contents($this->faker->imageUrl());

        Storage::fake('object-storage');
        Storage::cloud()->put($cloudFilePath, $cloudFileContent);

        $this
            ->get("files/document/{$cloudFilePath}")
            ->assertSuccessful()
            ->assertHeader('Content-Type', 'image/jpeg');
    }

    public function testToGetDocumentWhenDocumentDoesNotExist()
    {
        $this->get('files/document/file003.jpg')->assertStatus(404);
    }

    public function testToGetThumbnail()
    {
        $cloudFilePath = 'file002.jpg';
        $cloudFileContent = file_get_contents($this->faker->imageUrl());

        Storage::fake('object-storage');
        Storage::fake('thumbnails');
        Storage::cloud()->put($cloudFilePath, $cloudFileContent);

        $this
            ->get('files/thumbnail/file002.jpg')
            ->assertSuccessful()
            ->assertHeader('Content-Type', 'image/jpeg');
    }

    public function testToGetThumbnailWhenDocumentDoesNotExist()
    {
        $this->get('files/thumbnail/file004.jpg')->assertStatus(404);
    }
}
