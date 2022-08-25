<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Requests\BlogItemCreateRequest;
use App\Http\Requests\BlogItemUpdateRequest;
use App\Services\EntityServices\Eloquent\AbstractServiceFactory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;


/**
 * Class BlogItemController
 * @package App\Http\Controllers\Api\Admin
 */
class BlogItemController extends BaseController
{

    /**
     * Display a listing of the resource.
     * @Route("/api/admin/blog/items", methods={"GET"})
     *
     * @OA\Get (
     *     tags={"Admin Content"},
     *     path="/api/admin/blog/items",
     *     summary="Get Content Items  whith pagination",
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
     *         name="title",
     *         description="filtering by title ",
     *         in="query",
     *         required=false,
     *         example="Lorem..",
     *     ),
     *      @OA\Parameter(
     *         name="is_published",
     *         description="filtering by 'is published' flag",
     *         in="query",
     *         required=false,
     *         example="1",
     *     ),
     *      @OA\Parameter(
     *         name="is_free",
     *         description="filtering by 'is free' flag",
     *         in="query",
     *         required=false,
     *         example="1",
     *     ),
     *      @OA\Parameter(
     *         name="post_id",
     *         description="filtering by 'Month block item' ID",
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
     *         description="Per page limit",
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
     *          @OA\MediaType(
     *              mediaType="application/json",
     *          )
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
                'title' => $request->get('title', ''),
                'blog_post_id' => $request->get('post_id', false),
                'is_free' => $request->get('is_free', false),
                'is_published' => $request->get('is_published', false),
            ],
            'page' => $request->get('page', 1),
            'limit' => $request->get('limit', 15),
            'order_by' => $request->get('order_by', 'id'),
        ];
        $includes = [];
        $columns = ['*'];
        $repository  = $this->appServices()
            ->entity()
            ->blog()
            ->item()
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
     * @Route("/api/admin/blog/items", methods={"POST"})
     *
     * @OA\Post(
     *     tags={"Admin Content"},
     *     path="/api/admin/blog/items",
     *     summary="Create Content item.",
     *     security={
     *       {"bearer": {}}
     *     },
     *     @OA\RequestBody(
     *       @OA\JsonContent(
     *          type="object",
     *          required={"post_id", "title",  "is_published", "sort"},
     *          @OA\Property(
     *              property="post_id",
     *              type="integer",
     *              description="Type item ID",
     *              nullable=false
     *          ),
     *          @OA\Property(
     *              property="title",
     *              type="string",
     *              description="Item title",
     *              nullable=false
     *          ),
     *          @OA\Property(
     *              property="is_published",
     *              type="integer",
     *              description="Item published flag",
     *              nullable=false
     *          ),
     *          @OA\Property(
     *              property="sort",
     *              type="integer",
     *              description="sort",
     *              nullable=false
     *          ),
     *          @OA\Property(
     *              property="brief_content",
     *              type="string",
     *              description="",
     *              nullable=true
     *          ),
     *          @OA\Property(
     *              property="raw_content",
     *              type="string",
     *              description="",
     *              nullable=true
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
     * @param BlogItemCreateRequest $request
     * @return JsonResponse
     */
    public function store(BlogItemCreateRequest $request)
    {
        return new JsonResponse(
            $this->appServices()
                ->entity()
                ->blog()
                ->item()
                ->create($request->validated())
        );
    }

    /**
     * Display the specified resource.
     **
     * @Route("/api/admin/blog/items/{item}", methods={"GET"}, requirements={"item"})
     *
     * @OA\Get(
     *     tags={"Admin Content"},
     *     path="/api/admin/blog/items/{item}",
     *     summary="Show Content item.",
     *     security={
     *       {"bearer": {}}
     *     },
     *     @OA\Parameter(
     *         name="item",
     *         description="item ID",
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
                ->item()
                ->repository()
                ->find($id)->load('attachments')
        );
    }

    /**
     * @Route("/api/admin/blog/items/{item}?_method=PUT", methods={"POST"}, requirements={"item"})
     *
     * @OA\Post(
     *     tags={"Admin Content"},
     *     path="/api/admin/blog/items/{item}?_method=PUT",
     *     summary="Update Content item by ID.",
     *     security={
     *       {"bearer": {}}
     *     },
     *     @OA\RequestBody(
     *       @OA\JsonContent(
     *          type="object",
     *          required={"post_id", "title", "is_published", "sort"},
     *          @OA\Property(
     *              property="post_id",
     *              type="integer",
     *              description="Type item ID",
     *              nullable=false
     *          ),
     *          @OA\Property(
     *              property="title",
     *              type="string",
     *              description="Item title",
     *              nullable=false
     *          ),
     *          @OA\Property(
     *              property="is_published",
     *              type="integer",
     *              description="Item published flag",
     *              nullable=false
     *          ),
     *          @OA\Property(
     *              property="sort",
     *              type="integer",
     *              description="sort",
     *              nullable=false
     *          ),
     *          @OA\Property(
     *              property="brief_content",
     *              type="string",
     *              description="",
     *              nullable=true
     *          ),
     *          @OA\Property(
     *              property="raw_content",
     *              type="string",
     *              description="",
     *              nullable=true
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
     * @param BlogItemUpdateRequest $request
     * @param $id
     * @return JsonResponse
     */
    public function update(BlogItemUpdateRequest $request, $id)
    {
        return new JsonResponse(
            $this->appServices()
                ->entity()
                ->blog()
                ->item()
                ->update($id, $request->validated())
        );

    }

    /**
     * @Route("/api/admin/blog/items/{item}", methods={"DELETE"}, requirements={"item"})
     *
     * @OA\Delete (
     *     tags={"Admin Content"},
     *     path="/api/admin/blog/items/{item}",
     *     summary="Delete Content item by ID",
     *     security={
     *         {"bearer": {}}
     *     },
     *     @OA\Parameter(
     *         name="item",
     *         description="item ID",
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
                ->item()
                ->delete($id)
        );
    }

    /**
     * @Route("/api/admin/blog/items/{id}/change-publish", methods={"GET"}, requirements={"id"})
     *
     * @OA\Get (
     *     tags={"Admin Content"},
     *     path="/api/admin/blog/items/{id}/change-publish",
     *     summary="change item 'is_published' flag",
     *     @OA\Parameter(
     *         name="id",
     *         description="Item id",
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
     *     @OA\Response(
     *          response=404,
     *          description="Model not found",
     *          @OA\MediaType(
     *              mediaType="application/json",
     *          )
     *      ),
     * )
     * @param $id
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function changePublish($id): JsonResponse
    {
        $data = $this->BlogItemRepository->find($id);
        $data->is_published = ($data->is_published==1) ? 0 : 1;
        $data->save();
        return new JsonResponse($data);
    }
}
