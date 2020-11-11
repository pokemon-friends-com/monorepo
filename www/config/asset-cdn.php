<?php

return [
    'use_cdn' => env('USE_CDN', false),
    'cdn_url' => env('OBJECT_STORAGE_URL', 'https://pkmn-friends.objects.frb.io/assets/'),
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
            'files' => [],
            'extensions' => [],
            'patterns' => [],
        ],
        'exclude' => [
            'paths' => [
                'private',
            ],
            'files' => [],
            'extensions' => [],
            'patterns' => [],
        ],
    ],
];
