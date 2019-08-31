<?php namespace obsession\Infrastructure\Interfaces\Repositories;

interface ResourceInterface
{

    /**
     * Retrieve all data from repository
     *
     * @param  array $columns
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function all();

    /**
     * Save a new entity in repository
     *
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function save();

    /**
     * Save a new entity in repository
     *
     * @param array $data
     *
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function create(array $data);

    /**
     * Update an entity from repository
     *
     * @param int $id
     * @param array $data
     *
     * @return \Illuminate\Database\Eloquent\Model
     * @throws \Illuminate\Database\Eloquent\ModelNotFoundException
     */
    public function update($id, array $data);

    /**
     * Update or Create an entity in repository
     *
     * @param array $attributes
     * @param array $values
     *
     * @return int
     */
    public function updateOrCreate(array $attributes, array $values = []);

    /**
     * Delete an entity from repository
     *
     * @param       int / array $id
     * @param array $data
     *
     * @return int
     */
    public function destroy($id);

    /**
     * Find data in repository by id with optional columns names
     *
     * @param  int $id
     *
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function find($id, $columns = ['*']);

    /**
     * Find data in repository by field and value with optional columns names
     *
     * @param  string $field
     * @param         $value
     * @param  array $columns
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function findByField($field, $value = null, $columns = ['*']);

    /**
     * Find data in repository by multiple fields with optional columns names
     *
     * @param array $where
     * @param array $columns
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function findWhere(array $where, $columns = ['*']);

    /**
     * Find data in repository by multiple values in one field with optional
     * columns names
     *
     * @param string $field
     * @param array $values
     * @param array $columns
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function findWhereIn($field, array $values, $columns = ['*']);

    /**
     * Find data in repository by excluding multiple values in one field with
     * optional columns names
     *
     * @param string $field
     * @param array $values
     * @param array $columns
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function findWhereNotIn($field, array $values, $columns = ['*']);

    /**
     * Order data in repository by one column with default optional direction
     *
     * @param string $column
     * @param string $direction
     *
     * @return $this through \Illuminate\Database\Eloquent\Builder
     */
    public function orderBy($column, $direction = 'asc');


    /**
     * Check if entity has relation
     *
     * @param  string $relation
     *
     * @return $this through \Illuminate\Database\Eloquent\Builder
     */
    public function has($relation);

    /**
     * Easy load relations
     *
     * @param  array|string $relations
     *
     * @return $this through \Illuminate\Database\Eloquent\Builder
     */
    public function with($relations);

    /**
     * Filter relation with closure
     *
     * @param string $relation
     * @param closure $closure
     *
     * @return $this through \Illuminate\Database\Eloquent\Builder
     */
    public function whereHas($relation, $closure);

    /**
     * Retrieve all data from repository and paginate them
     *
     * @param int $number
     *
     * @return \Illuminate\Pagination\LengthAwarePaginator
     */
    public function paginate($number);

    /**
     * Retrieve all data from repository and simple-paginate them
     *
     * @param int $number
     *
     * @return \Illuminate\Pagination\LengthAwarePaginator
     */
    public function simplePaginate($number);

}
