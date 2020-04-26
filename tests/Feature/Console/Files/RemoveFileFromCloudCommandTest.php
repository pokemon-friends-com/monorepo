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

        Storage::fake('object-storage');
        Storage::disk('object-storage')->put($cloudFilePath, $this->faker->text);
        Storage::disk('object-storage')->assertExists($cloudFilePath);

        $this
            ->artisan("files:cloud:rm {$cloudFilePath}")
            ->expectsOutput('files:cloud:rm : success!')
            ->assertExitCode(0);

        Storage::disk('object-storage')->assertMissing($cloudFilePath);
    }

    public function testToDeleteFileFromCloudStorageWhenCloudFileDoesNotExist()
    {
        $cloudFilePath = '/path/to/file.txt';

        Storage::fake('object-storage');

        $this
            ->artisan("files:cloud:rm {$cloudFilePath}")
            ->expectsOutput('File does not exist.')
            ->assertExitCode(1);
    }
}
