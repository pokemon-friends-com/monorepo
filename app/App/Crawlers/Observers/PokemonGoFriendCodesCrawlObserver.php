<?php

namespace template\App\Crawlers\Observers;

use GuzzleHttp\Exception\RequestException;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\UriInterface;
use Spatie\Crawler\CrawlObserver;
use template\App\Jobs\RegisterFriendCodeJob;
use template\Domain\Users\Profiles\ProfilesTeamsColors;

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

        if ($doc->getElementsByTagName("img")) {
            foreach ($doc->getElementsByTagName("img") as $element) {
                if (0 === strncmp($element->getAttribute('class'), 'img-thumbnail', strlen('img-thumbnail'))) {
                    $alt = $element->getAttribute('alt');
                    $style = $element->getAttribute('style');
                    $teamColor = ProfilesTeamsColors::DEFAULT;

                    if (false !== strpos($style, '#ffc107!important')) {
                        $teamColor = ProfilesTeamsColors::YELLOW;
                    } elseif (false !== strpos($style, '#ff0000!important')) {
                        $teamColor = ProfilesTeamsColors::RED;
                    } elseif (false !== strpos($style, '#0062cc!important')) {
                        $teamColor = ProfilesTeamsColors::BLUE;
                    }

                    $results = [];
                    $isThereMatch = preg_match(
                        '/([0-9]{4}[\s]{0,1}){3}/',
                        $alt,
                        $results
                    );

                    if ($isThereMatch) {
                        RegisterFriendCodeJob::dispatch(
                            filter_var($results[0], FILTER_SANITIZE_NUMBER_INT),
                            $teamColor
                        );
                    }
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
