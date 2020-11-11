<?php

if (!function_exists('timezones')) {
    /**
     * Time zones list.
     *
     * @return array
     */
    function timezones()
    {
        return \DateTimeZone::listIdentifiers(\DateTimeZone::ALL);
    }
}
