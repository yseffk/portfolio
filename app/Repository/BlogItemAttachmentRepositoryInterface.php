<?php


namespace App\Repository;



use Illuminate\Support\Collection;

interface BlogItemAttachmentRepositoryInterface
{
    /**
     * @var array
     */
    const ALLOW_INCLUDES = [];

    /**
     *
     * @param $id
     */
    public function getPublished($id);
}
