<?php


namespace App\Repository\Eloquent;

use App\Repository\BlogItemAttachmentRepositoryInterface;
use App\Models\BlogItemAttachment;
use App\Repository\EloquentRepositoryInterface;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

class BlogItemAttachmentRepository extends BaseRepository
    implements
    BlogItemAttachmentRepositoryInterface,
    EloquentRepositoryInterface
{
    const SORTABLE = ['id', ];
    /**
     * UserRepository constructor.
     *
     * @param BlogItemAttachment $model
     */
    public function __construct(BlogItemAttachment $model)
    {
        parent::__construct($model);
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

            if (($query['type'] ?? false) && in_array($query['type'],BlogItemAttachment::TYPES )) {
                $collectionBuilder->where('type', '=', $query['type']);
            }

            if (($query['source'] ?? false) && in_array($query['source'],BlogItemAttachment::SOURCES )) {
                $collectionBuilder->where('source', '=', $query['source']);
            }
            if ($query['blog_item_id'] ?? false) {
                $collectionBuilder->where('blog_item_id', '=', (int)$query['blog_item_id']);
            }
            if ((int)$query['is_published'] ?? false) {
                $collectionBuilder->whereRelation('item', 'is_published', '=', (int)$query['is_published']);
            }

        }
    }

    public function getPublished($id): Collection
    {
        $data = $this->collection()->where([
            ['id', '=', $id],
        ])
            ->whereRelation('item', 'is_published', '=', 1)
            ->first();

        if (!$data) {
            $message = 'Published ' . get_class($this->model) . " with ID $id doesn't exist.";

            $this->exception($message, 404);
        }

        return collect($data);
    }

    /**
     * @return array
     */
    public function getAllowIncludes(): array
    {
        return self::ALLOW_INCLUDES;
    }
}
