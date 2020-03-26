<?php

namespace template\Console\Commands;

use template\Infrastructure\Contracts\Commands\CommandAbstract;

class PushFileToAwsCommand extends CommandAbstract
{

    /**
     * The console command name.
     *
     * @var string
     */
    protected $signature = 'file:aws:push
     {file : The file path to push to AWS}
     {dest : The directory destination on AWS}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Push file to AWS bucket.';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $file = $this->argument('file');
        $destination = $this->argument('dest');

        if (!\File::exists($file)) {
            $this->error('File does not exist!');
            return 1;
        }

        \Storage::disk('s3')->put($destination, \File::get($file));
        $this->info('file:aws:push : success!');

        return 0;
    }
}
