<?php

namespace pkmnfriends\Infrastructure\Contracts\Repositories;

use pkmnfriends\Infrastructure\Interfaces\Repositories\RepositoryInterface;
use Illuminate\Container\Container as Application;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Pagination\Paginator;
use Prettus\Repository\Contracts\CacheableInterface;
use Prettus\Repository\Criteria\RequestCriteria;
use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Exceptions\RepositoryException;
use Prettus\Repository\Traits\CacheableRepository;

abstract class RepositoryEloquentAbstract extends BaseRepository implements RepositoryInterface, CacheableInterface
{
    use CacheableRepository;

    /**
     * RepositoryEloquentAbstract constructor.
     */
    public function __construct(Application $app)
    {
        parent::__construct($app);
    }

    /**
     * Boot up the repository, pushing criteria.
     *
     * @throws RepositoryException
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }

    /**
     * Set the current page for paginated request.
     *
     * @param int $currentPage
     *
     * @return $this
     */
    public function paginationOffset(int $currentPage): self
    {
        Paginator::currentPageResolver(function () use ($currentPage) {
            return $currentPage;
        });

        return $this;
    }

    /**
     * Get params to set the current page for a paginated request.
     *
     * @param string $currentPageParams
     *
     * @return $this
     */
    public function paginationOffsetFromRequestParams(string $currentPageParams = 'page'): self
    {
        Paginator::currentPageResolver(function () use ($currentPageParams) {
            return request()->input($currentPageParams);
        });

        return $this;
    }
}
