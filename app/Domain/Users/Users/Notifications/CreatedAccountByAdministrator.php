<?php namespace template\Domain\Users\Users\Notifications;

use template\Infrastructure\Interfaces\Queues\ShouldQueueInterface;
use template\Infrastructure\Contracts\
{
    Queues\QueueableTrait,
    Notifications\Notification
};
use template\App\Notifications\
{
    Channels\AdministratorMailableChannel,
    Messages\CustomerMailMessage,
    Messages\MailableMessage
};
use template\Domain\Users\Users\User;

class CreatedAccountByAdministrator extends Notification
{

    /**
     * @var User|null
     */
    protected $user = null;

    /**
     * CreatedAccountByAdministrator constructor.
     *
     * @param User $user
     */
    public function __construct(User $user)
    {
        $this->user = $user;
    }

    /**
     * Get the notification's channels.
     *
     * @param mixed $notifiable
     *
     * @return array|string
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Build the mail representation of the notification.
     *
     * @param mixed $notifiable
     *
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new CustomerMailMessage())
            ->subject(trans('users.created_account_by_administrator_subject'))
            ->view(
                'emails.users.users.created_account_by_administrator',
                ['civility_name' => $this->user->civility_name]
            );
    }
}
