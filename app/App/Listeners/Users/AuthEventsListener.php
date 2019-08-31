<?php namespace obsession\App\Listeners\Users;

use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Auth\Events\Login;
use Illuminate\Auth\Events\Logout;
use obsession\Domain\Users\Users\User;

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
            'obsession\App\Listeners\Users\AuthEventsListener@handleLoginEvent'
        );
        $events->listen(
            'Illuminate\Auth\Events\Logout',
            'obsession\App\Listeners\Users\AuthEventsListener@handleLogoutEvent'
        );
    }

    /**
     * Handle Login events.
     *
     * @param \Illuminate\Auth\Events\Login $event
     */
    public function handleLoginEvent(Login $event)
    {
        session()->flash('message-success', trans('auth.login_message_success'));
    }

    /**
     * Handle Logout events.
     *
     * @param \Illuminate\Auth\Events\Logout $event
     */
    public function handleLogoutEvent(Logout $event)
    {
        // stuff
    }
}
