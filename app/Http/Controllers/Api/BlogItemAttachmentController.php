<?php

namespace App\Http\Controllers\Api;

use App\Repository\BlogItemAttachmentRepositoryInterface;
use \Symfony\Component\HttpFoundation\JsonResponse;

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
        $data = $this->BlogItemAttachmentRepository->find($id);
        return new JsonResponse($data);
    }


}
