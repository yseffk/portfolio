<?php

namespace App\Repository;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;

interface UserRepositoryInterface
{
    /**
     * @var array
     */
    const ALLOW_INCLUDES = [];

    public function findByEmail($email): ?User;
}
