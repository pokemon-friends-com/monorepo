<?php

namespace Tests\Unit\App\Services;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class TimeZonesHelpersTest extends TestCase
{
    public function testTimezones()
    {
        $this->assertEquals(timezones(), \DateTimeZone::listIdentifiers(\DateTimeZone::ALL));
    }
}
