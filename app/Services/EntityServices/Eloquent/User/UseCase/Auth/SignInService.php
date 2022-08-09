<?php

namespace App\Services\EntityServices\Eloquent\User\UseCase\Auth;

use App\Services\EntityServices\Eloquent\EntityActionServiceInterface;
use App\Services\EntityServices\Eloquent\EntityServiceInterface;
use App\Services\EntityServices\Eloquent\User\UseCase\EntityUserAbstractService;

/**
 *
 */
class SignInService extends EntityUserAbstractService
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
        $token = $this->authFactory->attempt($arguments);
        if (!$token) {
            $this->exception('Authentication error', 'user::auth.failed', 401);
        }

        return $this->tokenResponse($token);
    }
}
