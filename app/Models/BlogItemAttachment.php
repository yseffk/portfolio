<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Class BlogItemAttachment
 * @package App\Models
 *
 * @property integer id
 * @property integer blog_item_id
 * @property string type
 * @property string source
 * @property string file_path
 */
class BlogItemAttachment extends Model
{
    use HasFactory;

    const TYPES = ['IMG', 'NOTES', 'TEXT', 'VIDEO', 'AUDIO'];

    const SOURCES = ['LINK', 'FILE',];

    public $timestamps = false;

    protected $fillable = [
        'blog_item_id',
        'type',
        'source',
        'file_path'
    ];

    public function item()
    {

        return $this->belongsTo(BlogItem::class, 'blog_item_id', 'id');

    }
}
