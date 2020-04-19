<?php

namespace template\App\Listeners;

use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Shakurov\Coinbase\Models\CoinbaseWebhookCall;

class CoinBaseEventsListener
{

    /**
     * Register the listeners for the subscriber.
     *
     * @param  \Illuminate\Events\Dispatcher $events
     */
    public function subscribe($events)
    {
        $events->listen(
            'coinbase::charge:created',
            'template\App\Listeners\CoinBaseEventsListener@handleCreatedChargeEvent'
        );
        $events->listen(
            'coinbase::charge:confirmed',
            'template\App\Listeners\CoinBaseEventsListener@handleConfirmedChargeEvent'
        );
        $events->listen(
            'coinbase::charge:failed',
            'template\App\Listeners\CoinBaseEventsListener@handleFailedChargeEvent'
        );
        $events->listen(
            'coinbase::charge:delayed',
            'template\App\Listeners\CoinBaseEventsListener@handleDelayedChargeEvent'
        );
        $events->listen(
            'coinbase::charge:pending',
            'template\App\Listeners\CoinBaseEventsListener@handlePendingChargeEvent'
        );
        $events->listen(
            'coinbase::charge:resolved',
            'template\App\Listeners\CoinBaseEventsListener@handleResolvedChargeEvent'
        );
    }

    /**
     * Handle created event.
     *
     * @param CoinbaseWebhookCall $webhookCall
     */
    public function handleCreatedChargeEvent(CoinbaseWebhookCall $webhookCall)
    {
    }

    /**
     * Handle confirmed event.
     *
     * @param CoinbaseWebhookCall $webhookCall
     */
    public function handleConfirmedChargeEvent(CoinbaseWebhookCall $webhookCall)
    {
    }

    /**
     * Handle failed event.
     *
     * @param CoinbaseWebhookCall $webhookCall
     */
    public function handleFailedChargeEvent(CoinbaseWebhookCall $webhookCall)
    {
    }

    /**
     * Handle delayed event.
     *
     * @param CoinbaseWebhookCall $webhookCall
     */
    public function handleDelayedChargeEvent(CoinbaseWebhookCall $webhookCall)
    {
    }

    /**
     * Handle pending event.
     *
     * @param CoinbaseWebhookCall $webhookCall
     */
    public function handlePendingChargeEvent(CoinbaseWebhookCall $webhookCall)
    {
    }

    /**
     * Handle resolved event.
     *
     * @param CoinbaseWebhookCall $webhookCall
     */
    public function handleResolvedChargeEvent(CoinbaseWebhookCall $webhookCall)
    {
    }
}
