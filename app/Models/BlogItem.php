<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class BlogItem
 * @package App\Models
 *
 * @property  integer id
 * @property string title
 * @property string brief_content
 * @property string raw_content
 * @property string html_content
 * @property string file_path
 * @property boolean is_free
 * @property boolean is_published
 * @property string external_url
 * @property integer duration
 * @property integer sort
 * @property string created_at
 * @property string updated_at
 * @property string deleted_at
 */
class BlogItem extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'title',
        'brief_content',
        'raw_content',
        'is_published',
        'published_at',
        'sort'
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
    ];

    public function posts()
    {
        return $this->belongsToMany(BlogPost::class, 'blog_post_blog_items', 'blog_item_id', 'blog_post_id');
    }

    public function attachments()
    {
        return $this->hasMany(BlogItemAttachment::class);
    }

    public function latestAudio()
    {
        return $this->hasOne(BlogItemAttachment::class)->ofMany([
            'id' => 'max',
        ], function ($query) {
            $query->where('type', '=', 'AUDIO');
        });
    }

    public function latestVideo()
    {
        return $this->hasOne(BlogItemAttachment::class)->ofMany([
            'id' => 'max',
        ], function ($query) {
            $query->where('type', '=', 'VIDEO');
        });
    }

    public function latestText()
    {
        return $this->hasOne(BlogItemAttachment::class)->ofMany([
            'id' => 'max',
        ], function ($query) {
            $query->where('type', '=', 'TEXT');
        });
    }

    public function latestNotes()
    {
        return $this->hasOne(BlogItemAttachment::class)->ofMany([
            'id' => 'max',
        ], function ($query) {
            $query->where('type', '=', 'NOTES');
        });
    }

    public function latestImg()
    {
        return $this->hasOne(BlogItemAttachment::class)->ofMany([
            'id' => 'max',
        ], function ($query) {
            $query->where('type', '=', 'IMG');
        });
    }

}
