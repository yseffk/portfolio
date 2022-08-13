<?php

namespace App\Services\EntityServices;

use App\Services\EntityServices\Eloquent\Blog\BlogInstance;
use App\Services\EntityServices\Eloquent\Role\Dto\UserRoleDto;
use App\Services\EntityServices\Eloquent\Role\UseCase\EntityUserRoleService;
use App\Services\EntityServices\Eloquent\Shop\ShopInstance;
use App\Services\EntityServices\Eloquent\User\Dto\UserAddressDto;
use App\Services\EntityServices\Eloquent\User\Dto\UserDto;
use App\Services\EntityServices\Eloquent\User\Dto\UserProfileDto;
use App\Services\EntityServices\Eloquent\User\UseCase\EntityUserAddressService;
use App\Services\EntityServices\Eloquent\User\UseCase\EntityUserProfileService;
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
