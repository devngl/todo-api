<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\LoginRequest;
use App\Repositories\Eloquent\Interfaces\CustomerRepository;
use Auth;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

class LoginController extends BaseController
{
    public function __construct(private CustomerRepository $repository) { }

    public function __invoke(LoginRequest $request): JsonResponse
    {
        if (!Auth::guard('api')->attempt($request->only(['email', 'password']))) {
            return $this->sendError('Credentials mismatch.', statusCode: Response::HTTP_FORBIDDEN);
        }

        if ($customer = $this->repository->findByEmail($request['email'], ['id', 'email'])) {
            $token = $customer->createToken('API_TOKEN');
            return $this->sendResponse(['token' => $token->plainTextToken], statusCode: Response::HTTP_CREATED);
        }

        return $this->sendError('Customer with given email not found.');
    }
}
