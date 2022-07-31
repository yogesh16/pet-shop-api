<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Requests\CategoryRequest;
use App\Models\Category;
use Illuminate\Http\JsonResponse;

class CategoryController extends BaseController
{
    /**
     * @OA\Post(
     *     path="/api/v1/category/create",
     *     tags={"Category"},
     *     summary="Create a new category",
     *     @OA\RequestBody(ref="#/components/requestBodies/Category"),
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
     * @param CategoryRequest $request
     *
     * @return JsonResponse
     */
    public function create(CategoryRequest $request): JsonResponse
    {
        $data = $request->validated();

        $category = Category::create($data);

        return $this->success(['uuid' => $category->uuid]);
    }
}
