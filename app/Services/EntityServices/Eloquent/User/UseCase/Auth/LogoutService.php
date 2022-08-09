<?php

namespace App\Services\EntityServices\Eloquent\User\UseCase\Auth;

use App\Services\EntityServices\Eloquent\EntityActionServiceInterface;
use App\Services\EntityServices\Eloquent\EntityServiceInterface;
use App\Services\EntityServices\Eloquent\User\UseCase\EntityUserAbstractService;

/**
 *
 */
class LogoutService extends EntityUserAbstractService
    implements
    EntityServiceInterface,
    EntityActionServiceInterface
{

    /**
     * @param array $arguments
     * @return mixed|void
     */
    public function execute(array $arguments)
    {
        $this->authFactory->logout();

    }
}
