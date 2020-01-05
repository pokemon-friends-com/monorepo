<?php

namespace Tests\Feature\Http\Controllers\Anonymous\Users;

use Tests\OAuthTestCaseTrait;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class UsersControllerTest extends TestCase
{
    use OAuthTestCaseTrait;
    use DatabaseMigrations;

    public function testIndex()
    {
        $this
            ->get('/')
            ->assertSuccessful();
    }
}
