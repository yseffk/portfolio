<?php

namespace App\Services\EntityServices;

use App\Services\EntityServices\Eloquent\Blog\BlogInstance;
use App\Services\EntityServices\Eloquent\Role\Dto\UserRoleDto;
use App\Services\EntityServices\Eloquent\Role\UseCase\EntityUserRoleService;
use App\Services\EntityServices\Eloquent\User\Dto\UserDto;
use App\Services\EntityServices\Eloquent\User\UseCase\EntityUserService;

/**
 * @method BlogInstance blog()
 * @method EntityUserService user()
 * @method EntityUserRoleService role()
 */
class EntityInstance extends AbstractInstance
{
    protected array $instances = [
        'blog' => BlogInstance::class,
    ];
    protected array $services = [
        'user' => [
            'class' => EntityUserService::class,
            'dto' => UserDto::class,
        ],
        'role' => [
            'class' => EntityUserRoleService::class,
            'dto' => UserRoleDto::class,
        ],

    ];


}
