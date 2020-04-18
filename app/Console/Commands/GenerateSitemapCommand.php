<?php

namespace template\Console\Commands;

use Carbon\Carbon;
use Spatie\Sitemap\Sitemap;
use Spatie\Sitemap\Tags\Url;
use template\Domain\Users\Profiles\Repositories\ProfilesRepositoryEloquent;
use template\Domain\Users\Users\Repositories\UsersRepositoryEloquent;
use template\Infrastructure\Contracts\Commands\CommandAbstract;

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
     * @var ProfilesRepositoryEloquent
     */
    protected $r_profiles;

    /**
     * GenerateSitemapCommand constructor.
     *
     * @param ProfilesRepositoryEloquent $r_profiles
     */
    public function __construct(
        ProfilesRepositoryEloquent $r_profiles
    ) {
        parent::__construct();

        $this->r_profiles = $r_profiles;
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
                    ->setLastModificationDate(Carbon::yesterday())
                    ->setChangeFrequency(Url::CHANGE_FREQUENCY_DAILY)
                    ->setPriority(0.1)
            )
            ->add(
                Url::create(url('/terms-of-services'))
                    ->setLastModificationDate(Carbon::yesterday())
                    ->setChangeFrequency(Url::CHANGE_FREQUENCY_MONTHLY)
                    ->setPriority(1)
            )
            ->add(
                Url::create(url('/contact'))
                    ->setLastModificationDate(Carbon::yesterday())
                    ->setChangeFrequency(Url::CHANGE_FREQUENCY_MONTHLY)
                    ->setPriority(0.3)
            )
            ->add(
                Url::create(url('/login'))
                    ->setLastModificationDate(Carbon::yesterday())
                    ->setChangeFrequency(Url::CHANGE_FREQUENCY_MONTHLY)
                    ->setPriority(0.2)
            )
            ->add(
                Url::create(url('/register'))
                    ->setLastModificationDate(Carbon::yesterday())
                    ->setChangeFrequency(Url::CHANGE_FREQUENCY_MONTHLY)
                    ->setPriority(0.2)
            );

        $this
            ->r_profiles
            ->with(['user'])
            ->where('sponsored', '=', '1')
            ->chunk(100, function ($profiles) use ($sitemap) {
                $profiles->each(function ($profile) use ($sitemap) {
                    $sitemap->add(
                        Url::create(route('anonymous.trainers.show', ['user' => $profile->user->uniqid]))
                            ->setLastModificationDate(Carbon::yesterday())
                            ->setChangeFrequency(Url::CHANGE_FREQUENCY_MONTHLY)
                            ->setPriority(1)
                    );
                });
            });

        $sitemap
            ->writeToFile(public_path('sitemap.xml'))
            ->writeToDisk('asset-cdn', 'sitemap.xml');

        $this->info('sitemap:generate : success!');

        return 0;
    }
}
