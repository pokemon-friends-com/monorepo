<?php

namespace Tests\Unit\App\Notifications\Channels;

use template\App\Notifications\Channels\AdministratorMailableChannel;
use template\App\Notifications\Messages\MailableMessage;
use template\Infrastructure\Contracts\Model\Notifiable;
use template\Infrastructure\Contracts\Notifications\Notification;
use Tests\TestCase;

class AdministratorMailableChannelTest extends TestCase
{

    public function testToSendNotificationFromAdministratorChannel()
    {
        $notifiable = new TestNotifiable();
        $notification = \Mockery::mock(TestNotification::class);
        $message = (new MailableMessage())
            ->subject($this->faker->text(50))
            ->html($this->faker->text(50));

        $notification
            ->shouldReceive('toAdministrator')
            ->andReturn($message);

        (new AdministratorMailableChannel())->send($notifiable, $notification);
    }
}

// phpcs:disable
class TestNotifiable
{
    use Notifiable;
}

class TestNotification extends Notification
{

    public function toAdministrator($notifiable)
    {
        return new MailableMessage();
    }
}
// phpcs:enable
