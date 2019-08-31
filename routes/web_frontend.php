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

Route::group(
    [
        'domain' => env('APP_DOMAIN'),
        'as' => 'frontend.',
        'namespace' => 'Frontend',
    ],
    function () {

        Route::get('/', ['as' => 'home', 'uses' => 'HomeController@index']);
        Route::get('terms-of-services', ['as' => 'terms', 'uses' => 'AboutController@terms']);

        Route::group(['namespace' => 'Users'], function () {
            Route::resource('contact', 'LeadsController');
        });

        Route::group(['namespace' => 'Files'], function () {
            Route::get('files/media/{hash}', ['as' => 'medias.document.media', 'uses' => 'MediasController@media']);
            Route::get('files/document/{path}', ['as' => 'medias.document.path', 'uses' => 'MediasController@document'])
                ->where('path', '.+');
            Route::get('files/thumbnail/{path}',
                ['as' => 'medias.document.thumbnail', 'uses' => 'MediasController@thumbnail'])
                ->where('path', '.+');
        });

    });
