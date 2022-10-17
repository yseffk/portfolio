<?php


namespace App\Repository\Eloquent;

use App\Repository\BlogItemRepositoryInterface;
use App\Models\BlogItem;
use App\Repository\EloquentRepositoryInterface;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

class BlogItemRepository extends BaseRepository
    implements
    BlogItemRepositoryInterface,
    EloquentRepositoryInterface
{
    const SORTABLE = ['id', 'sort', 'published_at'];

    /**
     * UserRepository constructor.
     *
     * @param BlogItem $model
     */
    public function __construct(BlogItem $model)
    {
        parent::__construct($model);
    }


    public function getPublishedWithAttachment($id)
    {
        $data = $this->collection()->where([
            ['id', '=', $id],
            ['is_published', '=', 1],
        ])
            ->with(['attachments',])
            ->first();

        if (!$data) {
            $message = 'Published ' . get_class($this->model) . " with ID $id doesn't exist.";

            $this->exception($message, 404);
        }

        return $data;
    }

    /**
     * @param Builder $collectionBuilder
     * @param $filter
     * @return void
     */
    protected function setFiltering(Builder $collectionBuilder, $filter)
    {
        parent::setFiltering($collectionBuilder, $filter);

        if ($query = $filter['query'] ?? false) {

            if ($query['title'] ?? false) {
                $collectionBuilder->where('title', 'LIKE', $query['title'] . '%');
            }
            if ($query['is_free'] ?? false) {
                $collectionBuilder->where('is_free', '=', (int)$query['is_free']);
            }
            if ($query['is_published'] ?? false) {
                $collectionBuilder->where('is_published', '=', (int)$query['is_published']);
            }
            if ((int)$query['blog_post_id'] ?? false) {
                $collectionBuilder->whereRelation('posts', 'blog_post_id', '=', (int)$query['blog_post_id']);
            }
        }
    }

    /**
     * @return array
     */
    public function getAllowIncludes(): array
    {
        return self::ALLOW_INCLUDES;
    }
}
