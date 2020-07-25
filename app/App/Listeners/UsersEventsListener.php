<?php

namespace pkmnfriends\App\Listeners;

use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use pkmnfriends\Domain\Users\Users\{
    Events\UserCreatedEvent,
    Events\UserUpdatedEvent,
    Events\UserDeletedEvent,
    Events\UserRefreshSessionEvent,
    Events\UserTriedToDeleteHisOwnAccountEvent
};

class UsersEventsListener
{

    /**
     * Register the listeners for the subscriber.
     * @SuppressWarnings("unused")
     *
     * @param  \Illuminate\Events\Dispatcher $events
     */
    public function subscribe($events)
    {
        $events->listen(
            'pkmnfriends\Domain\Users\Users\Events\UserCreatedEvent',
            'pkmnfriends\App\Listeners\UsersEventsListener@handleUserCreatedEvent'
        );
        $events->listen(
            'pkmnfriends\Domain\Users\Users\Events\UserUpdatedEvent',
            'pkmnfriends\App\Listeners\UsersEventsListener@handleUserUpdatedEvent'
        );
        $events->listen(
            'pkmnfriends\Domain\Users\Users\Events\UserDeletedEvent',
            'pkmnfriends\App\Listeners\UsersEventsListener@handleUserDeletedEvent'
        );
        $events->listen(
            'pkmnfriends\Domain\Users\Users\Events\UserTriedToDeleteHisOwnAccountEvent',
            'pkmnfriends\App\Listeners\UsersEventsListener@handleUserTriedToDeleteHisOwnAccountEvent'
        );
        $events->listen(
            'pkmnfriends\Domain\Users\Users\Events\UserRefreshSessionEvent',
            'pkmnfriends\App\Listeners\UsersEventsListener@handleUserRefreshSessionEvent'
        );
    }

    /**
     * Handle created event.
     * @SuppressWarnings("unused")
     *
     * @param UserCreatedEvent $event
     */
    public function handleUserCreatedEvent(UserCreatedEvent $event)
    {
        session()->flash('message-success', trans('users.message_created_success'));
    }

    /**
     * Handle updated event.
     * @SuppressWarnings("unused")
     *
     * @param UserUpdatedEvent $event
     */
    public function handleUserUpdatedEvent(UserUpdatedEvent $event)
    {
        session()->flash('message-success', trans('users.message_updated_success'));
    }

    /**
     * Handle deleted event.
     * @SuppressWarnings("unused")
     *
     * @param UserDeletedEvent $event
     */
    public function handleUserDeletedEvent(UserDeletedEvent $event)
    {
        session()->flash('message-success', trans('users.message_deleted_success'));
    }

    /**
     * Handle user that tried to delete his own user account event.
     * @SuppressWarnings("unused")
     *
     * @param UserTriedToDeleteHisOwnAccountEvent $event
     */
    public function handleUserTriedToDeleteHisOwnAccountEvent(
        UserTriedToDeleteHisOwnAccountEvent $event
    ) {
        session()->flash('message-warning', trans('users.message_user_tried_to_delete_his_own_account_error'));
    }

    /**
     * Handle refresh the session of current.
     * @SuppressWarnings("unused")
     *
     * @param UserRefreshSessionEvent $event
     */
    public function handleUserRefreshSessionEvent(
        UserRefreshSessionEvent $event
    ) {
        session()->put('locale', $event->user->locale);
        session()->put('timezone', $event->user->timezone);
        app()->setLocale($event->user->locale);
        app('config')->set('app.timezone', $event->user->timezone);
    }
}
