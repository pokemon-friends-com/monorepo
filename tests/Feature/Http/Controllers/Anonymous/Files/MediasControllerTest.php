<?php

namespace Tests\Feature\Http\Controllers\Anonymous\Files;

use Illuminate\Support\Facades\File;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\OAuthTestCaseTrait;
use Tests\TestCase;

class MediasControllerTest extends TestCase
{
    use OAuthTestCaseTrait;
    use DatabaseMigrations;

    public function testMediaEndpoint()
    {
        File::copy(
            '/'.base_path('resources/images/test.jpg'),
            '/'.storage_path('app/public/file001.jpg')
        );

        $this
            ->get('files/document/file001.jpg')
            ->assertSuccessful()
            ->assertHeader('Content-Type', 'image/jpeg');

        File::delete(storage_path('app/public/file001.jpg'));
    }

    public function testMediaEndpointWithBadHash()
    {
        $this
            ->get('files/document/file003.jpg')
            ->assertStatus(404);
    }
}
