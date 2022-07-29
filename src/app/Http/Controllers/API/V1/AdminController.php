<?php


namespace App\Http\Controllers\API\V1;


use App\Http\Requests\CreateAdminRequest;
use App\Http\Requests\LoginRequest;
use App\Models\User;
use App\Traits\ApiResponse;
use Illuminate\Http\JsonResponse;
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
     * @return JsonResponse
     */
    public function create(CreateAdminRequest $request)
    {
        $data = $request->validated();

        $data['is_admin'] = 1;
        $data['password'] = Hash::make($data['password']);
        $user = User::create($data);

        $user->token = $user->generateToken();

        return $this->success($user);
    }
}
