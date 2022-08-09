<?php

namespace App\Services\EntityServices\Eloquent\User\Dto;

use Spatie\DataTransferObject\DataTransferObject;

/**
 *
 */
class UserDto extends DataTransferObject
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
    public  $email;

    /**
     * @var
     */
    public  $password;

    /**
     * @var
     */
    public  $email_verified_at;

    /**
     * @var
     */
    public  $created_at;

    /**
     * @var
     */
    public  $updated_at;
}
