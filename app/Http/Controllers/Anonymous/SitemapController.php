<?php

namespace template\Http\Controllers\Anonymous;

use Carbon\Carbon;
use Illuminate\Support\Facades\{Cache, Storage};
use Spatie\Sitemap\{Sitemap, Tags\Url};
use template\Infrastructure\Contracts\Controllers\ControllerAbstract;

class SitemapController extends ControllerAbstract
{

    /**
     * Display resources list.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $sitemap = null;

        if (Cache::has('sitemap.xml')) {
            $sitemap = Cache::get('sitemap.xml');
        } elseif (Storage::cloud()->exists('sitemap.xml')) {
            $sitemap = Storage::cloud()->get('sitemap.xml');
            $expiresAt = Carbon::now()->addMinutes(180);
            Cache::put('sitemap.xml', $sitemap, $expiresAt);
        } else {
            $sitemap = Sitemap::create()
                ->add(Url::create(url('/')))
                ->render();
        }

        return response()->make($sitemap, 200, ['Content-type' => 'text/xml']);
    }
}
