<?php


namespace App\Traits;


trait ApiResponse
{
    protected function success($data, $code=200)
    {
        return response()->json([
            'success'=> 1,
            'data' => $data,
            'error' => null,
            'errors' => [],
            'extra' => []
        ], $code);
    }

    protected function error(string $message, array $errors = [], array $trace = [], $code = 422)
    {
        return response()->json([
            'success' => 0,
            'data' => [],
            'error' => $message,
            'errors' => $errors,
            'trace' => $trace
        ], $code);
    }
}
