<?php

namespace Tests\Unit\App\Events;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use pkmnfriends\App\Events\LaravelEchoEvent;
use Tests\TestCase;

class LaravelEchoEventTest extends TestCase
{

    public function testLaravelEchoEvent()
    {
        $event = new LaravelEchoEvent($this->faker->word);
        $this->assertEquals($event->broadcastAs(), 'my-event');
        $this->assertEquals($event->broadcastOn(), ['my-channel']);
    }
}
