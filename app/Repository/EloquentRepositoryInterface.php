<?php

namespace App\Repository;


use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\LengthAwarePaginator;

/**
 * Interface EloquentRepositoryInterface
 * @package App\Repositories
 */
interface EloquentRepositoryInterface
{

    /**
     * @param array $attributes
     * @return Model
     */
    public function create(array $attributes): Model;

    /**
     * @param array $attributes
     * @param int $id
     * @return Model
     */
    public function update(int $id, array $attributes): Model;

    /**
     * @param int $id
     * @return Model
     */
    public function delete(int $id): Model;

    /**
     * @param $id
     * @return ?Model
     */
    public function find($id);

    /**
     * @return Model
     */
    public function collection(): Model;

    /**
     * @return \Illuminate\Support\Collection
     */
    public function all(): \Illuminate\Support\Collection;

    /**
     * Get all with filter  with pagination
     * @param array $filter
     * @param array $columns
     * @return LengthAwarePaginator
     */
    public function getAllWithPagination(
        array $filter = [],
        array $includes = [],
        array $columns = ['*']
    ): LengthAwarePaginator;

    /**
     * Get all with filter
     * @param array $filter
     * @param array $includes
     * @return Collection|Builder[]
     */
    public function getAll(
        array $filter = [],
        array $includes = []
    ): \Illuminate\Support\Collection;

    public function getAllowIncludes(): array;
}
