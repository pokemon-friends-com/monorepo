<?php

return [

    'use_cdn' => env('USE_CDN', false),

    'cdn_url' => 'https://objects.eu2.frbit.com',

    'filesystem' => [
        'disk' => 'asset-cdn',
        'options' => [
            //
        ],
    ],

    'files' => [
        'ignoreDotFiles' => true,

        'ignoreVCS' => true,

        'include' => [
            'paths' => [
                //
            ],
            'files' => [
                //
            ],
            'extensions' => [
                //
            ],
            'patterns' => [
                //
            ],
        ],

        'exclude' => [
            'paths' => [
                //
            ],
            'files' => [
                //
            ],
            'extensions' => [
                //
            ],
            'patterns' => [
                //
            ],
        ],
    ],

];
