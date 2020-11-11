<?php

namespace pkmnfriends\Domain\Users\Users\Criterias;

use Prettus\Repository\Contracts\RepositoryInterface;
use pkmnfriends\Infrastructure\Contracts\Criterias\CriteriaAbstract;

class FullNameLikeCriteria extends CriteriaAbstract
{

    /**
     * @var string $name
     */
    private $name = null;

    /**
     * @param string $name
     */
    public function __construct($name = '')
    {
        $this->name = $name;
    }

    /**
     * @param $model
     * @param RepositoryInterface $repository
     *
     * @return mixed
     */
    public function apply($model, RepositoryInterface $repository)
    {
        $name_words = explode(' ', trim($this->name));

        return $model
            ->where(function ($query) use ($name_words) {
                collect($name_words)
                    ->each(function ($word) use (&$query) {
                        $query
                            ->where(
                                'users.first_name',
                                'LIKE',
                                '%' . $word . '%'
                            )
                            ->orWhere(
                                'users.last_name',
                                'LIKE',
                                '%' . $word . '%'
                            );
                    });
            });
    }
}
