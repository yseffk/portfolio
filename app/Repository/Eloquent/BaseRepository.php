<?php

namespace App\Repository\Eloquent;


use App\Repository\EloquentRepositoryInterface;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Collection;

/**
 * Class BaseRepository
 * @package App\Repository\Eloquent
 */
abstract class BaseRepository implements EloquentRepositoryInterface
{
    const SORTABLE = ['id', 'created_at'];
    /**
     * @var Model
     */
    protected Model $model;

    /**
     * BaseRepository constructor.
     *
     * @param Model $model
     */
    public function __construct(Model $model)
    {
        $this->model = $model;
    }

    /**
     * @return Collection
     */
    public function all(): Collection
    {
        return $this->collection()->all();
    }

    /**
     * @param array $attributes
     *
     * @return Model
     */
    public function create(array $attributes): Model
    {
        return $this->collection()->create($attributes);
    }

    /**
     * @param integer $id
     * @param array $attributes
     *
     * @return Model
     */
    public function update(int $id, array $attributes): Model
    {
        $model = $this->find($id);

        $model->update($attributes);

        return $model;
    }

    /**
     * @param integer $id
     *
     * @return Model
     */
    public function delete(int $id): Model
    {
        $model = $this->find($id);

        $model->delete();

        return $model;
    }

    /**
     * @param $id
     * @return Model|null
     */
    public function find($id): ?Model
    {

        if (!$model = $this->collection()->find($id)) {

            $message = get_class($this->model) . " with ID $id doesn't exist.";
            $this->exception($message, 404);
        }
        return $model;
    }


    /**
     * @return Model
     */
    public function collection(): Model
    {
        return clone $this->model;
    }

    /**
     * @param array $filter
     * @param array $columns
     * @return LengthAwarePaginator
     */
    public function getAllWithPagination(
        array $filter = [],
        array $includes = [],
        array $columns = ['*']
    ): LengthAwarePaginator
    {

        return $this->getCollectionBuilder(
            $filter,
            $this->getAllowIncludes()
        )->paginate(
            $filter['limit'] ?? 15,
            $columns,
            'page',
            $filter['page'] ?? 1
        );
    }

    /**
     * Get all extra service with pagination
     * @param array $filter
     * @param array $includes
     * @return \Illuminate\Database\Eloquent\Collection|Builder[]
     */
    public function getAll(
        array $filter = [],
        array $includes = []
    ): Collection
    {
        return $this->getCollectionBuilder(
            $filter,
            $includes
        )->get();
    }

    /**
     * Get all extra service
     * @param array $filter
     * @param array $includes
     * @return Builder
     */
    protected function getCollectionBuilder(
        array $filter = [],
        array $includes = []
    ): Builder
    {
        $collectionBuilder = $this->collection()::query();
        $collectionBuilder->with(
            array_intersect($this->getAllowIncludes(), $includes)
        );
        $this->setFiltering($collectionBuilder, $filter);

        $sortable = self::SORTABLE; // sortable fields
        $order_by = $filter['order_by'];
        $order_dir = 'asc';

        if (array_key_exists('order_by', $filter) && ($filter['order_by'][0] == '-')) {
            $order_by = substr($filter['order_by'], 1);
            $order_dir = 'desc';
        }

        if (!in_array($order_by, $sortable)) {
            $order_by = 'id';
        }
        $collectionBuilder->orderBy($order_by, $order_dir);

        return $collectionBuilder;
    }

    /**
     * @param Builder $collectionBuilder
     * @param $filter
     * @return void
     */
    protected function setFiltering(Builder $collectionBuilder, $filter)
    {
        if ($query = $filter['query'] ?? false) {

            if (isset($query['with_trashed']) && (int)$query['with_trashed'] > 0) {
                $collectionBuilder->withTrashed();
            }

            if (isset($query['only_trashed']) && (int)$query['only_trashed'] > 0) {
                $collectionBuilder->onlyTrashed();
            }
        }
    }

    /**
     * @param $error
     * @param $status_code
     */
    protected function exception($error, $status_code)
    {
        $response = new JsonResponse([
            'message' => 'REPOSITORY ERROR',
            'errors' => [$error]
        ], $status_code);

        throw new HttpResponseException($response);
    }

    /**
     * @return array
     */
    abstract public function getAllowIncludes(): array;

}
