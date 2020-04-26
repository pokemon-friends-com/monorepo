<?php

namespace template\Console\Commands\Files;

use Illuminate\Contracts\Filesystem\FileNotFoundException;
use Illuminate\Support\Facades\Storage;
use template\Domain\Files\Files\Repositories\FilesRepository;
use template\Infrastructure\Contracts\Commands\CommandAbstract;

class RemoveFileFromCloudCommand extends CommandAbstract
{

    /**
     * The console command name.
     *
     * @var string
     */
    protected $signature = 'files:cloud:rm
     {file : The file, with path, to remove from cloud disk}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Remove file from cloud disk.';

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
        $cloudFile = $this->argument('file');

        try {
            if (!Storage::disk('object-storage')->exists($cloudFile)) {
                throw new FileNotFoundException("File does not exist.");
            }

            Storage::disk('object-storage')->delete($cloudFile);

            $this->info('files:cloud:rm : success!');

            return 0;
        } catch (FileNotFoundException $exception) {
            $this->error($exception->getMessage());
        }

        return 1;
    }
}
