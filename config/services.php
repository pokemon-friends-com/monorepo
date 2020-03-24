<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Third Party Services
    |--------------------------------------------------------------------------
    |
    | This file is for storing the credentials for third party services such
    | as Mailgun, SparkPost and others. This file provides a sane default
    | location for this type of information, allowing packages to have
    | a conventional file to locate the various service credentials.
    |
    */

    'github' => [
        'url' => 'https://github.com/pokemon-friends-com/www',
        'nextgen' => 'https://github.com/pokemon-friends-com/www/milestones',
        'changelog' => 'https://github.com/pokemon-friends-com/www/milestones?state=closed',
        'issues' => 'https://github.com/pokemon-friends-com/www/issues',
    ],

    'google_recaptcha' => [
        'sitekey' => env('GOOGLE_RECAPTCHA_SITEKEY', ''),
        'serverkey' => env('GOOGLE_RECAPTCHA_SERVERKEY', ''),
    ],

    'google_tag_manager' => [
        'id' => env('GOOGLE_TM_ID', ''),
        'auth' => env('GOOGLE_TM_AUTH', ''),
        'env' => env('GOOGLE_TM_ENV', ''),
    ],

    'twitter' => [
        'username' => '@pkmn_friends',
        'url' => 'https://twitter.com/pkmn_friends',
        /*
        |--------------------------------------------------------------------------
        | Site Card
        |--------------------------------------------------------------------------
        |
        | Twitter : twitter:card = summary, summary_large_image, app, player
        |
        */
        'card' => 'summary_large_image',
        'image' => '/images/og-image.jpeg',
    ],

    'facebook' => [
        /*
        |--------------------------------------------------------------------------
        | Site type
        |--------------------------------------------------------------------------
        |
        | Facebook : og:type = https://developers.facebook.com/docs/reference/opengraph
        |
        */
        'og:type' => 'website',
        'og:image' => '/images/og-image.jpeg',
    ],

];
