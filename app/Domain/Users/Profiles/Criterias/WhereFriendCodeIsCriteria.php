<?php

namespace template\Domain\Users\Profiles\Criterias;

use Prettus\Repository\Contracts\RepositoryInterface;
use template\Infrastructure\Contracts\Criterias\CriteriaAbstract;

class WhereFriendCodeIsCriteria extends CriteriaAbstract
{

    /**
     * @var string $friend_code
     */
    private $friend_code = null;

    /**
     * @param string $friend_code
     */
    public function __construct($friend_code = '')
    {
        $this->friend_code = $friend_code;
    }

    /**
     * @param $model
     * @param RepositoryInterface $repository
     *
     * @return mixed
     */
    public function apply($model, RepositoryInterface $repository)
    {
        return $model->where('friend_code', '=', $this->friend_code);
    }
}
