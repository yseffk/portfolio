<?php

namespace App\Services\EntityServices\Eloquent\Blog\UseCase;

use App\Repository\Eloquent\BlogPostRepository;
use App\Repository\EloquentRepositoryInterface;
use App\Services\EntityServices\Eloquent\EntityAbstractService;
use App\Services\EntityServices\Eloquent\EntityServiceInterface;


/**
 * Class EntityBlogPostService
 * @package App\Services\EntityServices\Eloquent\Blog\UseCase
 */
class EntityBlogPostService extends EntityAbstractService implements EntityServiceInterface
{

    protected BlogPostRepository $BlogPostRepository;

    /**
     * EntityBlogPostService constructor.
     * @param BlogPostRepository $BlogPostRepository
     */
    public function __construct(BlogPostRepository $BlogPostRepository)
    {
        $this->BlogPostRepository = $BlogPostRepository;
    }

    /**
     * @return EloquentRepositoryInterface
     */
    public function repository(): EloquentRepositoryInterface
    {
        return $this->BlogPostRepository;
    }
}