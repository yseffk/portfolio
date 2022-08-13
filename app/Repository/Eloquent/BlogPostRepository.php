<?php


namespace App\Repository\Eloquent;

use App\Repository\BlogPostRepositoryInterface;
use App\Models\BlogPost;
use App\Repository\EloquentRepositoryInterface;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;

class BlogPostRepository extends BaseRepository
    implements
    BlogPostRepositoryInterface,
    EloquentRepositoryInterface
{
    const SORTABLE = ['id', 'sort', 'created_at'];

    /**
     * UserRepository constructor.
     *
     * @param BlogPost $model
     */
    public function __construct(BlogPost $model)
    {
        parent::__construct($model);
    }

    /**
     * @param string $group
     * @return Collection
     */
    public function getPublishedByGroup(string $group): Collection
    {
        $group = Str::upper($group);

        $data = $this->collection()
            ->where([
                ['group', '=', $group],
                ['is_published', '=', 1],
            ])
            ->orderBy('sort')
            ->get();

        return collect($data);

    }

    /**
     * @param string $slug
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getPublishedBySlug(string $slug): Collection
    {
        $slug = Str::lower($slug);

        $data = $this->collection()
            ->where([
                ['slug', '=', $slug],
                ['is_published', '=', 1],
            ])
            ->first();
        if(!$data){
            $message = get_class($this->model) . " with slug $slug doesn't exist.";
            $this->exception($message, 404);
        }
        return collect($data);
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

            if ($query['group'] ?? false) {
                $collectionBuilder->where('group',  $query['group']);
            }
            if ($query['is_published'] ?? false) {
                $collectionBuilder->where('is_published', '=', (int)$query['is_published']);
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
