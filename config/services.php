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
        'url' => 'https://github.com/abenevaut/www-template',
        'changelog' => 'https://github.com/abenevaut/www-template/milestones?state=closed',
    ],

    'google_recaptcha' => [
        'sitekey' => env('GOOGLE_RECAPTCHA_SITEKEY'),
        'serverkey' => env('GOOGLE_RECAPTCHA_SERVERKEY'),
    ],

    'twitter' => [
        'username' => '@abenevaut',
        'url' => 'https://twitter.com/abenevaut',
        /*
        |--------------------------------------------------------------------------
        | Site Card
        |--------------------------------------------------------------------------
        |
        | Twitter : twitter:card = summary, summary_large_image, app, player
        |
        */
        'card' => 'summary_large_image',
        'image' => '/images/og-image.png',
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
        'og:image' => '/images/og-image.png',
    ],

];
