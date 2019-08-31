<?php

namespace Tests;

use Faker\Factory as FakerFactory;
use Illuminate\{
    Database\Connection,
    Database\Schema\Blueprint,
    Database\Schema\SQLiteBuilder,
    Database\SQLiteConnection,
    Foundation\Testing\TestCase as BaseTestCase,
    Support\Fluent
};

abstract class TestCase extends BaseTestCase
{
    use ActingTestCaseTrait;
    use CreatesApplication;
    use SqliteHotfixTestCaseTrait;

    protected $faker = null;

    public function __construct($name = null, array $data = [], $dataName = '')
    {
        parent::__construct($name, $data, $dataName);

        $this->hotfixSqlite();

        $this->faker = FakerFactory::create();
    }
}
