<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class BlogPost
 * @package App\Models
 *
 * @property integer id
 * @property integer user_id
 * @property string title
 * @property string slug
 * @property string group
 * @property boolean is_published
 * @property string published_at
 * @property string created_at
 * @property string updated_at
 * @property string deleted_at
 */
class BlogPost extends Model
{
    use HasFactory, SoftDeletes;

    const GROUPS = ['CALENDAR', 'www'];

    protected $fillable = [
        'title',
        'slug',
        'group',
        'is_published'
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
    ];

    public function items()
    {
        return $this->belongsToMany(BlogItem::class, 'blog_post_blog_items', 'blog_post_id', 'blog_item_id');
    }
}
