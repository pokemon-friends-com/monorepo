<?php

namespace template\Domain\Users\Users\Notifications;

use NotificationChannels\Twitter\TwitterChannel;
use NotificationChannels\Twitter\TwitterStatusUpdate;
use template\App\Notifications\Messages\CustomerMailMessage;
use template\Domain\Users\Users\User;
use template\Infrastructure\Contracts\Notifications\Notification;

class SponsoredFriendCode extends Notification
{

    /**
     * @var User
     */
    protected $user;

    protected $hash_tags = [
        '#PokemonGo',
        '#pokemonfriends',
        '#GOBattle',
    ];

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
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        $channels = [
            'mail',
        ];

        if (app()->environment('production')) {
            $channels[] = TwitterChannel::class;
        }

        return $channels;
    }

    public function toTwitter($notifiable)
    {
        $friend_code = $this->user->profile->formated_friend_code;
        $hash_tags = implode(' ', $this->hash_tags);

        return new TwitterStatusUpdate("A trainer, {$friend_code}, is looking for new friends! {$hash_tags}");
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
            ->subject('You joined our sponsored trainers')
            ->view(
                'emails.users.users.sponsored_friend_code',
                [
                    'friend_code' => $this->user->profile->formated_friend_code
                ]
            );
    }
}
