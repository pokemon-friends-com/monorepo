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
        'as' => 'backend.',
        'namespace' => 'Backend',
        'prefix' => 'backend',
        'domain' => env('APP_DOMAIN'),
        'middleware' => ['auth', 'role:'.\obsession\Domain\Users\Users\User::ROLE_ADMINISTRATOR],
    ],
    function () {

        Route::resource('dashboard', 'DashboardController');

        Route::group(['namespace' => 'Users'], function () {

            Route::group(['prefix' => 'users', 'as' => 'users.'], function () {
                Route::resource('profile', 'ProfilesController');
            });

            Route::resource('leads', 'LeadsController');
            Route::get('users/export', ['as' => 'users.export', 'uses' => 'UsersController@export']);
            Route::resource('users', 'UsersController');

        });

        Route::group(['namespace' => 'Files'], function () {
            Route::get('files', ['as' => 'files.index', 'uses' => 'FilesController@index']);
            Route::get('files/ckeditor', ['as' => 'files.ckeditor', 'uses' => 'FilesController@ckeditor']);
            Route::any('files/connector', ['as' => 'files.connector', 'uses' => 'FilesController@connector']);
        });

    });
