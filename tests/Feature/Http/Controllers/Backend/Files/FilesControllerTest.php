<?php namespace Tests\Feature\Http\Controllers\Backend\Files;

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
            ->get('/backend/files')
            ->assertStatus(200);
    }
}
