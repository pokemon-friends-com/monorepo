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

use Illuminate\Http\Request;
use Spatie\Honeypot\ProtectAgainstSpam;
use Spatie\Honeypot\SpamDetected;
use Spatie\Honeypot\SpamResponder\SpamResponder;

$redirectSpam = function (SpamResponder $spamResponder, Request $request) {
    event(new SpamDetected($request));
    // phpcs:ignore
    return $spamResponder->respond($request, function () {});
};

Route::any('.env', $redirectSpam);
Route::any('wp-login.php', $redirectSpam);
Route::any('wp-admin', $redirectSpam);

Route::group(
    [
        'as' => 'anonymous.',
        'namespace' => 'Anonymous',
    ],
    function () {
        Route::get('sitemap.xml', ['as' => 'sitemap', 'uses' => 'SiteMapController@index']);
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
