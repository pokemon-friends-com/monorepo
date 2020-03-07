<?php

namespace template\Domain\Users\Profiles\Criterias;

use Prettus\Repository\Contracts\RepositoryInterface;
use template\Infrastructure\Contracts\Criterias\CriteriaAbstract;

class WhereFriendCodeNotNullCriteria extends CriteriaAbstract
{

    /**
     * @param $model
     * @param RepositoryInterface $repository
     *
     * @return mixed
     */
    public function apply($model, RepositoryInterface $repository)
    {
        return $model->whereNotNull('friend_code');
    }
}
