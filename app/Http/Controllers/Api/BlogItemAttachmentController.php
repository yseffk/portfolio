<?php

namespace App\Http\Controllers\Api;

use App\Repository\BlogItemAttachmentRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class BlogItemAttachmentController extends BaseController
{

    protected BlogItemAttachmentRepositoryInterface $BlogItemAttachmentRepository;

    /**
     * BlogItemController constructor.
     * @param BlogItemAttachmentRepositoryInterface $BlogItemAttachmentRepository
     */
    public function __construct(BlogItemAttachmentRepositoryInterface $BlogItemAttachmentRepository)
    {
        parent::__construct();

        $this->BlogItemAttachmentRepository = $BlogItemAttachmentRepository;
    }

    /**
     * @Route("/api/blog/item-attachments/{id}", methods={"GET"}, requirements={"id"})
     *
     * @OA\Get (
     *     tags={"showing"},
     *     path="/api/blog/item-attachments/{id}",
     *     summary="Get item-attachment collection by id",
     *     @OA\Parameter(
     *         name="id",
     *         description="Item-attachment id",
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
     * @return JsonResponse
     */
    public function show($id): JsonResponse
    {
        $data = $this->BlogItemAttachmentRepository->getPublished($id);
        return new JsonResponse($data);
    }

    /**
     * Display a listing of the resource.
     * @Route("/api/blog/item-attachments", methods={"GET"})
     *
     * @OA\Get (
     *     tags={"showing"},
     *     path="/api/blog/item-attachments",
     *     summary="Get Content Item Attachments  whith pagination",
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
                'is_published' => 1,
            ],
            'page' => $request->get('page', 1),
            'limit' => $request->get('limit', 15),
            'order_by' => $request->get('order_by', 'id'),
        ];
        $includes = [];
        $columns = ['*'];
        $repository = $this->BlogItemAttachmentRepository;

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
