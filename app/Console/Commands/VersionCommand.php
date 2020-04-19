<?php

namespace template\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class VersionCommand extends Command
{
    /**
     * Command name.
     *
     * @var string
     */
    protected $name = 'version:generate';

    /**
     * Command signature.
     *
     * @var string
     */
    protected $signature = 'version:generate';

    /**
     * Command description.
     *
     * @var string
     */
    protected $description = 'Create or update version config file';

    /**
     * Execute command.
     */
    public function handle()
    {
        if (app()->environment('local')) {
            $version = env('APP_TAG');
            $file = base_path('config/version.php');
            $bytes_written = File::put(
                $file,
                "<?php\n\nreturn [\n\t'app_tag' => '{$version}',\n];"
            );

            $this->info("Version {$version}");

            if ($bytes_written === false) {
                $this->error("Error writing to file");
            }
        } else {
            $this->error(
                'You must to be in "local" environment to use this command!'
            );
        }
    }
}
