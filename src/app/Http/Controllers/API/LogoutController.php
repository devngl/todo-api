<?php

namespace App\Http\Controllers\API;

use App\Repositories\Eloquent\Interfaces\CustomerRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class LogoutController extends BaseController
{
    public function __construct(private CustomerRepository $repository) { }

    public function __invoke(Request $request): JsonResponse
    {
        return $this->sendResponse([
            'info' => sprintf("%s session tokens deleted.", $this->repository->newInstance($request->user())->logout())
        ], 'OK', Response::HTTP_OK);
    }
}
