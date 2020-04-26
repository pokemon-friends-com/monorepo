<?php

namespace Tests\Feature\Console\Files;

use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class GetFileFromCloudCommandTest extends TestCase
{
    use DatabaseMigrations;

    public function testToGetFileFromCloudStorage()
    {
        $cloudFilePath = '/path/to/file.txt';
        $cloudFileContent = $this->faker->text;
        $localFilePath = '/path/to/local/file.txt';

        Storage::fake('object-storage');
        Storage::disk('object-storage')->put($cloudFilePath, $cloudFileContent);
        Storage::disk('object-storage')->assertExists($cloudFilePath);
        File::shouldReceive('put')
            ->with($localFilePath, $cloudFileContent)
            ->once()
            ->andReturn(true);

        $this
            ->artisan("files:cloud:get {$cloudFilePath} {$localFilePath}")
            ->expectsOutput('files:cloud:get : success!')
            ->assertExitCode(0);
    }

    public function testToGetFileFromCloudStorageWhenCloudFileDoesNotExist()
    {
        $cloudFilePath = '/path/to/file.txt';
        $localFilePath = '/path/to/local/file.txt';

        Storage::fake('object-storage');

        $this
            ->artisan("files:cloud:get {$cloudFilePath} {$localFilePath}")
            ->expectsOutput('File does not exist on object storage.')
            ->assertExitCode(1);
    }
}
