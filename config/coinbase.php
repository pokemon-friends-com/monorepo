<?php

return [
    'apiKey' => env('COINBASE_COMMERCE_API_KEY'),
    'apiVersion' => env('COINBASE_COMMERCE_API_VERSION'),
    'webhookSecret' => env('COINBASE_COMMERCE_WEBHOOK_SECRET'),
    'webhookJobs' => [
        //'charge:created' => \template\App\Jobs\CoinBase\HandleCreatedChargeJob::class,
        //'charge:confirmed' => \template\App\Jobs\CoinBase\HandleConfirmedChargeJob::class,
        //'charge:failed' => \template\App\Jobs\CoinBase\HandleFailedChargeJob::class,
        //'charge:delayed' => \template\App\Jobs\CoinBase\HandleDelayedChargeJob::class,
        //'charge:pending' => \template\App\Jobs\CoinBase\HandlePendingChargeJob::class,
        //'charge:resolved' => \template\App\Jobs\CoinBase\HandleResolvedChargeJob::class,
    ],
    'webhookModel' => Shakurov\Coinbase\Models\CoinbaseWebhookCall::class,
];
