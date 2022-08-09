<?php

namespace App\Repository\Eloquent;

use App\Models\User;
use App\Repository\EloquentRepositoryInterface;
use App\Repository\UserRepositoryInterface;
use Illuminate\Database\Eloquent\Model;

class UserRepository extends BaseRepository
    implements
    UserRepositoryInterface,
    EloquentRepositoryInterface
{
    /**
     * UserRepository constructor.
     *
     * @param User $model
     */
    public function __construct(User $model)
    {
        parent::__construct($model);
    }

    /**
     * @return array
     */
    public function getAllowIncludes(): array
    {
        return self::ALLOW_INCLUDES;
    }

    /**
     * @param $id
     * @return User|null
     */
    public function findByEmail($email): ?User
    {
        return $this->collection()->where('email',  $email)->first();
    }
}
