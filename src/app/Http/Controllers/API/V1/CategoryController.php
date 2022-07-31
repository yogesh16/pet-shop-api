<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Requests\CategoryRequest;
use App\Http\Resources\CategoryResource;
use App\Models\Category;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

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
     *     )
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

    /**
     * @OA\Get(
     *     path="/api/v1/categories",
     *     tags={"Category"},
     *     summary="List all categories",
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
     *     )
     * )
     *
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function categoryListing(Request $request): JsonResponse
    {
        $perPage = $request->has('limit') ? $request->input('limit') : 10;

        //get query builder
        $categories = Category::filter($request);

        //get paginated data
        $data = $categories->paginate($perPage);

        return response()->json($data, 200);
    }
}
