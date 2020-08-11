<?php

namespace pkmnfriends\Console\Commands;

use League\Pipeline\Pipeline;
use pkmnfriends\Domain\Users\Profiles\Repositories\ProfilesRepositoryEloquent;
use pkmnfriends\Domain\Users\Users\Repositories\UsersRepositoryEloquent;
use pkmnfriends\App\Pipelines\Sitemap\{
    StaticPagesSitemapPipe,
    TrainersPagesSitemapPipe
};
use Spatie\Sitemap\Sitemap;
use pkmnfriends\Infrastructure\Contracts\Commands\CommandAbstract;

class GenerateSitemapCommand extends CommandAbstract
{

    /**
     * The console command name.
     *
     * @var string
     */
    protected $signature = 'sitemap:generate';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate the sitemap.';

    /**
     * @var UsersRepositoryEloquent
     */
    protected $rUsers;

    /**
     * @var ProfilesRepositoryEloquent
     */
    protected $rProfiles;

    /**
     * GenerateSitemapCommand constructor.
     *
     * @param UsersRepositoryEloquent $rUsers
     * @param ProfilesRepositoryEloquent $rProfiles
     */
    public function __construct(
        UsersRepositoryEloquent $rUsers,
        ProfilesRepositoryEloquent $rProfiles
    ) {
        parent::__construct();

        $this->rUsers = $rUsers;
        $this->rProfiles = $rProfiles;
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        (new Pipeline())
            ->pipe(new StaticPagesSitemapPipe())
            ->pipe(new TrainersPagesSitemapPipe($this->rUsers, $this->rProfiles))
            ->process(Sitemap::create())
            ->writeToDisk('object-storage', 'sitemap.xml');

        $this->info('sitemap:generate : success!');

        return 0;
    }
}
