<?php

namespace App\Services\EntityServices;


use App\Models\User;
use App\Services\EntityServices\Eloquent\Shop\UseCase\RecalculateOrderService;
use App\Services\EntityServices\Eloquent\User\Dto\UserDto;
use App\Services\EntityServices\Eloquent\User\Dto\UserRegisterDto;
use App\Services\EntityServices\Eloquent\User\UseCase\Auth\LogoutService;
use App\Services\EntityServices\Eloquent\User\UseCase\Auth\RefreshService;
use App\Services\EntityServices\Eloquent\User\UseCase\Auth\RegisterService;
use App\Services\EntityServices\Eloquent\User\UseCase\Auth\SignInService;
use App\Services\EntityServices\Eloquent\User\UseCase\Auth\TokenFromUserService;
use Illuminate\Database\Eloquent\Model;

/**
 * @method SignInService signIn(array $credentials)
 * @method Model register(array $arguments)
 * @method LogoutService logout()
 * @method RefreshService refreshToken()
 * @method TokenFromUserService tokenFromUser(array $arguments)
 * @method Model recalculateOrder(array $arguments)
 */
class ActionInstance extends AbstractInstance
{
    protected array $actions = [
        'recalculateOrder' => [
            'class' => RecalculateOrderService::class,
            'dto' => false,
        ],
        'signIn' => [
            'class' => SignInService::class,
            'dto' => false,
        ],
        'register' => [
            'class' => RegisterService::class,
            'dto' => UserRegisterDto::class,
        ],
        'logout' => [
            'class' => LogoutService::class,
            'dto' => false,
        ],
        'refreshToken' => [
            'class' => RefreshService::class,
            'dto' => false,
        ],
        'tokenFromUser' => [
            'class' => TokenFromUserService::class,
            'dto' => false,
        ],


    ];

}
