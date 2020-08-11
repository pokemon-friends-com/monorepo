<?php

namespace pkmnfriends\App\Pipelines\Sitemap;

use League\Pipeline\StageInterface;
use Spatie\Sitemap\Tags\Url;

class StaticPagesSitemapPipe implements StageInterface
{

    public function __invoke($sitemap)
    {
        return $sitemap
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
                Url::create(url('/login'))
                    ->setChangeFrequency(Url::CHANGE_FREQUENCY_MONTHLY)
                    ->setPriority(0.2)
            )
            ->add(
                Url::create(url('/register'))
                    ->setChangeFrequency(Url::CHANGE_FREQUENCY_MONTHLY)
                    ->setPriority(0.2)
            );
    }
}
