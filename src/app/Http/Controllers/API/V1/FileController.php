<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Requests\FileUploadRequest;
use App\Http\Resources\FileResource;
use App\Models\File;
use Illuminate\Http\JsonResponse;

class FileController extends BaseController
{
    /**
     * @OA\Post(
     *     path="/api/v1/file/upload",
     *     tags={"File"},
     *     summary="Upload a file",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\MediaType(
     *             mediaType="multipart/form-data",
     *             @OA\Schema(
     *                 type="object",
     *                 required={"file"},
     *                 @OA\Property(
     *                     property="file",
     *                     type="file",
     *                 ),
     *             ),
     *         ),
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
     * @param FileUploadRequest $request
     *
     * @return JsonResponse
     */
    public function fileUpload(FileUploadRequest $request): JsonResponse
    {
        $request->validated();

        $file = $request->file('file');
        $path = $file->store('images');

        $size = $file->getSize();

        $imageData = [
            'name' => $file->getClientOriginalName(),
            'path' => $path,
            'size' => number_format($size / 1024, 2) . ' KB',
            'type' => $file->getClientMimeType(),
        ];

        $file = File::create($imageData);

        return $this->successWithJsonResource(FileResource::make($file));
    }
}
