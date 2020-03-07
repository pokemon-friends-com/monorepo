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

use Spatie\Honeypot\ProtectAgainstSpam;

/**
 * Authentication routes.
 */
Route::group(
    [
        'domain' => env('APP_DOMAIN'),
    ],
    function () {

        Route::impersonate();

        Route::group(['namespace' => 'Auth'], function () {
            // Registration routes.
            Route::get('register', ['as' => 'register', 'uses' => 'RegisterController@showRegistrationForm']);
            Route::post('register', ['as' => 'register', 'uses' => 'RegisterController@register'])->middleware(ProtectAgainstSpam::class);
            // Authentication routes
            Route::get('login', ['as' => 'login', 'uses' => 'LoginController@showLoginForm']);
            Route::post('login', 'LoginController@login')->middleware(ProtectAgainstSpam::class);
            // OAuth providers routes
            Route::get('login/{provider}', ['as' => 'login_provider', 'uses' => 'LoginController@redirectToProvider']);
            Route::get('login/{provider}/callback', 'LoginController@handleProviderCallback');
            // Logout
            Route::get('logout', ['as' => 'logout', 'uses' => 'LoginController@logout']);
            // Passwords forbidden routes
            Route::group(['prefix' => 'password', 'as' => 'password.'], function () {
                // Password reset link request routes
                Route::get('reset', ['as' => 'request', 'uses' => 'ForgotPasswordController@showLinkRequestForm']);
                Route::post('email', ['as' => 'email', 'uses' => 'ForgotPasswordController@sendResetLinkEmail'])->middleware(ProtectAgainstSpam::class);
                // Password reset routes
                Route::get('reset/{token}', ['as' => 'reset', 'uses' => 'ResetPasswordController@showResetForm']);
                Route::post('reset', ['as' => 'update', 'uses' => 'ResetPasswordController@reset'])->middleware(ProtectAgainstSpam::class);
            });
        });
    });
