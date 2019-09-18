<?php namespace obsession\App\Listeners;

use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use obsession\Domain\Users\Users\{
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
     *
     * @param  \Illuminate\Events\Dispatcher $events
     */
    public function subscribe($events)
    {
        $events->listen(
            'obsession\Domain\Users\Users\Events\UserCreatedEvent',
            'obsession\App\Listeners\UsersEventsListener@handleUserCreatedEvent'
        );
        $events->listen(
            'obsession\Domain\Users\Users\Events\UserUpdatedEvent',
            'obsession\App\Listeners\UsersEventsListener@handleUserUpdatedEvent'
        );
        $events->listen(
            'obsession\Domain\Users\Users\Events\UserDeletedEvent',
            'obsession\App\Listeners\UsersEventsListener@handleUserDeletedEvent'
        );
        $events->listen(
            'obsession\Domain\Users\Users\Events\UserTriedToDeleteHisOwnAccountEvent',
            'obsession\App\Listeners\UsersEventsListener@handleUserTriedToDeleteHisOwnAccountEventEvent'
        );
        $events->listen(
            'obsession\Domain\Users\Users\Events\UserRefreshSessionEvent',
            'obsession\App\Listeners\UsersEventsListener@handleUserRefreshSessionEvent'
        );
    }

    /**
     * Handle created event.
     *
     * @param UserCreatedEvent $event
     */
    public function handleUserCreatedEvent(UserCreatedEvent $event)
    {
        session()->flash('message-success', trans('users.message_created_success'));
    }

    /**
     * Handle updated event.
     *
     * @param UserUpdatedEvent $event
     */
    public function handleUserUpdatedEvent(UserUpdatedEvent $event)
    {
        session()->flash('message-success', trans('users.message_updated_success'));
    }

    /**
     * Handle deleted event.
     *
     * @param UserDeletedEvent $event
     */
    public function handleUserDeletedEvent(UserDeletedEvent $event)
    {
        session()->flash('message-success', trans('users.message_deleted_success'));
    }

    /**
     * Handle user that tried to delete his own user account event.
     *
     * @param UserTriedToDeleteHisOwnAccountEvent $event
     */
    public function handleUserTriedToDeleteHisOwnAccountEventEvent(
        UserTriedToDeleteHisOwnAccountEvent $event
    ) {
        session()->flash('message-warning', trans('users.message_user_tried_to_delete_his_own_account_error'));
    }

    /**
     * Handle refresh the session of current.
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
