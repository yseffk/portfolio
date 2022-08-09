<?php


namespace App\Repository\Eloquent;

use App\Models\UserPermission;
use App\Models\UserRole;
use App\Repository\EloquentRepositoryInterface;
use App\Repository\RoleRepositoryInterface;
use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Models\Permission;

class PermissionRepository extends BaseRepository
    implements
    RoleRepositoryInterface,
    EloquentRepositoryInterface
{
    /**
     * UserRepository constructor.
     *
     * @param UserPermission $model
     */
    public function __construct(UserPermission $model)
    {
        parent::__construct($model);
    }

    /**
     * @param string $name
     * @return UserPermission|Model|null
     */
    public function findByName(string $name): ?UserPermission
    {
        if ($role = $this->getByName($name)) {
            return $role;
        }
        $this->exception("Permission with name $name doesn't exist.", 400);
    }

    /**
     * @param string $name
     * @return UserPermission|Model|null
     */
    protected function getByName(string $name): ?UserPermission
    {
        return $this->collection()
            ->where([
                ['name', '=', $name],
            ])->first();
    }

    /**
     * Get or create permission
     * @param string $name
     * @return \Spatie\Permission\Contracts\Permission
     */
    public function getOrCreate(string $name): \Spatie\Permission\Contracts\Permission
    {
        return Permission::findOrCreate($name);
    }

    /**
     * @return array
     */
    public function getAllowIncludes(): array
    {
        return self::ALLOW_INCLUDES;
    }
}
