<?php

namespace pkmnfriends\Console\Commands;

use Spatie\Sitemap\Sitemap;
use Spatie\Sitemap\Tags\Url;
use pkmnfriends\Domain\Users\Profiles\Repositories\ProfilesRepositoryEloquent;
use pkmnfriends\Domain\Users\Users\Repositories\UsersRepositoryEloquent;
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
        $sitemap = Sitemap::create()
            ->add(
                Url::create(url('/'))
                    ->setChangeFrequency(Url::CHANGE_FREQUENCY_DAILY)
                    ->setPriority(0.1)
            )
            ->add(
                Url::create(url('/terms-of-services'))
                    ->setChangeFrequency(Url::CHANGE_FREQUENCY_MONTHLY)
                    ->setPriority(1)
            )
            ->add(
                Url::create(url('/contact'))
                    ->setChangeFrequency(Url::CHANGE_FREQUENCY_DAILY)
                    ->setPriority(0.3)
            )
            ->add(
                Url::create(url('/login'))
                    ->setChangeFrequency(Url::CHANGE_FREQUENCY_MONTHLY)
                    ->setPriority(0.2)
            )
            ->add(
                Url::create(url('/register'))
                    ->setChangeFrequency(Url::CHANGE_FREQUENCY_MONTHLY)
                    ->setPriority(0.2)
            )
            ->add(
                Url::create(route('anonymous.trainers.index'))
                    ->setChangeFrequency(Url::CHANGE_FREQUENCY_HOURLY)
                    ->setPriority(0)
            );

        $trainers = $this
            ->rUsers
            ->getTrainers()
            ->paginate(config('repository.pagination.trainers'));

        if (1 < $trainers['meta']['pagination']['total_pages']) {
            for ($index = 2; $index < $trainers['meta']['pagination']['total_pages']; ++$index) {
                $sitemap->add(
                    Url::create(route('anonymous.trainers.index', ['page' => $index]))
                        ->setChangeFrequency(Url::CHANGE_FREQUENCY_DAILY)
                        ->setPriority(0.1)
                );
            }
        }

        $this
            ->rProfiles
            ->with(['user'])
            ->whereNotNull('friend_code')
            ->chunk(100, function ($profiles) use ($sitemap) {
                $profiles->each(function ($profile) use ($sitemap) {
                    $sitemap->add(
                        Url::create(route('anonymous.trainers.show', ['trainer' => $profile->user->uniqid]))
                            ->setLastModificationDate($profile->user->updated_at)
                            ->setChangeFrequency(Url::CHANGE_FREQUENCY_DAILY)
                            ->setPriority(0.1)
                    );
                });
            });

        $sitemap->writeToDisk('object-storage', 'sitemap.xml');

        $this->info('sitemap:generate : success!');

        return 0;
    }
}
