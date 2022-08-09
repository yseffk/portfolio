<?php

namespace App\Services\EntityServices\Eloquent\User\Dto;

use Spatie\DataTransferObject\DataTransferObject;

/**
 *
 */
class UserRegisterDto extends DataTransferObject
{
    /**
     * @var bool
     */
    protected bool $ignoreMissing = true;

    /**
     * @var
     */
    public  $first_name;

    /**
     * @var
     */
    public  $last_name;

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
    public  $phone;


}
