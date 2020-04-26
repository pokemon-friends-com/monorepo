<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Default Filesystem Disk
    |--------------------------------------------------------------------------
    |
    | Here you may specify the default filesystem disk that should be used
    | by the framework. The "local" disk, as well as a variety of cloud
    | based disks are available to your application. Just store away!
    |
    */

    'default' => 'object-storage',

    /*
    |--------------------------------------------------------------------------
    | Default Cloud Filesystem Disk
    |--------------------------------------------------------------------------
    |
    | Many applications store files both locally and in the cloud. For this
    | reason, you may specify a default "cloud" driver here. This driver
    | will be bound as the Cloud disk implementation in the container.
    |
    */

    'cloud' => 'object-storage',

    /*
    |--------------------------------------------------------------------------
    | Filesystem Disks
    |--------------------------------------------------------------------------
    |
    | Here you may configure as many filesystem "disks" as you wish, and you
    | may even configure multiple disks of the same driver. Defaults have
    | been setup for each driver as an example of the required options.
    |
    | Supported Drivers: "local", "ftp", "sftp", "s3", "rackspace"
    |
    */

    'disks' => [
        'object-storage' => [
            'driver' => 'production' === env('APP_ENV', 'production')
                ? 'object-storage'
                : 'local',
            'root' => 'production' === env('APP_ENV', 'production')
                ? 'private'
                : storage_path('app'),
        ],
        'thumbnails' => [
            'driver' => 'production' === env('APP_ENV', 'production')
                ? 'object-storage'
                : 'local',
            'root' => 'production' === env('APP_ENV', 'production')
                ? 'private/thumbnails'
                : storage_path('app/thumbnails'),
        ],
        'asset-cdn' => [
            'driver' => 'production' === env('APP_ENV', 'production')
                ? 'object-storage'
                : 'local',
            'root' => 'production' === env('APP_ENV', 'production')
                ? null
                : public_path(),
        ],
    ],

];
