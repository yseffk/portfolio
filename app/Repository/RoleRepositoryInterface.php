<?php


namespace App\Repository;



use Illuminate\Database\Eloquent\Model;

interface RoleRepositoryInterface
{
    /**
     * @var array
     */
    const ALLOW_INCLUDES = [];

    public function findByName(string $name): ?Model;

}
