<?php


namespace App\Services\EntityServices\Eloquent;

use Illuminate\Contracts\Container\BindingResolutionException;
use LogicException;
use Spatie\DataTransferObject\DataTransferObject;


/**
 * Class EntityServiceFactoryOld
 * @package App\Services\EntityServices\Eloquent
 */
abstract class AbstractServiceFactory
{
    /**
     * @param $service
     * @return EntityServiceInterface
     * @throws BindingResolutionException
     */
    protected function createService($service): EntityServiceInterface
    {
        /**
         * @var EntityServiceInterface $serviceObj
         */

        $serviceObj = app()->make($service);


        if (!$serviceObj instanceof EntityServiceInterface) {
            throw new LogicException('ENTITY SERVICE FACTORY ERROR!. Service ' . $service . ' not implement ' . __NAMESPACE__ . '\EntityServiceInterface');

        }

        return $serviceObj;
    }

    /**
     * @param $service
     * @param $dto
     * @return EntityServiceInterface
     * @throws BindingResolutionException
     */
    protected function createServiceWithDto($service, $dto): EntityServiceInterface
    {
        $serviceObj = $this->createService($service);
        /**
         * @var DataTransferObject $dtoObj
         */



        if (!$dtoObj instanceof DataTransferObject) {
            throw new LogicException('ENTITY SERVICE FACTORY ERROR!. DTO for ' . $service . ' not found');
        }

        $serviceObj->setDto($dto);

        return $serviceObj;
    }

    /**
     * @param $service
     * @param bool $dto
     * @return EntityActionServiceInterface
     * @throws BindingResolutionException
     */
    protected function createActionService($service,  $dto = false): EntityActionServiceInterface
    {
        if (false === $dto) {
            $serviceObj = $this->createService($service);
        } else {
            $serviceObj = $this->createServiceWithDto($service, $dto);
        }

        if (!$serviceObj instanceof EntityActionServiceInterface) {
            throw new LogicException('ENTITY SERVICE FACTORY ERROR!. Service ' . $service . ' not implement ' . __NAMESPACE__ . '\EntityActionServiceInterface');

        }

        return $serviceObj;
    }

}
