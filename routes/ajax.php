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

/**
 * Ajax routes.
 */
Route::group(
    [
        'domain' => env('APP_DOMAIN'),
        'prefix' => 'ajax',
        'as' => 'ajax.',
        'namespace' => 'Ajax',
        'middleware' => ['ajax'],
    ],
    function () {

        Route::get('locales', ['as' => 'locales.index', 'uses' => 'LocalesController@index']);
        Route::get('timezones', ['as' => 'timezones.index', 'uses' => 'TimeZonesController@index']);

        Route::group(['prefix' => 'users', 'as' => 'users.', 'namespace' => 'Users'], function () {
            Route::get('check-user-email', ['as' => 'check_user_email', 'uses' => 'UsersController@checkUserEmail']);
            Route::get('users', ['as' => 'index', 'uses' => 'UsersController@index']);
        });

    });
