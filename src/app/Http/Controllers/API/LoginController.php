<?php

namespace App\Http\Controllers\API;

use App\Models\Customer;
use Auth;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class LoginController extends BaseController
{
    public function __invoke(Request $request): JsonResponse
    {
        $credentials = $request->validate([
            'email'    => ['required', 'string', 'email'],
            'password' => ['required', 'string', 'min:5'],
            'remember' => ['sometimes', 'boolean']
        ]);

        if (!Auth::guard('api')->attempt($request->only(['email', 'password']), $request->get('remember', false))) {
            return $this->sendError('Credentials mismatch.', statusCode: Response::HTTP_FORBIDDEN);
        }

        $customer = Customer::firstWhere('email', $credentials['email']);

        return $this->sendResponse([
            'token' => $customer->createToken('API_TOKEN')->plainTextToken
        ], Response::HTTP_CREATED);
    }
}
