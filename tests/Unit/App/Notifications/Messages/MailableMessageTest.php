<?php

namespace Tests\Unit\App\Notifications\Messages;

use template\App\Notifications\Messages\MailableMessage;
use Tests\TestCase;

class MailableMessageTest extends TestCase
{

    public function testToInstantiateMessage()
    {
        $mailableMessage = new MailableMessage();

        $this->assertEquals($mailableMessage, $mailableMessage->build());
    }
}
