<?php

namespace App\Services\EntityServices\Eloquent\Role\UseCase;

use App\Repository\Eloquent\PermissionRepository;
use App\Repository\EloquentRepositoryInterface;
use App\Services\EntityServices\Eloquent\EntityAbstractService;
use App\Services\EntityServices\Eloquent\EntityServiceInterface;
use Spatie\Permission\Models\Role;

class EntityRolePermissionService extends EntityAbstractService implements EntityServiceInterface
{
    protected PermissionRepository $permissionRepository;

    /**
     * @param PermissionRepository $permissionRepository
     */
    public function __construct(PermissionRepository $permissionRepository)
    {
        $this->permissionRepository = $permissionRepository;
    }

    /**
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    public function setForRole($role_name, $permission_name)
    {
        /**
         * @var Role $role
         */
        $role = $this->factory->role()->repository()->findByName($role_name);
        $permission = $this->repository()->findByName($permission_name);
        $role->syncPermissions($permission);
    }

    public function repository(): EloquentRepositoryInterface
    {
        return $this->permissionRepository;
    }
}
