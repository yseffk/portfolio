<?php


namespace App\Repository;

use Illuminate\Support\Collection;

interface BlogItemRepositoryInterface
{
    /**
     * @var array
     */
    const ALLOW_INCLUDES = [];

    /**
     *
     * @param $id
     * @return Collection
     */
    public function getPublishedWithLatestAttachment($id): Collection;

}
