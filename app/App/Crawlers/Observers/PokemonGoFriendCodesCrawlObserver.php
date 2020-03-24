<?php

namespace template\App\Crawlers\Observers;

use GuzzleHttp\Exception\RequestException;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\UriInterface;
use Spatie\Crawler\CrawlObserver;
use template\App\Jobs\RegisterFriendCodeJob;

class PokemonGoFriendCodesCrawlObserver extends CrawlObserver
{
    /**
     * {@inheritDoc}
     */
    public function crawled(
        UriInterface $url,
        ResponseInterface $response,
        ?UriInterface $foundOnUrl = null
    ) {
        $doc = new \DOMDocument();
        @$doc->loadHTML($response->getBody());

        if ($doc->getElementsByTagName("strong")) {
            foreach ($doc->getElementsByTagName("strong") as $strong) {
                $results = [];
                $isThereMatch = preg_match(
                    '/([0-9]{4}[\s]{0,1}){3}/',
                    $strong->nodeValue,
                    $results
                );

                if ($isThereMatch) {
                    RegisterFriendCodeJob::dispatch($results[0]);
                }
            }
        }
    }

    /**
     * {@inheritDoc}
     */
    public function crawlFailed(
        UriInterface $url,
        RequestException $requestException,
        ?UriInterface $foundOnUrl = null
    ) {
        throw new \Exception('Crawler failed');
    }
}
