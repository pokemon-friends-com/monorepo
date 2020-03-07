<?php

namespace template\Domain\Users\Profiles\Criterias;

use Prettus\Repository\Contracts\RepositoryInterface;
use template\Infrastructure\Contracts\Criterias\CriteriaAbstract;

class WhereUserIdIsCriteria extends CriteriaAbstract
{

    /**
     * @var string $user_id
     */
    private $user_id = null;

    /**
     * @param string $user_id
     */
    public function __construct($user_id = '')
    {
        $this->user_id = $user_id;
    }

    /**
     * @param $model
     * @param RepositoryInterface $repository
     *
     * @return mixed
     */
    public function apply($model, RepositoryInterface $repository)
    {
        return $model->where('user_id', '=', $this->user_id);
    }
}
