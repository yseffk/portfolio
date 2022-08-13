<?php

namespace App\Http\Controllers\Api;

use \Symfony\Component\HttpFoundation\JsonResponse;
use App\Repository\BlogItemRepositoryInterface;

class BlogItemController extends BaseController
{

    protected BlogItemRepositoryInterface $BlogItemRepository;

    /**
     * BlogItemController constructor.
     * @param $BlogPostRepository
     */
    public function __construct(BlogItemRepositoryInterface $BlogItemRepository)
    {
        parent::__construct();

        $this->BlogItemRepository = $BlogItemRepository;
    }

    /**
     * @Route("/api/blog/items/{id}", methods={"GET"}, requirements={"id"})
     *
     * @OA\Get (
     *     tags={"showing"},
     *     path="/api/blog/items/{id}",
     *     summary="Get content item and attachments",
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
     * @return JsonResponse
     */
    public function show($id): JsonResponse
    {
        $data = $this->BlogItemRepository->find($id)->load('attachments');

        return new JsonResponse($data);
    }

}
