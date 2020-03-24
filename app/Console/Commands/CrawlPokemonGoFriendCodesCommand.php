<?php

namespace template\Console\Commands;

use Repat\CrawlQueue\RedisCrawlQueue;
use Spatie\Crawler\Crawler;
use Spatie\Crawler\CrawlInternalUrls;
use template\App\Crawlers\Observers\PokemonGoFriendCodesCrawlObserver;
use template\Infrastructure\Contracts\Commands\CommandAbstract;

class CrawlPokemonGoFriendCodesCommand extends CommandAbstract
{

    /**
     * The console command name.
     *
     * @var string
     */
    protected $signature = 'crawler:pokemongofriendcodes {--maximum-crawl= : Maximum crawled page(s) (integer)}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Crawl pokemongofriendcodes.com';

    /**
     * @var string
     */
    protected $crawlerPrefix = 'crawler-pokemongofriendcodes';

    /**
     * @var string
     */
    protected $urlToCrawl = 'https://www.pokemongofriendcodes.com';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        try {
            $maximumCrawl = $this->option('maximum-crawl');

            $crawler = Crawler::create()
                ->setUserAgent(config('app.name'))
                ->respectRobots()
                ->doNotExecuteJavaScript()
                ->setConcurrency(1)
                ->setDelayBetweenRequests(300)
                ->setCrawlProfile(new CrawlInternalUrls($this->urlToCrawl))
                ->setCrawlQueue(
                    new RedisCrawlQueue(
                        new \Predis\Client(config('database.redis.crawler')),
                        $this->crawlerPrefix
                    )
                )
                ->setCrawlObserver(new PokemonGoFriendCodesCrawlObserver());

            if ($maximumCrawl && is_numeric($maximumCrawl)) {
                $crawler->setMaximumCrawlCount(intval($maximumCrawl, 10));
            }

            $crawler->startCrawling($this->urlToCrawl);
        } catch (\Exception $exception) {
            app('sentry')->captureException($exception);
        }

        return 0;
    }
}
