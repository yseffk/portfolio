<?php

namespace App\Services\EntityServices\Eloquent\Blog;

use App\Services\EntityServices\AbstractInstance;
use App\Services\EntityServices\Eloquent\Blog\Dto\BlogItemAttachmentDto;
use App\Services\EntityServices\Eloquent\Blog\Dto\BlogItemDto;
use App\Services\EntityServices\Eloquent\Blog\Dto\BlogPostDto;
use App\Services\EntityServices\Eloquent\Blog\UseCase\EntityBlogItemAttachmentService;
use App\Services\EntityServices\Eloquent\Blog\UseCase\EntityBlogItemService;
use App\Services\EntityServices\Eloquent\Blog\UseCase\EntityBlogPostService;

/**
 * @method EntityBlogPostService post()
 * @method EntityBlogItemService item()
 * @method EntityBlogItemAttachmentService itemAttachment()
 */
class BlogInstance extends AbstractInstance
{
    protected array $services = [
        'post'=>[
            'class'=>EntityBlogPostService::class,
            'dto'=>BlogPostDto::class,
        ],
        'item' => [
            'class' => EntityBlogItemService::class,
            'dto' => BlogItemDto::class,
        ],

        'itemAttachment' => [
            'class' => EntityBlogItemAttachmentService::class,
            'dto' => BlogItemAttachmentDto::class,
        ],
    ];

}
