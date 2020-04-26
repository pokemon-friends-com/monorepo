<?php

namespace Tests\Feature\Console\Files;

use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class PushFileToCloudCommandTest extends TestCase
{
    use DatabaseMigrations;

    public function testToPushFileToCloudStorage()
    {
        $cloudFilePath = '/path/to/file.txt';
        $localFilePath = '/path/to/local/file.txt';

        Storage::fake('object-storage');
        Storage::disk('object-storage')->assertMissing($cloudFilePath);
        File::shouldReceive('exists')
            ->with($localFilePath)
            ->once()
            ->andReturn(true);
        File::shouldReceive('get')
            ->with($localFilePath)
            ->once()
            ->andReturn(true);

        $this
            ->artisan("files:cloud:push {$localFilePath} {$cloudFilePath}")
            ->expectsOutput('files:cloud:push : success!')
            ->assertExitCode(0);

        Storage::disk('object-storage')->assertExists($cloudFilePath);
    }

    public function testToPushFileToCloudStorageWhenLocalFileDoesNotExist()
    {
        $cloudFilePath = '/path/to/file.txt';
        $localFilePath = '/path/to/local/file.txt';

        Storage::fake('object-storage');
        File::shouldReceive('exists')
            ->with($localFilePath)
            ->once()
            ->andReturn(false);

        $this
            ->artisan("files:cloud:push {$localFilePath} {$cloudFilePath}")
            ->expectsOutput('File does not exist.')
            ->assertExitCode(1);

        Storage::disk('object-storage')->assertMissing($cloudFilePath);
    }
}
