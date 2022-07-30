<?php

namespace App\Traits;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\JsonResource;

trait ApiResponse
{
    /**
     * @param JsonResource $data
     *
     * @param int $code
     *
     * @return JsonResponse
     */
    protected function successWithJsonResource(JsonResource $data, int $code = 200): JsonResponse
    {
        return response()->json([
            'success'=> 1,
            'data' => $data,
            'error' => null,
            'errors' => [],
            'extra' => [],
        ], $code);
    }

    /**
     * @param array $data
     *
     * @param int $code
     *
     * @return JsonResponse
     */
    protected function success(array $data, int $code = 200): JsonResponse
    {
        return response()->json([
            'success'=> 1,
            'data' => $data,
            'error' => null,
            'errors' => [],
            'extra' => [],
        ], $code);
    }

    /**
     * @param string $message
     *
     * @param array $errors
     *
     * @param array $trace
     *
     * @param int $code
     *
     * @return JsonResponse
     */
    protected function error
    (
        string $message,
        array $errors = [],
        array $trace = [],
        int $code = 422
    ): JsonResponse
    {
        return response()->json([
            'success' => 0,
            'data' => [],
            'error' => $message,
            'errors' => $errors,
            'trace' => $trace,
        ], $code);
    }
}
