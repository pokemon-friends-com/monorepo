<?php

namespace Tests\Unit\App\Notifications\Messages;

use template\App\Notifications\Messages\CustomerMailMessage;
use Tests\TestCase;

class CustomerMailMessageTest extends TestCase
{

    public function testToInstantiateMessage()
    {
        $customerMailMessage = new CustomerMailMessage();

        $this->assertEquals(
            [
                config('mail.from.address'),
                config('mail.from.name')
            ],
            $customerMailMessage->from
        );
    }
}
