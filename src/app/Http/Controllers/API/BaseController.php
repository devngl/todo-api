<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\MessageBag;

class BaseController extends Controller
{
    public function sendResponse(null|array|string $result, ?string $message = null, int $statusCode = 200): JsonResponse
    {
        $response = [
            'success' => true,
            'data'    => $result,
            'message' => $message,
        ];

        return new JsonResponse($response, $statusCode);
    }

    public function sendError($error, array|MessageBag $errorMessages = [], int $statusCode = 404): JsonResponse
    {
        $response = [
            'success' => false,
            'message' => $error,
        ];

        if (!empty($errorMessages)) {
            $response['data'] = $errorMessages;
        }

        return new JsonResponse($response, $statusCode);
    }
}
