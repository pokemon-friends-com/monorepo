<?php

namespace Tests\Unit\App\Events;

use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use pkmnfriends\App\Events\DispatchFriendCodeOnStreamEvent;
use Tests\TestCase;

class DispatchFriendCodeOnStreamEventTest extends TestCase
{

    public function testDispatchFriendCodeOnStreamEvent()
    {
        $streamChannel = $this->faker->word;
        $event = new DispatchFriendCodeOnStreamEvent($streamChannel, $this->faker->word);
        $this->assertInstanceOf(PrivateChannel::class, $event->broadcastOn());
        $this->assertEquals("private-stream.{$streamChannel}", $event->broadcastOn());
        $this->assertEquals('add-qrcode', $event->broadcastAs());
    }
}
