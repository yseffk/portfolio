<?php

namespace App\Services\EntityServices\Eloquent;

use App\Services\ServicesApp;

/**
 *
 */
interface EntityActionServiceInterface
{
    /**
     * @param array $arguments
     * @return mixed
     */
    public function execute(array $arguments);

    /**
     * @param ServicesApp $servicesApp
     */
    public function setServicesApp(ServicesApp $servicesApp): void;
}
