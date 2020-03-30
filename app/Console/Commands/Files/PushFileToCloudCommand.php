<?php

namespace template\Console\Commands\Files;

use Illuminate\Contracts\Filesystem\FileNotFoundException;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use template\Domain\Files\Files\Repositories\FilesRepository;
use template\Infrastructure\Contracts\Commands\CommandAbstract;

class PushFileToCloudCommand extends CommandAbstract
{

    /**
     * The console command name.
     *
     * @var string
     */
    protected $signature = 'files:cloud:push
     {file : The local file path to push}
     {destination : The directory destination on cloud disk}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Push file to cloud disk.';

    /**
     * @var FilesRepository
     */
    protected $r_files;

    /**
     * GetFileFromCloudCommand constructor.
     *
     * @param FilesRepository $r_files
     */
    public function __construct(FilesRepository $r_files)
    {
        parent::__construct();

        $this->r_files = $r_files;
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $localFile = $this->argument('file');
        $cloudDestination = $this->argument('destination');

        try {
            if (!File::exists($localFile)) {
                throw new FileNotFoundException("File does not exist.");
            }

            Storage::disk('s3')->put($cloudDestination, File::get($localFile));

            $this->info('files:cloud:push : success!');

            return 0;
        } catch (FileNotFoundException $exception) {
            $this->error($exception->getMessage());
        }

        return 1;
    }
}
