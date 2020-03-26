<?php

namespace template\Infrastructure\Contracts\Model;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

abstract class AuthenticatableModelAbstract extends Authenticatable implements Transformable
{
    use TransformableTrait;
}
