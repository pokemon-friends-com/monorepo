<?php namespace obsession\Infrastructure\Contracts\Repositories;

use obsession\Infrastructure\Contracts\Model\ModelAbstract;
use obsession\Infrastructure\Interfaces\Repositories\ResourceInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Pagination\LengthAwarePaginator;

abstract class AbstractResourceRepository implements ResourceInterface
{

    /**
     * @var ModelAbstract
     */
    protected $model;

    /**
     * Retrieve all data from repository with optional columns names
     *
     * @return Collection
     */
    public function all(): Collection
    {
        return $this->model->all();
    }

    /**
     * Save a new entity in repository
     *
     * @return bool
     */
    public function save(): bool
    {
        return $this->model->save();
    }

    /**
     * Save a new entity in repository
     *
     * @param array $data
     *
     * @return Model
     */
    public function create(array $data): Model
    {
        return $this->model->create($data);
    }

    /**
     * Update an entity from repository
     *
     * @param int $id
     * @param array $data
     *
     * @return Model
     * @throws ModelNotFoundException
     */
    public function update($id, array $data): Model
    {
        return $this->model->findOrFail($id)->update($data);
    }

    /**
     * Update or Create an entity in repository
     *
     * @param array $attributes
     * @param array $values
     *
     * @return int
     */
    public function updateOrCreate(array $attributes, array $values = []): int
    {
        return $this->model->updateOrCreate($attributes, $values);
    }

    /**
     * Delete an entity from repository
     *
     * @param int|array $id
     *
     * @return int
     */
    public function destroy($id): int
    {
        return $this->model->destroy($id);
    }

    /**
     * Find data in repository by id with optional columns names
     *
     * @param  int $id
     *
     * @return Model
     */
    public function find($id, $columns = ['*']): Model
    {
        return $this->model->findOrFail($id, $columns);
    }

    /**
     * Find data in repository by field and value with optional columns names
     *
     * @param  string $field
     * @param         $value
     * @param  array $columns
     *
     * @return Collection
     */
    public function findByField($field, $value = null, $columns = ['*']): Collection
    {
        return $this->model->where($field, '=', $value)->get($columns);
    }

    /**
     * Find data in repository by multiple fields with optional columns names
     *
     * @param array $where
     * @param array $columns
     *
     * @return Collection
     */
    public function findWhere(array $where, $columns = ['*']): Collection
    {
        return $this->model->where($where)->get($columns);
    }

    /**
     * Find data in repository by multiple values in one field with optional
     * columns names
     *
     * @param string $field
     * @param array $values
     * @param array $columns
     *
     * @return Collection
     */
    public function findWhereIn($field, array $values, $columns = ['*']): Collection
    {
        return $this->model->whereIn($field, $values)->get($columns);
    }

    /**
     * Find data in repository by excluding multiple values in one field with
     * optional columns names
     *
     * @param string $field
     * @param array $values
     * @param array $columns
     *
     * @return Collection
     */
    public function findWhereNotIn($field, array $values, $columns = ['*']): Collection
    {
        return $this->model->whereNotIn($field, $values)->get($columns);
    }

    /**
     * Order data in repository by one column with default optional direction
     *
     * @param string $column
     * @param string $direction
     *
     * @return $this through \Illuminate\Database\Eloquent\Builder
     */
    public function orderBy($column, $direction = 'asc'): self
    {
        $this->model->orderBy($column, $direction);

        return $this;
    }

    /**
     * Check if entity has relation
     *
     * @param  string $relation
     *
     * @return $this through \Illuminate\Database\Eloquent\Builder
     */
    public function has($relation): self
    {
        $this->model->has($relation);

        return $this;
    }

    /**
     * Easy load relations
     *
     * @param  array|string $relations
     *
     * @return $this through \Illuminate\Database\Eloquent\Builder
     */
    public function with($relations): self
    {
        $this->model->with($relations);

        return $this;
    }

    /**
     * Filter relation with closure
     *
     * @param string $relation
     * @param \Closure $closure
     *
     * @return $this through \Illuminate\Database\Eloquent\Builder
     */
    public function whereHas($relation, $closure): self
    {
        $this->model->whereHas($relation, $closure);

        return $this;
    }

    /**
     * Retrieve all data from repository and simple-paginate them
     *
     * @param int $number
     *
     * @return LengthAwarePaginator
     */
    public function simplePaginate($number): LengthAwarePaginator
    {
        return $this->model->simplePaginate($number);
    }

    /**
     * Retrieve all data from repository and paginate them
     *
     * @param int $number
     *
     * @return LengthAwarePaginator
     */
    public function paginate($number): LengthAwarePaginator
    {
        return $this->model->paginate($number);
    }

    /**
     * Retrieve all data from repository, order them by one column with default
     * optional direction and paginate them
     *
     * @param string $column
     * @param int $number
     * @param string $direction
     *
     * @return $this through \Illuminate\Database\Eloquent\Builder
     */
    public function orderByAndPaginate($column, $direction, $number): self
    {
        return $this->model->orderBy($column, $direction)->paginate($number);
    }
}
