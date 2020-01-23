<?php

namespace template\Domain\Users\Users\Traits;

trait NamableTrait
{

    /**
     * Get the lead's full name.
     *
     * @return string
     */
    public function getFullNameAttribute()
    {
        return sprintf('%s %s', ucfirst(strtolower($this->first_name)), ucfirst(strtolower($this->last_name)));
    }

    /**
     * Get the lead's civility name.
     *
     * @return string
     */
    public function getCivilityNameAttribute()
    {
        return sprintf(
            '%s %s %s',
            trans('users.civility.' . $this->civility),
            ucfirst(strtolower($this->last_name)),
            ucfirst(strtolower($this->first_name))
        );
    }
}
