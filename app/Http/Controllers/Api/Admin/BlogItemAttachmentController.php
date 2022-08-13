<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Requests\BlogItemAttachmentCreateRequest;
use App\Http\Requests\BlogItemAttachmentUpdateRequest;
use App\Repository\BlogItemAttachmentRepositoryInterface;
use App\Services\EntityServices\Eloquent\AbstractServiceFactory;
use App\Services\ServicesApp;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

/**
 * Class BlogItemAttachmentController
 * @package App\Http\Controllers\Api\Admin
 */
class BlogItemAttachmentController extends BaseController
{

    /**
     * Display a listing of the resource.
     * @Route("/api/admin/blog/item-attachments", methods={"GET"})
     *
     * @OA\Get (
     *     tags={"Admin Content Attachment"},
     *     path="/api/admin/blog/item-attachments",
     *     summary="Get Content Item Attachments  whith pagination",
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
     *         name="blog_item_id",
     *         description="filtering by 'Content Item ID",
     *         in="query",
     *         required=false,
     *         example="1",
     *     ),
     *      @OA\Parameter(
     *         name="source",
     *         description="filtering by source. enum('LINK','FILE') ",
     *         in="query",
     *         required=false,
     *         example="LINK",
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
    public function index(Request $request)
    {
        $needPagination = $request->get('pagination', 1);
        $filter = [
            'query' => [
                'blog_item_id' => $request->get('blog_item_id', false),
                'type' => 'IMG',
                'source' => $request->get('source', false),
            ],
            'page' => $request->get('page', 1),
            'limit' => $request->get('limit', 15),
            'order_by' => $request->get('order_by', 'id'),
        ];
        $includes = [];
        $columns = ['*'];
        $repository = $this->appServices()
            ->entity()
            ->blog()
            ->itemAttachment()
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
     * @Route("/api/admin/blog/item-attachments", methods={"POST"})
     *
     * @OA\Post(
     *     tags={"Admin Content Attachment"},
     *     path="/api/admin/blog/item-attachments",
     *     summary="Create Content Item Attachment.",
     *     security={
     *       {"bearer": {}}
     *     },
     *     @OA\RequestBody(
     *       @OA\JsonContent(
     *          type="object",
     *          required={"blog_item_id", "source", "file_path"},
     *          @OA\Property(
     *              property="blog_item_id",
     *              type="integer",
     *              description="blogItem ID",
     *              nullable=false
     *          ),
     *          @OA\Property(
     *              property="source",
     *              type="integer",
     *              description="Item Attach Source.  enum('LINK','FILE')",
     *              nullable=false
     *          ),
     *          @OA\Property(
     *              property="file_path",
     *              type="string",
     *              format="binary",
     *              nullable=false,
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
     * @param BlogItemAttachmentCreateRequest $request
     * @return JsonResponse
     */
    public function store(BlogItemAttachmentCreateRequest $request)
    {
        $data = $request->validated();
        $data['type'] = 'IMG';
        return new JsonResponse(
            $this->appServices()
                ->entity()
                ->blog()
                ->itemAttachment()
                ->create($data)
        );
    }

    /**
     * Display the specified resource.
     **
     * @Route("/api/admin/blog/item-attachments/{id}", methods={"GET"}, requirements={"id"})
     *
     * @OA\Get(
     *     tags={"Admin Content Attachment"},
     *     path="/api/admin/blog/item-attachments/{id}",
     *     summary="Show Content item Attachment.",
     *     security={
     *       {"bearer": {}}
     *     },
     *     @OA\Parameter(
     *         name="id",
     *         description="itemAttachment ID",
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
                ->itemAttachment()
                ->repository()
                ->find($id)
        );
    }

    /**
     * @Route("/api/admin/blog/item-attachments/{id}?_method=PUT", methods={"POST"}, requirements={"id"})
     *
     * @OA\Post(
     *     tags={"Admin Content Attachment"},
     *     path="/api/admin/blog/item-attachments/{id}?_method=PUT",
     *     summary="Update Content Item Attachment by ID.",
     *     security={
     *       {"bearer": {}}
     *     },
     *     @OA\RequestBody(
     *       @OA\JsonContent(
     *          type="object",
     *          required={"blog_item_id", "source", "file_path"},
     *          @OA\Property(
     *              property="blog_item_id",
     *              type="integer",
     *              description="Content Item ID",
     *              nullable=false
     *          ),
     *          @OA\Property(
     *              property="source",
     *              type="integer",
     *              description="Item Attach Source.  enum('LINK','FILE')",
     *              nullable=false
     *          ),
     *          @OA\Property(
     *              property="file_path",
     *              type="string",
     *              format="binary",
     *              nullable=false,
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
     * @param BlogItemAttachmentUpdateRequest $request
     * @param $id
     * @return JsonResponse
     */
    public function update(BlogItemAttachmentUpdateRequest $request, $id)
    {
        $data = $request->validated();
        $data['type'] = 'IMG';
        return new JsonResponse(
            $this->appServices()
                ->entity()
                ->blog()
                ->itemAttachment()
                ->update($id, $data)
        );

    }

    /**
     * Display the specified resource.
     **
     * @Route("/api/admin/blog/item-attachments/{id}", methods={"DELETE"}, requirements={"id"})
     *
     * @OA\Delete(
     *     tags={"Admin Content Attachment"},
     *     path="/api/admin/blog/item-attachments/{id}",
     *     summary="Delete Content item Attachment by ID.",
     *     security={
     *       {"bearer": {}}
     *     },
     *     @OA\Parameter(
     *         name="id",
     *         description="itemAttachment ID",
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
     * @param $id
     * @return JsonResponse
     */
    public function destroy($id)
    {
        return new JsonResponse(
            $this->appServices()
                ->entity()
                ->blog()
                ->itemAttachment()
                ->delete($id)
        );
    }

}
