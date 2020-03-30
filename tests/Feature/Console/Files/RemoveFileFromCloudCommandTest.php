<?php

namespace Tests\Feature\Console\Files;

use Illuminate\Support\Facades\Storage;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class RemoveFileFromCloudCommandTest extends TestCase
{
    use DatabaseMigrations;

    public function testToDeleteFileFromCloudStorage()
    {
        $cloudFilePath = '/path/to/file.txt';

        Storage::fake('s3');
        Storage::disk('s3')->put($cloudFilePath, $this->faker->text);
        Storage::disk('s3')->assertExists($cloudFilePath);

        $this
            ->artisan("files:cloud:rm {$cloudFilePath}")
            ->expectsOutput('files:cloud:rm : success!')
            ->assertExitCode(0);

        Storage::disk('s3')->assertMissing($cloudFilePath);
    }

    public function testToDeleteFileFromCloudStorageWhenCloudFileDoesNotExist()
    {
        $cloudFilePath = '/path/to/file.txt';

        Storage::fake('s3');

        $this
            ->artisan("files:cloud:rm {$cloudFilePath}")
            ->expectsOutput('File does not exist.')
            ->assertExitCode(1);
    }
}
