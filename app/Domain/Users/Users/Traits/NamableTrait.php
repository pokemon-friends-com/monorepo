<?php

namespace template\Domain\Users\Users\Traits;

trait NamableTrait
{

    /**
     * Get the full name of namable entity.
     *
     * @return string
     */
    public function getFullNameAttribute(): string
    {
        if (!$this->first_name && !$this->last_name) {
            return $this->email;
        }

        return trim(sprintf(
            '%s %s',
            ucfirst(strtolower($this->first_name)),
            ucfirst(strtolower($this->last_name))
        ));
    }

    /**
     * Get the civility name of namable entity.
     *
     * @return string
     */
    public function getCivilityNameAttribute(): string
    {
        if (self::CIVILITY_UNDEFINED === $this->civility) {
            return $this->getFullNameAttribute();
        }

        return trim(sprintf(
            '%s %s %s',
            trans("users.civility.{$this->civility}"),
            ucfirst(strtolower($this->last_name)),
            ucfirst(strtolower($this->first_name))
        ));
    }
}
