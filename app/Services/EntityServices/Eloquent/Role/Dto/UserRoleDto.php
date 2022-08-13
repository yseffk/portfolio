<?php

namespace App\Services\EntityServices\Eloquent\Role\Dto;

use Spatie\DataTransferObject\DataTransferObject;

/**
 *
 */
class UserRoleDto extends DataTransferObject
{
    /**
     * @var bool
     */
    protected bool $ignoreMissing = true;

    /**
     * @var
     */
    public  $name;
    /**
     * @var
     */
    public  $guard_name;

    /**
     * @var
     */
    public  $allow_for_public;

    /**
     * @var
     */
    public  $description;

    /**
     * @var
     */
    public  $permission = [];

    /**
     * @var
     */
    public  $created_at;

    /**
     * @var
     */
    public  $updated_at;
}
