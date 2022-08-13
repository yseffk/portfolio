<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Requests\BlogPostCreateRequest;
use App\Http\Requests\BlogPostUpdateRequest;
use App\Services\EntityServices\Eloquent\AbstractServiceFactory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

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

    /**
     * @Route("/api/admin/blog/posts", methods={"POST"})
     *
     * @OA\Post(
     *     tags={"Admin"},
     *     path="/api/admin/blog/posts",
     *     summary="Create post.",
     *     security={
     *       {"bearer": {}}
     *     },
     *     @OA\RequestBody(
     *       @OA\JsonContent(
     *          type="object",
     *          required={"title", "is_published", "sort"},
     *          @OA\Property(
     *              property="title",
     *              type="string",
     *              description="Post title",
     *              nullable=false
     *          ),
     *          @OA\Property(
     *              property="is_published",
     *              type="integer",
     *              description="Post published flag",
     *              nullable=false
     *          ),
     *          @OA\Property(
     *              property="sort",
     *              type="integer",
     *              description="sort",
     *              nullable=false
     *          ),

     *       ),
     *     ),
     *     @OA\Response(
     *       response="200",
     *      description="Success",
     *       @OA\JsonContent(
     *       ),
     *     ),
     *     @OA\Response(response=401, description="Unauthorized"),
     *     @OA\Response(response=403,description="Forbidden"),
     *     @OA\Response(
     *       response="422",
     *       description="Request validation error.",
     *       @OA\JsonContent(
     *          @OA\Property(
     *             property="message",
     *             type="string",
     *             nullable=false,
     *             example="The given data was invalid.",
     *             description="Validation information."
     *          ),
     *          @OA\Property(
     *             property="errors",
     *             type="object",
     *             nullable=false,
     *             description="Object with all errors."
     *          ),
     *       ),
     *    ),
     *  )
     * @param BlogPostCreateRequest $request
     * @return JsonResponse
     */
    public function store(BlogPostCreateRequest $request)
    {
        $data = $request->validated();
        $data['group'] = 'portfolio';
        return new JsonResponse(
            $this->appServices()
                ->entity()
                ->blog()
                ->post()
                ->create($data)
        );
    }

    /**
     * Display the specified resource.
     **
     * @Route("/api/admin/blog/posts/{id}", methods={"GET"}, requirements={"id"})
     *
     * @OA\Get(
     *     tags={"Admin"},
     *     path="/api/admin/blog/posts/{id}",
     *     summary="Show post.",
     *     security={
     *       {"bearer": {}}
     *     },
     *     @OA\Parameter(
     *         name="post",
     *         description="post id",
     *         in="path",
     *         required=true
     *     ),
     *     @OA\Response(
     *       response="200",
     *       description="Success",
     *          @OA\MediaType(
     *              mediaType="application/json",
     *          )
     *       ),
     *      @OA\Response(
     *          response=401,
     *          description="Unauthorized"
     *      ),
     *      @OA\Response(
     *          response=403,
     *          description="Forbidden"
     *      ),
     *      @OA\Response(
     *          response=404,
     *          description="not found"
     *      ),
     *
     *  )
     * @param int $id
     * @return JsonResponse
     */
    public function show($id)
    {
        return new JsonResponse(
            $this->appServices()
                ->entity()
                ->blog()
                ->post()
                ->repository()
                ->find($id)
        );
    }

    /**
     * @Route("/api/admin/blog/posts/{post}?_method=PUT", methods={"POST"}, requirements={"post"})
     *
     * @OA\Post(
     *     tags={"Admin"},
     *     path="/api/admin/blog/posts/{post}?_method=PUT",
     *     summary="Update Month block item.",
     *     security={
     *       {"bearer": {}}
     *     },
     *     @OA\RequestBody(
     *       @OA\JsonContent(
     *          type="object",
     *          required={"title", "is_published", "sort"},
     *          @OA\Property(
     *              property="title",
     *              type="string",
     *              description="Post title",
     *              nullable=false
     *          ),
     *          @OA\Property(
     *              property="is_published",
     *              type="integer",
     *              description="Post published flag",
     *              nullable=false
     *          ),
     *          @OA\Property(
     *              property="sort",
     *              type="integer",
     *              description="sort",
     *              nullable=false
     *          ),
     *       ),
     *     ),
     *     @OA\Response(
     *       response="200",
     *       description="Success",
     *       @OA\JsonContent(
     *       ),
     *     ),
     *     @OA\Response(response=401, description="Unauthorized"),
     *     @OA\Response(response=403,description="Forbidden"),
     *     @OA\Response(response=404, description="Model not found",),
     *     @OA\Response(
     *       response="422",
     *       description="Request validation error.",
     *       @OA\JsonContent(
     *          @OA\Property(
     *             property="message",
     *             type="string",
     *             nullable=false,
     *             example="The given data was invalid.",
     *             description="Validation information."
     *          ),
     *          @OA\Property(
     *             property="errors",
     *             type="object",
     *             nullable=false,
     *             description="Object with all errors."
     *          ),
     *       ),
     *    ),
     *  )
     * @param BlogPostUpdateRequest $request
     * @param $id
     * @return JsonResponse
     */
    public function update(BlogPostUpdateRequest $request, $id)
    {
        $data = $request->validated();
        $data['group'] = 'portfolio';
        return new JsonResponse(
            $this->appServices()
                ->entity()
                ->blog()
                ->post()
                ->update($id, $data)
        );
    }

    /**
     * @Route("/api/admin/blog/posts/{post}", methods={"DELETE"}, requirements={"post"})
     *
     * @OA\Delete (
     *     tags={"Admin"},
     *     path="/api/admin/blog/posts/{post}",
     *     summary="Delete post ID",
     *     security={
     *         {"bearer": {}}
     *     },
     *     @OA\Parameter(
     *         name="post",
     *         description="post ID",
     *         in="path",
     *         required=true
     *     ),
     *     @OA\Response(
     *          response=200,
     *          description="Success",
     *          @OA\MediaType(
     *              mediaType="application/json",
     *          )
     *      ),
     *      @OA\Response(
     *          response=401,
     *          description="Unauthorized"
     *      ),
     *      @OA\Response(
     *          response=403,
     *          description="Forbidden"
     *      ),
     *      @OA\Response(
     *          response=404,
     *          description="not found"
     *      ),
     * )
     * @param $id
     * @return JsonResponse
     */
    public function destroy($id)
    {
        return new JsonResponse(
            $this->appServices()
                ->entity()
                ->blog()
                ->post()
                ->delete($id)
        );
    }
}
