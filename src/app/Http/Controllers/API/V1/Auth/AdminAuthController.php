<?php


namespace App\Http\Controllers\API\V1\Auth;

use App\Http\Controllers\API\V1\BaseController;
use App\Http\Requests\LoginRequest;
use App\Traits\ApiResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

class AdminAuthController extends BaseController
{
    use ApiResponse;

    /**
     * @OA\Post(
     *     path="/api/v1/admin/login",
     *     tags={"Admin"},
     *     summary="Login an Admin account",
     *     operationId="test",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\MediaType(
     *             mediaType="application/x-www-form-urlencoded",
     *             @OA\Schema(
     *                 required={"email", "password"},
     *                 @OA\Property(
     *                     property="email",
     *                     type="string",
     *                     description="Admin email"
     *                 ),
     *                 @OA\Property(
     *                     property="password",
     *                     type="string",
     *                     description="Admin password"
     *                 ),
     *                 example={"email": "john@petshop.com", "password": "john123"}
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="OK"
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Unauthorized"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Page not found"
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Unprocessable Entity"
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Internal server error"
     *     ),
     *     security={
     *         {"api_key": {}}
     *     }
     * )
     * @param LoginRequest $request
     * @return JsonResponse
     */
    public function login(LoginRequest $request)
    {
        $credentials = $request->validated();

        if(Auth::attempt($credentials)){
            $token = auth()->user()->generateToken();

            return $this->success(['token' => $token]);

        } else {

            return $this->error('Invalid username or password');

        }
    }
}
