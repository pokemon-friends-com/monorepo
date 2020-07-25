<?php

namespace pkmnfriends\Infrastructure\Contracts\Model;

use Carbon\Carbon;
use Illuminate\Support\Facades\Session;

trait TimeStampsTz
{

    /**
     * Created at timestamp value with time zone from current session.
     *
     * @return Carbon
     */
    public function getCreatedAtTzAttribute()
    {
        return $this->created_at->setTimezone(Session::get('timezone'));
    }

    /**
     * Updated at timestamp value with time zone from current session.
     *
     * @return Carbon
     */
    public function getUpdatedAtTzAttribute()
    {
        return $this->updated_at->setTimezone(Session::get('timezone'));
    }
}
