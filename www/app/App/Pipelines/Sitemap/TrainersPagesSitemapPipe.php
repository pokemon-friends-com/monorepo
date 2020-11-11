<?php

namespace pkmnfriends\App\Pipelines\Sitemap;

use Carbon\Carbon;
use League\Pipeline\StageInterface;
use pkmnfriends\Domain\Users\Profiles\Repositories\ProfilesRepositoryEloquent;
use pkmnfriends\Domain\Users\Users\Repositories\UsersRepositoryEloquent;
use Spatie\Sitemap\Sitemap;
use Spatie\Sitemap\Tags\Url;

class TrainersPagesSitemapPipe implements StageInterface
{

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
        $this->rUsers = $rUsers;
        $this->rProfiles = $rProfiles;
    }

    public function __invoke($sitemap)
    {
        $this
            ->indexTrainersList($sitemap)
            ->indexTrainersProfiles($sitemap);

        return $sitemap;
    }

    protected function indexTrainersList($sitemap)
    {
        $sitemap
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

        return $this;
    }

    protected function indexTrainersProfiles($sitemap)
    {
        $fileIndex = 0;
        $this
            ->rProfiles
            ->with(['user'])
            ->whereNotNull('friend_code')
            ->chunk(1000, function ($profiles) use ($sitemap, &$fileIndex) {
                $trainersProfilesSitemap = Sitemap::create();
                $fileIndex = sprintf("%'.09d", $fileIndex);
                $trainerSitemapFileName = "trainers.{$fileIndex}.xml";
                $profiles->each(function ($profile) use ($sitemap, $trainersProfilesSitemap) {
                    $trainersProfilesSitemap->add(
                        Url::create(route('anonymous.trainers.show', ['trainer' => $profile->user->uniqid]))
                            ->setLastModificationDate($profile->user->updated_at)
                            ->setChangeFrequency(Url::CHANGE_FREQUENCY_DAILY)
                            ->setPriority(0.1)
                    );
                });
                $trainersProfilesSitemap->writeToDisk('object-storage', $trainerSitemapFileName);
                $sitemap->add(
                    Url::create(route('anonymous.files.document', ['path' => $trainerSitemapFileName]))
                        ->setLastModificationDate(Carbon::now())
                        ->setChangeFrequency(Url::CHANGE_FREQUENCY_HOURLY)
                        ->setPriority(0.1)
                );
                ++$fileIndex;
            });

        return $this;
    }
}
