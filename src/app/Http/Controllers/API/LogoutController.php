<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class LogoutController extends BaseController
{
    public function __invoke(Request $request): JsonResponse
    {
        $request->user()->tokens()->delete();

        return $this->sendResponse(null, 'Tokens deleted', Response::HTTP_OK);
    }
}
