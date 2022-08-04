<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Requests\FileUploadRequest;
use App\Http\Resources\FileResource;
use App\Models\File;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\StreamedResponse;

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

    /**
     * @OA\Get(
     *     path="/api/v1/file/{uuid}",
     *     tags={"File"},
     *     summary="Read a file",
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
     * )
     *
     * @param string $uuid
     *
     * @return StreamedResponse|JsonResponse
     */
    public function readFile(string $uuid): StreamedResponse|JsonResponse
    {
        //Get file
        $file = File::uuid($uuid)->first();

        if (! isset($file->id)) {
            return $this->error('File not found', 404);
        }

        return Storage::disk('local')->download($file->path, $file->name);
    }
}
