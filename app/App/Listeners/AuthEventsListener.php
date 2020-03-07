<?php

namespace template\App\Listeners;

use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Auth\Events\{
    Login,
    Logout,
    PasswordReset
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
        $events->listen(
            'Illuminate\Auth\Events\PasswordReset',
            'template\App\Listeners\AuthEventsListener@handlePasswordResetEvent'
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

    /**
     * Handle PasswordReset events.
     *
     * @param PasswordReset $event
     */
    public function handlePasswordResetEvent(PasswordReset $event)
    {
        session()->flash('message-success', trans('auth.message_password_reset_success'));
    }
}
