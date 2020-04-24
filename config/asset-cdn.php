<?php

return [

    'use_cdn' => env('USE_CDN', false),

    'cdn_url' => env('OBJECT_STORAGE_URL'),

//    'cdn_url' => sprintf(
//        'https://s3.%s.amazonaws.com/%s',
//        env('AWS_DEFAULT_REGION', 'eu-west-3'),
//        env('AWS_ASSETS_BUCKET', 'assets.pokemon-friends.com.local')
//    ),

    'filesystem' => [
        'disk' => 'asset-cdn',
        'options' => [
            // File is available to the public, independent of the S3 Bucket policy
            'ACL' => 'public-read',
            // Sets HTTP Header 'cache-control'. The client should cache the file for max 1 year
            'CacheControl' => 'max-age=31536000, public',
        ],
    ],

    'files' => [
        'ignoreDotFiles' => true,

        'ignoreVCS' => true,

        'include' => [
            'paths' => [
                'css',
                'fonts',
                'images',
                'js',
                'packages',
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
                'trainers'
            ],
            'files' => [
                'README.md',
                'sitemap.xml',
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
