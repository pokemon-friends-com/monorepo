<?php namespace template\Domain\Users\Leads\Traits;

use template\Domain\Users\Leads\Notifications\HandshakeMailToConfirmReceptionToSender;

/**
 * Trait HandshakeNotificationTrait
 *
 * The implemented entity have to set `$fillable = ['civility', 'first_name', 'last_name', 'email']` and
 * implement `NamableTrait`.
 */
trait HandshakeNotificationTrait
{

    /**
     * Send the handshake confirmation email.
     *
     * @param $subject
     * @param $body
     *
     * @return $this
     */
    public function sendHandshakeMailToConfirmReceptionToSenderNotification($subject, $body)
    {
        $notification = new HandshakeMailToConfirmReceptionToSender(
            $this,
            $subject,
            $body
        );
        $this->notify($notification);

        return $this;
    }
}
