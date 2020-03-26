<?php

namespace template\Console\Commands;

use template\Infrastructure\Contracts\Commands\CommandAbstract;

class GetFileFromAwsCommand extends CommandAbstract
{

    /**
     * The console command name.
     *
     * @var string
     */
    protected $signature = 'file:aws:get
     {file : The file path to get from AWS}
     {dest : The directory destination on local storage}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Get file from AWS bucket.';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $file = $this->argument('file');
        $destination = $this->argument('dest');

        if (!\Storage::disk('s3')->exists($file)) {
            $this->error('File does not exist on AWS!');
            return 1;
        }

        $awsFileContent = \Storage::disk('s3')->get($file);
        \File::put($destination, $awsFileContent);
        $this->info('file:aws:get : success!');

        return 0;
    }
}
