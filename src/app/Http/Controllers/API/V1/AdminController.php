<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Requests\AdminUserEditRequest;
use App\Http\Requests\CreateAdminRequest;
use App\Http\Resources\CreateAdminResource;
use App\Http\Resources\UserResource;
use App\Models\User;
use App\Traits\ApiResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AdminController extends BaseController
{
    use ApiResponse;

    /**
     * @OA\Post(
     *     path="/api/v1/admin/create",
     *     tags={"Admin"},
     *     summary="Create an Admin account",
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
     * @param CreateAdminRequest $request
     *
     * @return JsonResponse
     */
    public function create(CreateAdminRequest $request)
    {
        $data = $request->validated();

        $data['is_admin'] = 1;
        $data['password'] = Hash::make($data['password']);

        //create new user
        $user = User::create($data);

        return $this->successWithJsonResource(CreateAdminResource::make($user));
    }

    /**
     * @OA\Get(
     *     path="/api/v1/admin/user-listing",
     *     tags={"Admin"},
     *     summary="List all users",
     *     @OA\Parameter(
     *          in="query",
     *          name="page",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *     ),
     *     @OA\Parameter(
     *          in="query",
     *          name="limit",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *     ),
     *     @OA\Parameter(
     *          in="query",
     *          name="sortBy",
     *          @OA\Schema(
     *              type="string"
     *          )
     *     ),
     *     @OA\Parameter(
     *          in="query",
     *          name="desc",
     *          @OA\Schema(
     *              type="boolean"
     *          )
     *     ),
     *     @OA\Parameter(
     *          in="query",
     *          name="first_name",
     *          @OA\Schema(
     *              type="string"
     *          )
     *     ),
     *     @OA\Parameter(
     *          in="query",
     *          name="email",
     *          @OA\Schema(
     *              type="string"
     *          )
     *     ),
     *     @OA\Parameter(
     *          in="query",
     *          name="phone",
     *          @OA\Schema(
     *              type="string"
     *          )
     *     ),
     *     @OA\Parameter(
     *          in="query",
     *          name="address",
     *          @OA\Schema(
     *              type="string"
     *          )
     *     ),
     *     @OA\Parameter(
     *          in="query",
     *          name="created_at",
     *          @OA\Schema(
     *              type="string"
     *          )
     *     ),
     *     @OA\Parameter(
     *          in="query",
     *          name="marketing",
     *          @OA\Schema(
     *              type="string"
     *          ),
     *          description="Marketing possible value: 0 or 1"
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
     *         {"bearerAuth": {}}
     *     }
     * )
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function userListing(Request $request): JsonResponse
    {
        $perPage = $request->has('limit') ? $request->input('limit') : 10;

        //get query builder
        $users = User::filter($request)->notAdmin();

        //get paginated data
        $data = $users->paginate($perPage);

        return response()->json($data, 200);
    }

    /**
     * @OA\Put(
     *     path="/api/v1/admin/user-edit/{uuid}",
     *     tags={"Admin"},
     *     summary="Edit a User account",
     *     @OA\Parameter(
     *          in="path",
     *          name="uuid",
     *          required=true,
     *          @OA\Schema(
     *              type="string"
     *          )
     *     ),
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
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function userEdit(AdminUserEditRequest $request, string $uuid): JsonResponse
    {
        //get user data
        $data = $request->validated();

        //Get non admin user using uuid
        $user = User::uuid($uuid)->notAdmin()->first();

        if(! isset($user->id))
        {
            return $this->error('User not found',404);
        }

        //Update user
        $user->update($data);

        return $this->successWithJsonResource(UserResource::make($user->fresh()));
    }
}
