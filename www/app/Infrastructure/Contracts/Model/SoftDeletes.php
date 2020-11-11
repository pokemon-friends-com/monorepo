<?php

namespace pkmnfriends\Infrastructure\Contracts\Model;

use Illuminate\Database\Eloquent\SoftDeletes as EloquentSoftDeletes;

trait SoftDeletes
{
    use EloquentSoftDeletes;
}
