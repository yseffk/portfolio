<?php


namespace App\Services\EntityServices\Eloquent;

use App\Repository\EloquentRepositoryInterface;
use App\Services\ServicesApp;
use Illuminate\Database\Eloquent\Model;
use Spatie\DataTransferObject\DataTransferObject;

/**
 * Class EntityAbstractService
 * @package App\Services\EntityServices\Eloquent
 */
abstract class EntityAbstractService
{
    /**
     * @var ServicesApp
     */
    private ServicesApp $servicesApp;


    protected  $dto;

    /**
     * @var Model
     */
    protected Model $entityModel;

    /**
     * @param array $arguments
     * @return Model
     */
    public function create(array $arguments): Model
    {
        /**
         * @var DataTransferObject $dto
         * @var Model $model
         */
        $dto = $this->prepareDtoData(new $this->dto($arguments));
        $model = $this->repository()->create($dto->toArray());
        $this->dto = $dto;
        return $model;
    }

    /**
     * @param int $id
     * @param array $arguments
     * @return Model
     */
    public function update(int $id, array $arguments): Model
    {
        /**
         * @var DataTransferObject $dto
         * @var Model $model
         */

        $dto = $this->prepareDtoData(new $this->dto($arguments));

        $model = $this->repository()->update($id, $dto->toArray());
        $this->dto = $dto;
        return $model;
    }

    /**
     * @param int $id
     * @return Model
     */
    public function delete(int $id): Model
    {
        $model = $this->repository()->delete($id);

        return $model;
    }

    /**
     * @param ServicesApp $servicesApp
     */
    public function setServicesApp(ServicesApp $servicesApp): void
    {
        $this->servicesApp = $servicesApp;
    }

    /**
     * @return ServicesApp
     */
    protected function abstract(): ServicesApp
    {
        return $this->servicesApp;
    }

    /**
     * @param  $dto
     */
    public function setDto($dto): void
    {
        $this->dto = $dto;
    }

    /**
     * @return EloquentRepositoryInterface
     */
    abstract public function repository(): EloquentRepositoryInterface;

    /**
     * @param DataTransferObject $data
     * @return DataTransferObject
     */
    protected function prepareDtoData(DataTransferObject $data): DataTransferObject
    {
        return $data;
    }
}
