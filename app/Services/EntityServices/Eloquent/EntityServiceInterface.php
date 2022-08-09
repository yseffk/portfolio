<?php


namespace App\Services\EntityServices\Eloquent;

use App\Repository\EloquentRepositoryInterface;
use App\Services\ServicesApp;
use Illuminate\Database\Eloquent\Model;
use Spatie\DataTransferObject\DataTransferObject;

/**
 * Interface EntityServiceInterface
 * @package App\Services\EntityServices\Eloquent
 */
interface EntityServiceInterface
{

    /**
     * @param array $arguments
     * @return Model
     */
    public function create(array $arguments): Model;

    /**
     * @param int $id
     * @param array $arguments
     * @return Model
     */
    public function update(int $id, array $arguments): Model;

    /**
     * @param int $id
     * @return Model
     */
    public function delete(int $id): Model;

    /**
     * @param ServicesApp $servicesApp
     */
    public function setServicesApp(ServicesApp $servicesApp): void;

    /**
     * @param DataTransferObject $dto
     */
    public function setDto(DataTransferObject $dto): void;

    /**
     * @return EloquentRepositoryInterface
     */
    public function repository(): EloquentRepositoryInterface;

}
