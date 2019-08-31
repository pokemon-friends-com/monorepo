<?php

namespace obsession\Domain\Users\ProvidersTokens\Events;

use obsession\Infractucture\Contracts\Events\EventAbstract;
use obsession\Domain\Users\ProvidersTokens\ProviderToken;

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
