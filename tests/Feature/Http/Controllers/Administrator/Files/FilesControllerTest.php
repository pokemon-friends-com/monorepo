<?php

namespace Tests\Feature\Http\Controllers\Administrator\Files;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class FilesControllerTest extends TestCase
{
    use DatabaseMigrations;

    public function testIfIndexFilesIsCorrectlyDisplayed()
    {
        $this->actingAsAdministrator();

        $this
            ->assertAuthenticated()
            ->get('/administrator/files')
            ->assertSuccessful();
    }

    /**
     * We only look to get an answer, here we get an error but we don't need
     * more, we should not test laravel-elfinder..
     */
    public function testFileConnectorAnswer()
    {
        $this->actingAsAdministrator();

        $_SERVER["REQUEST_METHOD"] = "GET";

        $this
            ->assertAuthenticated()
            ->get('/administrator/files/connector')
            ->assertSuccessful()
            ->assertJson(['error' => ['errUnknownCmd']]);
    }
}
