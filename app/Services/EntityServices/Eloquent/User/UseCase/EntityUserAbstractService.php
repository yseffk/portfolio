<?php

namespace App\Services\EntityServices\Eloquent\User\UseCase;

use App\Models\User;
use App\Repository\Eloquent\UserRepository;
use App\Repository\EloquentRepositoryInterface;
use App\Services\EntityServices\Eloquent\EntityAbstractService;
use App\Services\EntityServices\Eloquent\EntityServiceInterface;
use Illuminate\Contracts\Auth\Factory as AuthFactory;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\JsonResponse;

/**
 *
 */
abstract class EntityUserAbstractService extends EntityAbstractService implements EntityServiceInterface
{

    /**
     * @var UserRepository
     */
    protected UserRepository $userRepository;
    /**
     * @var AuthFactory
     */
    protected AuthFactory $authFactory;

    /**
     * @param UserRepository $userRepository
     * @param AuthFactory $authFactory
     */
    public function __construct(UserRepository $userRepository, AuthFactory $authFactory)
    {
        $this->userRepository = $userRepository;
        $this->authFactory = $authFactory;
    }

    /**
     * @return EloquentRepositoryInterface
     */
    public function repository(): EloquentRepositoryInterface
    {
        return $this->userRepository;
    }

    /**
     * @param $token
     * @return array
     */
    protected function tokenResponse($token): array
    {
        return [
            'token' => $token,
            'token_type' => 'bearer',
            'expires_in' => $this->authFactory->factory()->getTTL() * 60,
            'user' => $this->authUser()
        ];
    }

    /**
     * @return array
     */
    protected function refresh(): array
    {
        return $this->tokenResponse($this->authFactory->refresh());
    }

    /**
     * @return string
     */
    protected function getTokenFromUser(User $user): string
    {
        return $this->authFactory->fromUser($user);
    }

    /**
     * @param $error
     * @param $status_code
     */
    protected function exception($message, $error, $status_code)
    {
        $response = new JsonResponse([
            'message' => $message,
            'errors' => [$error]
        ], $status_code);

        throw new HttpResponseException($response);
    }

    public function authUser(): ?\Illuminate\Contracts\Auth\Authenticatable
    {
        return auth()->user();
    }
}
