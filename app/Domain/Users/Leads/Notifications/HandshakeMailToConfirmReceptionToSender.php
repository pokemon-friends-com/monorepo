<?php

namespace template\Domain\Users\Leads\Notifications;

use template\Infrastructure\Interfaces\Domain\Users\Users\HandshakableInterface;
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

class HandshakeMailToConfirmReceptionToSender extends Notification
{

    /**
     * @var HandshakableInterface|null
     */
    protected $entity = null;

    /**
     * @var string
     */
    protected $subject = '';

    /**
     * @var string
     */
    protected $body = '';

    /**
     * HandshakeMailToConfirmedReceptionToSender constructor.
     *
     * @param HandshakableInterface $entity
     */
    public function __construct(HandshakableInterface $entity, $subject, $body)
    {
        $this->entity = $entity;
        $this->subject = $subject;
        $this->body = $body;
    }

    /**
     * Get the notification's channels.
     *
     * @param  mixed $notifiable
     *
     * @return array|string
     */
    public function via($notifiable)
    {
        return [
            'mail',
            AdministratorMailableChannel::class,
        ];
    }

    /**
     * Build the mail representation of the notification.
     *
     * @param  mixed $notifiable
     *
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new CustomerMailMessage())
            ->subject(trans('users.leads.handshake_subject', [
                'subject' => $this->subject,
            ]))
            ->view(
                'emails.users.leads.handshake_mail_to_confirme_reception_to_sender',
                [
                    'civility_name' => $this->entity->civility_name,
                    'body' => nl2br($this->body),
                ]
            );
    }

    /**
     * @param $notifiable
     *
     * @return MailableMessage
     */
    public function toAdministrator($notifiable)
    {
        return (new MailableMessage())
            ->subject(trans('users.leads.handshake_subject', [
                'subject' => $this->subject,
            ]))
            ->view(
                'emails.users.leads.handshake_mail_to_administrator',
                [
                    'civility_name' => $this->entity->civility_name,
                    'body' => nl2br($this->body),
                ]
            );
    }
}
