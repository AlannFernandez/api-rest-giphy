<?php

namespace App\Traits;

use Illuminate\Http\JsonResponse;

trait Response
{
    /**
     * Returns a successful response.
     *
     * @param mixed $data The response data.
     * @param string $message The response message.
     * @param int $code The HTTP status code.
     * @return \Illuminate\Http\JsonResponse
     */
    protected function successResponse($data, $message = 'Success', $code = 200): JsonResponse
    {
        return response()->json([
            'success' => true,
            'message' => $message,
            'data' => $data,
        ], $code);
    }

   /**
     * Returns an error response.
     *
     * @param string $message The response message.
     * @param int $code The HTTP status code.
     * @param mixed $data Additional data for the response.
     * @return \Illuminate\Http\JsonResponse
     */
    protected function errorResponse($message, $code = 400, $data = null): JsonResponse
    {
        $response = [
            'success' => false,
            'message' => $message,
        ];

        if ($data) {
            $response['data'] = $data;
        }

        return response()->json($response, $code);
    }
}
