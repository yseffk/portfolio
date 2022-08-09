<?php


namespace App\Repository;

use Illuminate\Support\Collection;

interface BlogPostRepositoryInterface
{
    /**
     * @var array
     */
    const ALLOW_INCLUDES = [];

    public function getPublishedByGroup(string $group): Collection;

    public function getPublishedBySlug(string $slug): Collection;
}
