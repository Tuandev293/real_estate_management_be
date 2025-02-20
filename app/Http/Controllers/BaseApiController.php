<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class BaseApiController
{
    /**
     * Return a successful JSON response.
     *
     * @param mixed $data
     * @param string $message
     * @param int $statusCode
     *
     * @return JsonResponse
     */
    protected function success($data = [], string $message = 'Success', int $statusCode = Response::HTTP_OK)
    {
        return response()->json([
            'status'  => 'success',
            'message' => $message,
            'data'    => $data,
        ], $statusCode);
    }

    /**
     * Return an error JSON response.
     *
     * @param string $message
     * @param array $errors
     * @param int $statusCode
     *
     * @return JsonResponse
     */
    protected function error(string $message = 'Error', array $errors = [], int $statusCode = Response::HTTP_BAD_REQUEST)
    {
        return response()->json([
            'status'  => 'error',
            'message' => $message,
            'errors'  => $errors,
        ], $statusCode);
    }
}
