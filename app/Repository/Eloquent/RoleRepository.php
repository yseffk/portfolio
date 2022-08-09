<?php


namespace App\Repository\Eloquent;

use App\Models\UserRole;
use App\Repository\EloquentRepositoryInterface;
use App\Repository\RoleRepositoryInterface;
use Illuminate\Database\Eloquent\Model;

class RoleRepository extends BaseRepository
    implements
    RoleRepositoryInterface,
    EloquentRepositoryInterface
{
    /**
     * UserRepository constructor.
     *
     * @param UserRole $model
     */
    public function __construct(UserRole $model)
    {
        parent::__construct($model);
    }

    /**
     * @param string $name
     * @return UserRole|Model|null
     */
    public function findByName(string $name): ?Model
    {
        if ($role = $this->getByName($name)) {
            return $role;
        }
        $this->exception("Role with name $name doesn't exist.", 400);
    }

    /**
     * @param string $name
     * @return UserRole|Model|null
     */
    protected function getByName(string $name): ?Model
    {
        return $this->collection()
            ->where([
                ['name', '=', $name],
            ])->first();
    }

    /**
     * @return array
     */
    public function getAllowIncludes(): array
    {
        return self::ALLOW_INCLUDES;
    }
}
