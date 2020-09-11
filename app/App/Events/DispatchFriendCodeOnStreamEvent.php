<?php

namespace pkmnfriends\App\Events;

use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class DispatchFriendCodeOnStreamEvent implements ShouldBroadcast
{
    use Dispatchable;
    use InteractsWithSockets;
    use SerializesModels;

    public $streamChannel;
    public $friendCode;

    /**
     * The name of the queue on which to place the event.
     *
     * @var string
     */
    public $broadcastQueue = 'high';

    public function __construct($streamChannel, $friendCode)
    {
        $this->streamChannel = $streamChannel;
        $this->friendCode = $friendCode;
    }

    public function broadcastOn()
    {
        return new PrivateChannel("stream.{$this->streamChannel}");
    }

    public function broadcastAs()
    {
        return 'add-qrcode';
    }
}
