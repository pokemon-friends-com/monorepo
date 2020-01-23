<?php namespace template\Infrastructure\Contracts\Model;

use Carbon\Carbon;

trait SoftDeletesTz
{

    /**
     * Deleted at timestamp value with time zone from current session.
     *
     * @return Carbon
     */
    public function getDeletedAtTzAttribute()
    {
        return $this->deleted_at->setTimezone(\Session::get('timezone'));
    }
}
