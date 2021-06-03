<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\NewCustomerRequest;
use App\Repositories\Eloquent\CustomerRepository;
use Hash;
use Illuminate\Http\JsonResponse;

class RegisterController extends BaseController
{
    public function __construct(private CustomerRepository $repository) { }

    public function __invoke(NewCustomerRequest $request): JsonResponse
    {
        $customer = $this->repository->create([
            'name'     => $request['name'],
            'email'    => $request['email'],
            'password' => Hash::make($request['password']),
        ]);

        if (!$customer) {
            return $this->sendError(null, statusCode: 500);
        }

        return $this->sendResponse([
            'access_token' => $customer->createToken('API_TOKEN')->plainTextToken,
        ], 'Customer created.');
    }
}
