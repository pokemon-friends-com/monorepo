<?php

namespace template\App\Listeners;

use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Auth\Events\{
    Login,
    Logout
};
use template\Infrastructure\Interfaces\Queues\ShouldQueueInterface;

class AuthEventsListener
{

    /**
     * Register the listeners for the subscriber.
     *
     * @param  \Illuminate\Events\Dispatcher $events
     */
    public function subscribe($events)
    {
        $events->listen(
            'Illuminate\Auth\Events\Login',
            'template\App\Listeners\AuthEventsListener@handleLoginEvent'
        );
        $events->listen(
            'Illuminate\Auth\Events\Logout',
            'template\App\Listeners\AuthEventsListener@handleLogoutEvent'
        );
    }

    /**
     * Handle Login events.
     *
     * @param Login $event
     */
    public function handleLoginEvent(Login $event)
    {
        session()->flash('message-success', trans('auth.login_message_success'));
    }

    /**
     * Handle Logout events.
     * @codeCoverageIgnore
     *
     * @param Logout $event
     */
    public function handleLogoutEvent(Logout $event)
    {
        // stuff
    }
}
