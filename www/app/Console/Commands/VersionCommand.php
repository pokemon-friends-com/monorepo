<?php

namespace pkmnfriends\Console\Commands;

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
        if (!app()->environment('local')) {
            $this->error(
                'You must to be in "local" environment to use this command!'
            );
        }

        $version = env('APP_TAG');
        $file = base_path('config/version.php');
        $bytesWritten = File::put(
            $file,
            "<?php\n\nreturn [\n\t'app_tag' => '{$version}',\n];"
        );

        $this->info("Version {$version}");

        if ($bytesWritten === false) {
            $this->error("Error writing to file");
        }
    }
}
