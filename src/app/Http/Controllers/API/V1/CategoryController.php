<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Requests\CategoryRequest;
use App\Http\Resources\CategoryResource;
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

    /**
     * @OA\Put(
     *     path="/api/v1/category/{uuid}",
     *     tags={"Category"},
     *     summary="Update an exisitng category",
     *     @OA\Parameter(
     *          in="path",
     *          name="uuid",
     *          required=true,
     *          @OA\Schema(
     *              type="string"
     *          )
     *     ),
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
    public function edit(CategoryRequest $request, string $uuid): JsonResponse
    {
        //get data
        $data = $request->validated();

        //Get category using uuid
        $category = Category::uuid($uuid)->first();

        if (! isset($category->id)) {
            return $this->error('Category not found', 404);
        }

        //Update user
        $category->update($data);

        return $this->successWithJsonResource(CategoryResource::make($category->fresh()));
    }

    /**
     * @OA\Delete(
     *     path="/api/v1/category/{uuid}",
     *     tags={"Category"},
     *     summary="Delete an existing catetory",
     *     @OA\Parameter(
     *          in="path",
     *          name="uuid",
     *          required=true,
     *          @OA\Schema(
     *              type="string"
     *          )
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
     *
     * @param string $uuid
     *
     * @return JsonResponse
     */
    public function delete(string $uuid): JsonResponse
    {
        //Get category using uuid
        $category = Category::uuid($uuid)->first();

        if (! isset($category->id)) {
            return $this->error('Category not found', 404);
        }

        //Delete category
        $category->delete();

        return $this->success([]);
    }

    /**
     * @OA\Get(
     *     path="/api/v1/category/{uuid}",
     *     tags={"Category"},
     *     summary="Fetch a catetory",
     *     @OA\Parameter(
     *          in="path",
     *          name="uuid",
     *          required=true,
     *          @OA\Schema(
     *              type="string"
     *          )
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
     *
     * @param string $uuid
     *
     * @return JsonResponse
     */
    public function getByUuid(string $uuid): JsonResponse
    {
        //Get category using uuid
        $category = Category::uuid($uuid)->first();

        if (! isset($category->id)) {
            return $this->error('Category not found', 404);
        }

        return $this->successWithJsonResource(CategoryResource::make($category));
    }
}
