<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

use Carbon\Carbon;
use Illuminate\Support\Facades\{Cache, Storage};
use Spatie\Honeypot\ProtectAgainstSpam;

Route::get('sitemap.xml', function () {
    $sitemap = null;

    if (Cache::has('sitemap.xml')) {
        $sitemap = Cache::get('sitemap.xml');
    } else {
        $sitemap = Storage::disk('asset-cdn')->get('sitemap.xml');
        $expiresAt = Carbon::now()->addMinutes(180);
        Cache::put('sitemap.xml', $sitemap, $expiresAt);
    }

    return response()->make($sitemap, 200, ['Content-type' => 'text/xml']);
});

Route::group(
    [
        'as' => 'anonymous.',
        'namespace' => 'Anonymous',
    ],
    function () {
        Route::group(['namespace' => 'Files'], function () {
            Route::get('files/media/{hash}', ['as' => 'files.media', 'uses' => 'MediasController@media']);
            Route::get('files/document/{path}', [
                'as' => 'files.document',
                'uses' => 'FilesController@document'
            ])->where('path', '.+');
            Route::get('files/thumbnail/{path}', [
                'as' => 'files.thumbnail',
                'uses' => 'FilesController@thumbnail'
            ])->where('path', '.+');
        });
        Route::group(['namespace' => 'Users'], function () {
            Route::get('/', ['as' => 'dashboard', 'uses' => 'UsersController@dashboard'])->middleware('guest');
            Route::get('trainer/{user}', ['as' => 'trainer', 'uses' => 'UsersController@show']);
            Route::get('terms-of-services', ['as' => 'terms', 'uses' => 'UsersController@terms']);
            Route::resource('contact', 'LeadsController')->middleware(ProtectAgainstSpam::class);
            Route::model('trainer', \template\Domain\Users\Users\User::class);
            Route::resource('trainers', 'UsersController')->only(['index', 'show']);
        });
    }
);
