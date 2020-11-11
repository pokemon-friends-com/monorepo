<?php

namespace pkmnfriends\Infrastructure\Contracts\Model;

trait IdentifiableTrait
{

    /**
     * Get the entity's identifier.
     *
     * @return string
     */
    public function getIdentifierAttribute()
    {
        return sprintf("%06d", $this->id);
    }
}
