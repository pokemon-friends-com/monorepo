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
        'as' => 'administrator.',
        'namespace' => 'Administrator',
        'prefix' => \template\Domain\Users\Users\User::ROLE_ADMINISTRATOR,
        'domain' => env('APP_DOMAIN'),
        'middleware' => [
            'auth',
            'role:' . \template\Domain\Users\Users\User::ROLE_ADMINISTRATOR
        ],
    ],
    function () {
        Route::group(['namespace' => 'Files'], function () {
            Route::get('files', ['as' => 'files.index', 'uses' => 'FilesController@index']);
            Route::any('files/connector', ['as' => 'files.connector', 'uses' => 'FilesController@connector']);
        });
        Route::group(['namespace' => 'Users'], function () {
            Route::group(['prefix' => 'users', 'as' => 'users.'], function () {
                Route::get('dashboard', ['as' => 'dashboard', 'uses' => 'UsersController@dashboard']);
                Route::get('export', ['as' => 'export', 'uses' => 'UsersController@export']);
                Route::resource('leads', 'LeadsController')->only(['index', 'update']);
            });
            Route::resource('users', 'UsersController');
        });
    }
);
