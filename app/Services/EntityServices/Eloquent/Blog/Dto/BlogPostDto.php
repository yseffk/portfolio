<?php


namespace App\Services\EntityServices\Eloquent\Blog\Dto;

use Spatie\DataTransferObject\DataTransferObject;

/**
 * Class BlogPostDto
 * @package App\Services\EntityServices\Eloquent\Blog\Dto
 */
class BlogPostDto extends DataTransferObject
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
    public $slug;

    /**
     * @var
     */
    public $group;

    /**
     * @var
     */
    public $is_published;

}