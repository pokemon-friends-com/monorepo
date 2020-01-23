<?php

namespace template\Infrastructure\Contracts\Model;

/**
 * Allows to load entity as route arguments from uniquid field.
 *
 * @package template\Infrastructure\Contracts\Model
 */
trait RouteKeyNameUniquidTrait
{

    /**
     * Get the route key for the model.
     *
     * @return string
     */
    public function getRouteKeyName()
    {
        return 'uniqid';
    }
}
