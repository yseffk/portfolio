<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Requests\BlogPostCreateRequest;
use App\Http\Requests\BlogPostUpdateRequest;
use App\Services\EntityServices\Eloquent\AbstractServiceFactory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

/**
 * Class BlogPostController
 * @package App\Http\Controllers\Api\Admin
 */
class BlogPostController extends BaseController
{

    /**
     * Display a listing of the resource.
     * @Route("/api/admin/blog/posts", methods={"GET"})
     *
     * @OA\Get (
     *     tags={"Admin"},
     *     path="/api/admin/blog/posts",
     *     summary="Get posts  data whith pagination",
     *     security={
     *         {"bearer": {}}
     *     },
     *     @OA\Parameter(
     *         name="pagination",
     *         description="Need pagination",
     *         in="query",
     *         required=false,
     *         example="1"
     *     ),
     *      @OA\Parameter(
     *         name="is_published",
     *         description="filtering by 'is published' flag",
     *         in="query",
     *         required=false,
     *         example="1",
     *     ),
     *     @OA\Parameter(
     *         name="page",
     *         description="Page",
     *         in="query",
     *         required=false,
     *         example="1"
     *     ),
     *     @OA\Parameter(
     *         name="limit",
     *         description="Per page limit (default 12)",
     *         in="query",
     *         required=false,
     *         example="15"
     *     ),
     *     @OA\Parameter(
     *         name="order_by",
     *         description="Sort  list criteria. Allowed fields are: id, sort, created_at. Prepend '-' sign to revert order",
     *         in="query",
     *         required=false,
     *         example="-id"
     *     ),
     *     @OA\Response(
     *          response=200,
     *          description="Success",
     *          @OA\MediaType(mediaType="application/json",)
     *      ),
     *      @OA\Response( response=401,description="Unauthorized"),
     *      @OA\Response(response=403,description="Forbidden"),
     * )
     * @param Request $request
     * @return JsonResponse
     */
    public function index(Request $request): JsonResponse
    {
        $needPagination = $request->get('pagination', 1);
        $filter = [
            'query' => [
                'group' => $request->get('group', 'blog'),
                'is_published' => $request->get('is_published', false),
            ],
            'page' => $request->get('page', 1),
            'limit' => $request->get('limit', 12),
            'order_by' => $request->get('order_by', 'id'),
        ];
        $includes = [];
        $columns = ['*'];
        $repository =  $this->appServices()
            ->entity()
            ->blog()
            ->post()
            ->repository();
        if ($needPagination) {
            $data = $repository->getAllWithPagination($filter, $includes, $columns);
        } else {
            $data = $repository->getAll($filter, $includes);
        }
        return new JsonResponse(
            $data
        );
    }


}
