<?php

namespace Tests\Feature\Http\Controllers\Anonymous;

use Illuminate\Support\Facades\Storage;
use Spatie\Sitemap\Sitemap;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class SitemapControllerTest extends TestCase
{
    use DatabaseMigrations;

    public function testToVisitSitemap()
    {
        $this->markTestSkipped('need to be fixed');
        $url = $this->faker->url;
        $sitemap = Sitemap::create()->add($url)->render();
        Storage::fake('object-storage');
        Storage::cloud()->put('sitemap.xml', $sitemap);
        $this
            ->get("/sitemap.xml")
            ->assertSuccessful()
            ->assertSee("<loc>{$url}</loc>");
    }

    public function testToVisitSitemapWhenSitemapFileDoesNotExist()
    {
        $this->markTestSkipped('need to be fixed');
        Storage::fake('object-storage');
        $this
            ->get("/sitemap.xml")
            ->assertSuccessful()
            ->assertSee('<loc>https://www.pokemon-friends.com.local</loc>');
    }
}
