<?php

namespace Tests\Unit\App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use pkmnfriends\App\Events\LaravelEchoEvent;
use Tests\TestCase;

class LaravelEchoEventTest extends TestCase
{

    public function testLaravelEchoEvent()
    {
        $event = new LaravelEchoEvent($this->faker->word);
        $this->assertInstanceOf(Channel::class, $event->broadcastOn());
        $this->assertEquals('my-channel', $event->broadcastOn());
        $this->assertEquals('my-event', $event->broadcastAs());
    }
}
