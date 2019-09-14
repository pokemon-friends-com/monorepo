<?php namespace obsession\Http\Controllers\Ajax;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class TimeZonesControllerTest extends TestCase
{

    use DatabaseMigrations;

    public function testToGetTimeZonesWithAjaxRequest()
    {
        $this
            ->get('/ajax/timezones', ["X-Requested-With" => "XMLHttpRequest"])
            ->assertStatus(200)
            ->assertJson(\DateTimeZone::listIdentifiers(\DateTimeZone::ALL));
    }

    public function testToGetTimeZonesWithoutAjaxRequest()
    {
        $this
            ->get('/ajax/timezones')
            ->assertStatus(405)
            ->assertSeeText(trans('errors.405_title'));
    }
}
