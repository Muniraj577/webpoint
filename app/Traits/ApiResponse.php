<?php

namespace App\Traits;

use Illuminate\Http\JsonResponse;

trait ApiResponse
{
    public function sendSuccessResponse($data, $statusCode = JsonResponse::HTTP_OK, $message = null): JsonResponse
    {
        return response()->json([
            'data' => $data,
            'status' => true,
            'statusCode' => $statusCode,
            'message' => $message,
        ]);
    }

    public function sendErrorResponse($statusCode = JsonResponse::HTTP_INTERNAL_SERVER_ERROR, $message = null): JsonResponse
    {
        return response()->json([
            'status' => false,
            'statusCode' => $statusCode,
            'message' => $message,
        ]);
    }
}
