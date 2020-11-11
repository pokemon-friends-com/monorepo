<?php

namespace pkmnfriends\Domain\Users\ProvidersTokens\Events;

use pkmnfriends\Infrastructure\Contracts\Events\EventAbstract;
use pkmnfriends\Domain\Users\ProvidersTokens\ProviderToken;

class ProviderTokenCreatedEvent extends EventAbstract
{

    /**
     * @var ProviderToken|null
     */
    public $provider_token = null;

    /**
     * ProviderTokenUpdatedEvent constructor.
     *
     * @param ProviderToken $provider_token
     */
    public function __construct(ProviderToken $provider_token)
    {
        $this->provider_token = $provider_token;
    }
}
