<?php

namespace template\Console\Commands\Files;

use Illuminate\Contracts\Filesystem\FileNotFoundException;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use template\Domain\Files\Files\Repositories\FilesRepository;
use template\Infrastructure\Contracts\Commands\CommandAbstract;

class GetFileFromCloudCommand extends CommandAbstract
{

    /**
     * The console command name.
     *
     * @var string
     */
    protected $signature = 'files:cloud:get
     {file : The file, with path, to get from cloud disk}
     {destination : The destination directory on local storage}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Get file from cloud disk.';

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
        $cloudFilePath = $this->argument('file');
        $localDestination = $this->argument('destination');

        try {
            if (!Storage::disk('s3')->exists($cloudFilePath)) {
                throw new FileNotFoundException("File does not exist on s3.");
            }

            File::put(
                $localDestination,
                Storage::disk('s3')->get($cloudFilePath)
            );

            $this->info('files:cloud:get : success!');

            return 0;
        } catch (FileNotFoundException $exception) {
            $this->error($exception->getMessage());
        }

        return 1;
    }
}
