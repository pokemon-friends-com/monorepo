<?php

namespace template\App\Jobs\CoinBase;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Shakurov\Coinbase\Models\CoinbaseWebhookCall;

class HandleConfirmedChargeJob implements ShouldQueue
{
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;
    use SerializesModels;

    /**
     * @var CoinbaseWebhookCall
     */
    protected $coinbaseWebhookCall;

    /**
     * HandleCreatedChargeJob constructor.
     *
     * @param CoinbaseWebhookCall $coinbaseWebhookCall
     */
    public function __construct(CoinbaseWebhookCall $coinbaseWebhookCall)
    {
        $this->coinbaseWebhookCall = $coinbaseWebhookCall;
    }

    /**
     * Execute the job.
     */
    public function handle()
    {
    }
}
