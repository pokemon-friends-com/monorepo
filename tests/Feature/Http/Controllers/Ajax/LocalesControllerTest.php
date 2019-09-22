<?php namespace obsession\Http\Controllers\Ajax;

use obsession\Infrastructure\Interfaces\Domain\Locale\LocalesInterface;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class LocalesControllerTest extends TestCase
{

    use DatabaseMigrations;

    public function testToGetLocalesWithAjaxRequest()
    {
        $this
            ->get('/ajax/locales', ["X-Requested-With" => "XMLHttpRequest"])
            ->assertSuccessful()
            ->assertJson(LocalesInterface::LOCALES);
    }

    public function testToGetLocalesWithoutAjaxRequest()
    {
        $this
            ->get('/ajax/locales')
            ->assertStatus(405)
            ->assertSeeText(trans('errors.405_title'));
    }
}
