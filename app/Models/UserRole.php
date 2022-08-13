<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Spatie\Permission\Models\Role as SpatieRole;

/**
 *
 * @property integer $id
 * @property string $name
 * @property string $guard_name
 * @property bool $allow_for_public
 * @property string $description
 * @property string $created_at
 * @property string $updated_at
 */
class UserRole extends SpatieRole
{

    /**
     * Role allowed for public registration
     * @return bool
     */
    public function isAllowForPublic(): bool
    {
        return $this->allow_for_public;
    }

    public function users() : BelongsToMany
    {
        return $this->belongsToMany(User::class,'user', 'blog_item_id', 'blog_post_id');
    }
}
