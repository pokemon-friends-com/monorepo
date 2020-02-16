<?php

namespace template\Console\Commands;

use template\Infrastructure\Contracts\Commands\CommandAbstract;

class RemoveFileOnAwsCommand extends CommandAbstract
{

    /**
     * The console command name.
     *
     * @var string
     */
    protected $signature = 'file:aws:rm {file : The file path to remove from AWS}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Remove file on AWS bucket.';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $file = $this->argument('file');

        if (!\Storage::disk('s3')->exists($file)) {
            $this->error('File does not exist on AWS!');
            return 1;
        }

        \Storage::disk('s3')->delete($file);
        $this->info('file:aws:rm : success!');

        return 0;
    }
}
