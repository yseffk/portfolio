<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Api\BaseController;
use App\Http\Requests\UserCreateRequest;
use App\Services\EntityServices\Eloquent\AbstractServiceFactory;
use Illuminate\Http\JsonResponse;

/**
 *
 */
class RegisterController extends BaseController
{

    /**
     * @Route("/api/auth/register", methdos={"POST"})
     *
     * @OA\Post (
     *     tags={"Auth"},
     *     path="/api/auth/register",
     *     description="Register user",
     *     @OA\RequestBody(
     *       @OA\JsonContent(
     *          type="object",
     *          required={"first_name", "last_name", "email"},
     *          @OA\Property(
     *              property="first_name",
     *              type="string",
     *              description="User first name",
     *              nullable=false
     *          ),
     *           @OA\Property(
     *              property="last_name",
     *              type="string",
     *              description="User last name",
     *              nullable=false
     *          ),
     *           @OA\Property(
     *              property="email",
     *              type="string",
     *              description="User email",
     *              nullable=false
     *          ),
     *         @OA\Property(
     *              property="password",
     *              type="string",
     *              description="User password",
     *              nullable=true
     *          ),
     *         @OA\Property(
     *              property="phone",
     *              type="string",
     *              description="User phone",
     *              nullable=true
     *          ),
     *       ),
     *     ),
     *     @OA\Response(
     *       response="201",
     *       description="User is successfully register.",
     *     ),
     *     @OA\Response(
     *       response="400",
     *       description="Domain error.",
     *       @OA\JsonContent(
     *          @OA\Property(
     *             property="message",
     *             type="string",
     *             nullable=false,
     *             example="Domain error.",
     *             description="Error information."
     *          ),
     *          @OA\Property(
     *             property="errors",
     *             type="object",
     *             nullable=false,
     *             description="Object with all errors."
     *          ),
     *       ),
     *     ),
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
     *     ),
     * )
     *
     * @param UserCreateRequest $request
     * @return JsonResponse
     */
    public function register(UserCreateRequest $request): JsonResponse
    {
        return new JsonResponse(
            $this->appServices()
                ->action()
                ->register($request->validated()),
            201);
    }

}
