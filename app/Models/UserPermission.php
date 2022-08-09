<?php

namespace App\Models;

use Spatie\Permission\Models\Permission;

/**
 *
 * @property integer $id
 * @property string $name
 * @property string $guard_name
 * @property string $description
 * @property string $created_at
 * @property string $updated_at
 */
class UserPermission extends Permission
{

}
