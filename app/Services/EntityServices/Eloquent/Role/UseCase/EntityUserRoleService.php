<?php

namespace App\Services\EntityServices\Eloquent\Role\UseCase;

use App\Models\User;
use App\Repository\Eloquent\RoleRepository;
use App\Repository\EloquentRepositoryInterface;
use App\Services\EntityServices\Eloquent\EntityAbstractService;
use App\Services\EntityServices\Eloquent\EntityServiceInterface;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Models\Role;

class EntityUserRoleService extends EntityAbstractService implements EntityServiceInterface
{
    protected RoleRepository $roleRepository;

    /**
     * @param RoleRepository $roleRepository
     */
    public function __construct(RoleRepository $roleRepository)
    {
        $this->roleRepository = $roleRepository;
    }

    public function create(array $arguments): Model
    {
        /**
         * @var Role $model
         */
        $model = parent::create($arguments);
        $model->syncPermissions($arguments['permission']);
        return $model;

    }

    public function update(int $id, array $arguments): Model
    {
        /**
         * @var Role $model
         */
        $model = parent::update($id, $arguments);
        $model->syncPermissions($arguments['permission']);
        return $model;
    }

    /**
     * @throws BindingResolutionException
     */
    public function setForUser($user_id, $role_name)
    {
        /**
         * @var User $user
         */
        $user = $this->abstract()
            ->entity()
            ->user()
            ->repository()
            ->find($user_id);

        $role = $this->repository()->findByName($role_name);

        $user->spatieAssignRole($role);

    }
    public function repository(): EloquentRepositoryInterface
    {
        return $this->roleRepository;
    }
}
