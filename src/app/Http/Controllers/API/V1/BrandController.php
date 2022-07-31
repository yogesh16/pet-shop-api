<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Requests\BrandRequest;
use App\Http\Resources\BrandResource;
use App\Models\Brand;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class BrandController extends BaseController
{
    /**
     * @OA\Post(
     *     path="/api/v1/brand/create",
     *     tags={"Brand"},
     *     summary="Create a new brand",
     *     @OA\RequestBody(ref="#/components/requestBodies/Brand"),
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
     * @param BrandRequest $request
     *
     * @return JsonResponse
     */
    public function create(BrandRequest $request): JsonResponse
    {
        $data = $request->validated();

        $brand = Brand::create($data);

        return $this->success(['uuid' => $brand->uuid]);
    }

    /**
     * @OA\Put(
     *     path="/api/v1/brand/{uuid}",
     *     tags={"Brand"},
     *     summary="Update an exisitng brand",
     *     @OA\Parameter(
     *          in="path",
     *          name="uuid",
     *          required=true,
     *          @OA\Schema(
     *              type="string"
     *          )
     *     ),
     *     @OA\RequestBody(ref="#/components/requestBodies/Brand"),
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
     * @param BrandRequest $request
     *
     * @return JsonResponse
     */
    public function edit(BrandRequest $request, string $uuid): JsonResponse
    {
        //get data
        $data = $request->validated();

        //Get brand using uuid
        $brand = Brand::uuid($uuid)->first();

        if (! isset($brand->id)) {
            return $this->error('Brand not found', 404);
        }

        //Update brand
        $brand->update($data);

        return $this->successWithJsonResource(BrandResource::make($brand->fresh()));
    }

    /**
     * @OA\Delete(
     *     path="/api/v1/brand/{uuid}",
     *     tags={"Brand"},
     *     summary="Delete an existing brand",
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
        $brand = Brand::uuid($uuid)->first();

        if (! isset($brand->id)) {
            return $this->error('Brand not found', 404);
        }

        //Delete category
        $brand->delete();

        return $this->success([]);
    }

    /**
     * @OA\Get(
     *     path="/api/v1/brand/{uuid}",
     *     tags={"Brand"},
     *     summary="Fetch a brand",
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
        $brand = Brand::uuid($uuid)->first();

        if (! isset($brand->id)) {
            return $this->error('Brand not found', 404);
        }

        return $this->successWithJsonResource(BrandResource::make($brand));
    }

    /**
     * @OA\Get(
     *     path="/api/v1/brands",
     *     tags={"Brand"},
     *     summary="List all brands",
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
    public function brandListing(Request $request): JsonResponse
    {
        $perPage = $request->has('limit') ? $request->input('limit') : 10;

        //get query builder
        $brands = Brand::filter($request);

        //get paginated data
        $data = $brands->paginate($perPage);

        return response()->json($data, 200);
    }
}
