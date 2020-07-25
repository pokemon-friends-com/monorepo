<?php

namespace pkmnfriends\Domain\Users\Profiles\Criterias;

use Prettus\Repository\Contracts\RepositoryInterface;
use pkmnfriends\Infrastructure\Contracts\Criterias\CriteriaAbstract;

class OrderByUpdateAtCriteria extends CriteriaAbstract
{

    /**
     * @param $model
     * @param RepositoryInterface $repository
     *
     * @return mixed
     */
    public function apply($model, RepositoryInterface $repository)
    {
        return $model->orderBy('updated_at', 'desc');
    }
}
