<?php

namespace App\Http\Controllers\Api;


use App\Repository\BlogItemRepositoryInterface;
use App\Repository\BlogPostRepositoryInterface;
use Illuminate\Http\Request;
use \Symfony\Component\HttpFoundation\JsonResponse;

class BlogPostController extends BaseController
{


    protected BlogPostRepositoryInterface $BlogPostRepository;
    protected BlogItemRepositoryInterface $blogItemRepository;

    public function __construct(
        BlogPostRepositoryInterface $BlogPostRepository,
        BlogItemRepositoryInterface $blogItemRepository
    )
    {
        $this->blogItemRepository = $blogItemRepository;
        $this->BlogPostRepository = $BlogPostRepository;
        parent::__construct();


    }

    /**
     * @Route("/api/blog/posts/blog", methods={"GET"})
     *
     * @OA\Get (
     *     tags={"showing"},
     *     path="/api/blog/posts/blog",
     *     summary="Get blog items published data by slug.  ",
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
     *         description="Sort  list criteria. Allowed fields are: id, sort, published_at. Prepend '-' sign to revert order",
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
     *     @OA\Response(
     *          response=404,
     *          description="Model not found",
     *          @OA\MediaType(
     *              mediaType="application/json",
     *          )
     *      ),
     * )
     *
     * @param string $slug
     * @param Request $request
     * @return JsonResponse
     */

    public function show(string $slug, Request $request)
    {
        $post = $this->BlogPostRepository->getPublishedBySlug($slug);
        $filter = [
            'query' => [
                'blog_post_id' => $post->get('id'),
                'is_published' => 1,
            ],
            'page' => $request->get('page', 1),
            'limit' => $request->get('limit', 15),
            'order_by' => $request->get('order_by', '-published_at'),
        ];
        $post['items'] = $this->blogItemRepository->getAllWithPagination($filter, ['attachments'], ['*']);
        return new JsonResponse(
            $post
        );

    }

    /**
     * @Route("/api/blog/posts/gallery", methods={"GET"})
     *
     * @OA\Get (
     *     tags={"showing"},
     *     path="/api/blog/posts/gallery",
     *     summary="Get gallery items published data by slug.  ",
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
     *         description="Sort  list criteria. Allowed fields are: id, sort, published_at. Prepend '-' sign to revert order",
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
     *     @OA\Response(
     *          response=404,
     *          description="Model not found",
     *          @OA\MediaType(
     *              mediaType="application/json",
     *          )
     *      ),
     * )
     *
     * @param string $slug
     * @param Request $request
     * @return JsonResponse
     */
    public function show2(string $slug, Request $request)
    {
        return new JsonResponse([]);
    }
}
