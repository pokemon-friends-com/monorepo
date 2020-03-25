<?php

namespace template\Domain\Users\ProvidersTokens\Events;

use template\Infrastructure\Contracts\Events\EventAbstract;
use template\Domain\Users\ProvidersTokens\ProviderToken;

class ProviderTokenDeletedEvent extends EventAbstract
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
