<?php

return [
    'dsn' => env('SENTRY_LARAVEL_DSN', env('SENTRY_PUBLIC_DSN')),
    // Capture release as git sha.
    'release' => env('APP_ENV').'-'.env('APP_VERSION'),
    'breadcrumbs' => [
        // Capture bindings on SQL queries logged in breadcrumbs.
        'sql_bindings' => true,
    ],
];
