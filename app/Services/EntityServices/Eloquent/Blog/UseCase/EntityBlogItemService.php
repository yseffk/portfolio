<?php

namespace App\Services\EntityServices\Eloquent\Blog\UseCase;

use App\Repository\Eloquent\BlogItemRepository;
use App\Repository\EloquentRepositoryInterface;
use App\Services\EntityServices\Eloquent\EntityAbstractService;
use App\Services\EntityServices\Eloquent\EntityServiceInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

/**
 * Class EntityBlogItemService
 * @package App\Services\EntityServices\Eloquent\Blog\UseCase
 */
class EntityBlogItemService extends EntityAbstractService implements EntityServiceInterface
{

    protected BlogItemRepository $BlogItemRepository;

    /**
     * EntityBlogItemService constructor.
     * @param $BlogItemRepository
     */
    public function __construct(BlogItemRepository $BlogItemRepository)
    {
        $this->BlogItemRepository = $BlogItemRepository;
    }


    /**
     * @param array $arguments
     * @return Model
     */
    public function create(array $arguments): Model
    {
        $model = parent::create($arguments);
dd($this->dto);
        if (is_int($this->dto->post_id)) {
            $data = [
                'blog_post_id' => $this->dto->post_id,
                'blog_item_id' => $model->id,
            ];
            DB::table('blog_post_blog_items')->insert($data);
        }

        return $model;

    }


    public function repository(): EloquentRepositoryInterface
    {
        return $this->BlogItemRepository;
    }
}
