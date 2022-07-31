<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Requests\CreateUserRequest;
use App\Http\Resources\UserWithTokenResource;
use App\Models\User;
use Illuminate\Http\JsonResponse;

class UserController extends BaseController
{
    /**
     * @OA\Post(
     *     path="/api/v1/user/create",
     *     tags={"User"},
     *     summary="Create an User account",
     *     @OA\RequestBody(ref="#/components/requestBodies/User"),
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
     *         {"bearerAuth": {}}
     *     }
     * )
     *
     * @param CreateUserRequest $request
     *
     * @return JsonResponse
     */
    public function create(CreateUserRequest $request)
    {
        $data = $request->validated();

        //create new user
        $user = User::create($data);

        return $this->successWithJsonResource(UserWithTokenResource::make($user));
    }
}
