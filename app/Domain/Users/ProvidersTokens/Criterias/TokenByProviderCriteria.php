<?php

namespace template\Domain\Users\ProvidersTokens\Criterias;

use Prettus\Repository\Contracts\RepositoryInterface;
use template\Infrastructure\Contracts\Criterias\CriteriaAbstract;

class TokenByProviderCriteria extends CriteriaAbstract
{

    /**
     * @var string $provider
     */
    private $provider = null;

    /**
     * @var string $provider_id
     */
    private $provider_id = null;

    /**
     * TokenByProviderCriteria constructor.
     *
     * @param $provider_id
     * @param $provider
     */
    public function __construct($provider_id, $provider)
    {
        $this->provider = $provider;
        $this->provider_id = $provider_id;
    }

    /**
     * @param $model
     * @param RepositoryInterface $repository
     *
     * @return mixed
     */
    public function apply($model, RepositoryInterface $repository)
    {
        return $model
            ->where('provider_id', '=', $this->provider_id)
            ->where('provider', '=', $this->provider);
    }
}
