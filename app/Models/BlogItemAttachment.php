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

    /**
     * Append custom attributes.
     * @var string[]
     */
    protected $appends = [
        'file_url',
    ];

    public function item()
    {
        return $this->belongsTo(BlogItem::class, 'blog_item_id', 'id');
    }

    /**
     * @return null|string
     *
     */
    public function getFileUrlAttribute(): null|string
    {
        $return  = null;
        if($this->type == 'LINK'){
            $return = $this->file_path;
        }else{
            $return = url($this->file_path);
        }

        return $return;
    }
}
