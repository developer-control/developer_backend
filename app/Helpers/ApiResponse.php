<?php

namespace App\Helpers;

class ApiResponse
{

    /**
     * Set response api success.
     * 
     * master default for set response api for success response
     *
     * @param  array $data
     * @param  string $message
     * @param  int $statusCode
     * @return \Illuminate\Http\JsonResponse
     */
    public static function success($data = null, $message = 'Success', $statusCode = 200)
    {
        return response()->json([
            'status' => 'success',
            'message' => $message,
            'data' => $data,
        ], $statusCode);
    }

    /**
     * Set response api failed.
     * 
     * master default for set response api for error response
     *
     * @param  string $message
     * @param  int $statusCode
     * @param  array $data
     * @return \Illuminate\Http\JsonResponse
     */
    public static function error($message = 'Error', $statusCode = 400, $data = null)
    {
        return response()->json([
            'status' => 'error',
            'message' => $message,
            'data' => $data,
        ], $statusCode);
    }
}
