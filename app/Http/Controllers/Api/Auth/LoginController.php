<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Api\BaseController;
use App\Http\Requests\LoginRequest;
use Illuminate\Http\JsonResponse;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Http\Request;

/**
 *
 */
class LoginController extends BaseController
{

    /**
     * @Route("/api/auth/login", methdos={"POST"}, requirements={
     *     "email": string,
     *     "password": string,
     * })
     *
     * @OA\Post (
     *     tags={"Auth"},
     *     path="/api/auth/login",
     *     description="Login",
     *     @OA\RequestBody(
     *       @OA\JsonContent(
     *          type="object",
     *          required={"password", "email"},

     *
     *              @OA\Property(
     *                  property="email",
     *                  type="string",
     *                  description="User email",
     *                  nullable=false
     *               ),
     *              @OA\Property(
     *                  property="password",
     *                  type="string",
     *                  description="User password",
     *                  nullable=false
     *
     *
     *              ),
     *
     *       ),
     *     ),
     *     @OA\Response(
     *       response="200",
     *       description="User is successfully logged in.",
     *       @OA\JsonContent(
     *         @OA\Property(
     *             property="token",
     *             type="string",
     *             nullable=false,
     *             example="eyJ0eXAiOiJKV1QiL.eyJpZCI6IjEzM.ZvkYYnx3_9rymsDAx9yuOcc1I",
     *             description="JWT token for user authorization."
     *          ),
     *          @OA\Property(
     *             property="user",
     *             type="object",
     *             nullable=false,
     *             description="User data."
     *          ),
     *       ),
     *     ),
     *     @OA\Response(
     *       response="400",
     *       description="Authentication error.",
     *       @OA\JsonContent(
     *          @OA\Property(
     *             property="message",
     *             type="string",
     *             nullable=false,
     *             example="Invalid email or password.",
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
     * @param LoginRequest $request
     * @return JsonResponse
     */
    public function login(LoginRequest $request): JsonResponse
    {
        return new JsonResponse(
            $this->appServices()
                ->action()
                ->signIn($request->validated())
        );
    }

    /**
     * @Route("/api/auth/logout/", methods={"POST"})
     *
     * @OA\Post (
     *     tags={"Auth"},
     *     path="/api/auth/logout/",
     *     summary="User logout",
     *     @OA\Response(
     *       response="200",
     *       description="User successfully signed out.",
     *       @OA\JsonContent(
     *         @OA\Property(
     *             property="message",
     *             type="string",
     *             nullable=false,
     *             example="",
     *             description=""
     *          ),
     *       ),
     *     ),
     *      @OA\Response(
     *          response=400,
     *          description="Invalid request"
     *      ),
     * )
     *
     * @return JsonResponse
     */
    public function logout(): JsonResponse
    {
        $this->appServices()
            ->action()
            ->logout();

        return new JsonResponse(['message' => 'User successfully signed out']);
    }

    /**
     * @Route("/api/auth/refresh/", methods={"POST"})
     *
     * @OA\Post (
     *     tags={"Auth"},
     *     path="/api/auth/refresh/",
     *     summary="User refresh JWT token",
     *     @OA\Response(
     *       response="200",
     *       description="User is successfully logged in.",
     *       @OA\JsonContent(
     *         @OA\Property(
     *             property="token",
     *             type="string",
     *             nullable=false,
     *             example="eyJ0eXAiOiJKV1QiL.eyJpZCI6IjEzM.ZvkYYnx3_9rymsDAx9yuOcc1I",
     *             description="JWT token for user authorization."
     *          ),
     *          @OA\Property(
     *             property="user",
     *             type="object",
     *             nullable=false,
     *             description="User data."
     *          ),
     *       ),
     *     ),
     *      @OA\Response(
     *          response=400,
     *          description="Invalid request"
     *      ),
     * )
     *
     * @return JsonResponse
     */
    public function refresh(): JsonResponse
    {
        return new JsonResponse(
            $this->appServices()
                ->action()
                ->refreshToken()
        );
    }



}
