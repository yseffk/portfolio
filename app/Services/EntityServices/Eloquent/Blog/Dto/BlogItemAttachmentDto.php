<?php


namespace App\Services\EntityServices\Eloquent\Blog\Dto;

use Spatie\DataTransferObject\DataTransferObject;

/**
 * Class BlogItemAttachmentDto
 * @package App\Services\EntityServices\Eloquent\Blog\Dto
 */
class BlogItemAttachmentDto extends DataTransferObject
{
    /**
     * @var bool
     */
    protected bool $ignoreMissing = true;

    /**
     * @var
     */
    public $blog_item_id;

    /**
     * @var
     */
    public $type;

    /**
     * @var
     */
    public $source;

    /**
     * @var
     */
    public $file_path;

}