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
        'as' => 'customer.',
        'namespace' => 'Customer',
        'domain' => env('APP_DOMAIN'),
        'middleware' => ['auth', 'role:'.\template\Domain\Users\Users\User::ROLE_CUSTOMER],
    ],
    function () {
        Route::group(['namespace' => 'Users'], function () {
            Route::group(['prefix' => 'users', 'as' => 'users.'], function () {
                Route::get('dashboard', ['as' => 'dashboard', 'uses' => 'UsersController@dashboard']);
                Route::put('update-password/{user}', ['as' => 'update-password', 'uses' => 'UsersController@updatePassword']);
                Route::model('profile', \template\Domain\Users\Users\User::class);
                Route::resource('profiles', 'ProfilesController');
            });
            Route::resource('users', 'UsersController');
        });
    });
