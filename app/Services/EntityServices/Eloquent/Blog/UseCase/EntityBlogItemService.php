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
        $model->html_content = htmlspecialchars($model->raw_content);
        $model->save();
        if (!empty($this->dto->post_id)) {
            $data = [
                'blog_post_id' => $this->dto->post_id,
                'blog_item_id' => $model->id,
            ];
            DB::table('blog_post_blog_items')->insert($data);
        }

        return $model;

    }
    public function update(int $id, array $arguments): Model
    {
        $model = parent::update($id, $arguments);
        $model->html_content = htmlspecialchars($model->raw_content);
        $model->save();

        return $model;
    }

    public function delete(int $id): Model
    {
        $model = $this->repository()->find($id)->load('attachments');
        foreach ($model->attachments as $attachment){
            $this->abstract()
                ->entity()
                ->blog()
                ->itemAttachment()
                ->delete($attachment->id);
        }
        return parent::delete($id);
    }

    public function repository(): EloquentRepositoryInterface
    {
        return $this->BlogItemRepository;
    }

}
