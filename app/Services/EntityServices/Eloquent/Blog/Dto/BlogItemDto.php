<?php


namespace App\Services\EntityServices\Eloquent\Blog\Dto;

use Spatie\DataTransferObject\DataTransferObject;

/**
 * Class BlogItemDto
 * @package App\Services\EntityServices\Eloquent\Blog\Dto
 */
class BlogItemDto extends DataTransferObject
{
    /**
     * @var bool
     */
    protected bool $ignoreMissing = true;

    /**
     * @var
     */
    public $title;

    /**
     * @var
     */
    public $brief_content;

    /**
     * @var
     */
    public $raw_content;

    /**
     * @var
     */
    public $is_free;

    /**
     * @var
     */
    public $is_published;

    /**
     * @var
     */
    public $external_url;

    /**
     * @var
     */
    public $duration = 0;

    /**
     * @var
     */
    public $sort = 0;

    /**
     * @var
     */
    public $post_id;

}
