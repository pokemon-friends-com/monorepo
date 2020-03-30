<?php

namespace checkCoverage\Infrastructure\Contracts\Commands;

use Illuminate\Console\Command;

abstract class CommandAbstract extends Command
{

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    abstract public function handle();
}
