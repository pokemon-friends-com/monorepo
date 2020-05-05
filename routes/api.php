<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::group(
    [
        'prefix' => 'oauth',
        'namespace' => 'OAuth',
        'middleware' => 'api',
    ],
    function () {
        Route::post('login', 'LoginController@login');
        Route::post('register', 'RegisterController@register');
        Route::group(
            [
                'middleware' => 'auth:api'
            ],
            function () {
                Route::get('logout', 'LoginController@logout');
            }
        );
    }
);

Route::group(
    [
        'prefix' => 'v1',
        'as' => 'v1.',
        'namespace' => 'Api\V1',
        'middleware' => 'api',
    ],
    function () {
        Route::group(['namespace' => 'Users'], function () {
            Route::model('profile', \template\Domain\Users\Users\User::class);
            Route::group(['prefix' => 'users', 'as' => 'users.'], function () {
                Route::group(['middleware' => 'cache.headers:public;max_age=2628000;etag'], function () {
                    Route::get('qr/{user}.png', ['as' => 'qr', 'uses' => 'UsersController@qr']);
                });
                Route::resource('profiles', 'ProfilesController', ['only' => ['index']]);
            });
        });
    }
);

Route::group(
    [
        'prefix' => 'v1',
        'as' => 'v1.',
        'namespace' => 'Api\V1',
        'middleware' => ['api', 'auth:api'],
    ],
    function () {
        Route::group(['namespace' => 'Users'], function () {
            Route::model('profile', \template\Domain\Users\Users\User::class);
            Route::group(['prefix' => 'users', 'as' => 'users.'], function () {
                Route::group(['prefix' => 'profiles', 'as' => 'profiles.'], function () {
                    Route::get('family-situations', 'ProfilesController@familySituations');
                });
                Route::resource('profiles', 'ProfilesController', ['only' => ['update']]);
                Route::get('user', ['as' => 'user', 'uses' => 'UsersController@user']);
            });
            Route::resource('users', 'UsersController', ['only' => ['show']]);
        });
    }
);
