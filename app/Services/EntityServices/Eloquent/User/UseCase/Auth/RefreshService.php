<?php

namespace App\Services\EntityServices\Eloquent\User\UseCase\Auth;

use App\Services\EntityServices\Eloquent\EntityActionServiceInterface;
use App\Services\EntityServices\Eloquent\EntityServiceInterface;
use App\Services\EntityServices\Eloquent\User\UseCase\EntityUserAbstractService;

/**
 *
 */
class RefreshService extends EntityUserAbstractService
    implements
    EntityServiceInterface,
    EntityActionServiceInterface
{

    /**
     * @param array $arguments
     * @return array
     */
    public function execute(array $arguments): array
    {
        return $this->refresh();
    }
}
