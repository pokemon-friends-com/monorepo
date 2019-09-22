<?php

namespace Tests;

use Illuminate\{
    Foundation\Testing\TestCase as BaseTestCase,
    Foundation\Testing\WithFaker,
};

abstract class TestCase extends BaseTestCase
{
    use WithFaker;
    use ActingTestCaseTrait;
    use CreatesApplication;
    use SqliteHotfixTestCaseTrait;

    public function __construct($name = null, array $data = [], $dataName = '')
    {
        parent::__construct($name, $data, $dataName);

        $this->hotfixSqlite();
    }
}
