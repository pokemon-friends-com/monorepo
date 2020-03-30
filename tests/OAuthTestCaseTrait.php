<?php

namespace Tests;

use template\Domain\Users\{
    Users\User,
    Profiles\Profile
};

trait OAuthTestCaseTrait
{

    public function setUp(): void
    {
        parent::setUp();

        if (
            app()->environment('testing')
            && !env('CI')
            && !env('TRAVIS')
            && !env('CONTINUOUS_INTEGRATION')
        ) {
            $this
                ->artisan('passport:client', ['--personal' => true])
                ->expectsQuestion('What should we name the personal access client?', 'Testing')
                ->assertExitCode(0);
        } elseif (
            app()->environment('testing')
            && (
                env('CI')
                || env('TRAVIS')
                || env('CONTINUOUS_INTEGRATION')
            )
        ) {
            $this
                ->artisan('passport:install', ['--force' => true])
                ->assertExitCode(0);
        }
    }
}
