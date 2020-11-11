<?php

namespace pkmnfriends\App\Listeners;

use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Auth\Events\{
    Login,
    Logout,
    PasswordReset
};
use pkmnfriends\Infrastructure\Interfaces\Queues\ShouldQueueInterface;

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
            'pkmnfriends\App\Listeners\AuthEventsListener@handleLoginEvent'
        );
        $events->listen(
            'Illuminate\Auth\Events\Logout',
            'pkmnfriends\App\Listeners\AuthEventsListener@handleLogoutEvent'
        );
        $events->listen(
            'Illuminate\Auth\Events\PasswordReset',
            'pkmnfriends\App\Listeners\AuthEventsListener@handlePasswordResetEvent'
        );
    }

    /**
     * Handle Login events.
     * @SuppressWarnings("unused")
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
     * @SuppressWarnings("unused")
     *
     * @param Logout $event
     */
    public function handleLogoutEvent(Logout $event)
    {
        // stuff
    }

    /**
     * Handle PasswordReset events.
     * @SuppressWarnings("unused")
     *
     * @param PasswordReset $event
     */
    public function handlePasswordResetEvent(PasswordReset $event)
    {
        session()->flash('message-success', trans('auth.message_password_reset_success'));
    }
}
