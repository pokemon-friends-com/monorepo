<?php

namespace template\Infrastructure\Contracts\Events;

use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

abstract class EventAbstract
{
    use SerializesModels;
}
