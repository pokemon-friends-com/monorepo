<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
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
        'middleware' => ['cors', 'ajax'],
    ],
    function () {

        Route::resource('locales', 'LocalesController');
        Route::resource('timezones', 'TimeZonesController');

        Route::group(['prefix' => 'users', 'as' => 'users.', 'namespace' => 'Users'], function () {
            Route::group(['prefix' => 'users', 'as' => 'users.'], function () {
                Route::get('check-user-email',
                    ['as' => 'check_user_email', 'uses' => 'UsersController@ajaxCheckUserEmail']);
            });
            Route::resource('users', 'UsersController');
        });

    });
