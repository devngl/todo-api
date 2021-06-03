<?php

namespace App\Http\Controllers\API;

use App\Models\Customer;
use Hash;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Throwable;

class RegisterController extends BaseController
{
    /**
     * @throws Throwable
     */
    public function __invoke(Request $request): JsonResponse
    {
        $validatedData = $request->validate([
            'name'     => ['required', 'string', 'max:255'],
            'email'    => ['required', 'string', 'email', 'unique:customers,email'],
            'password' => ['required', 'string', 'min:5', 'confirmed'],
        ]);

        $customer = Customer::create([
            'name'     => $validatedData['name'],
            'email'    => $validatedData['email'],
            'password' => Hash::make($validatedData['password']),
        ]);

        return $this->sendResponse([
            'access_token' => $customer->createToken('API_TOKEN')->plainTextToken,
        ]);
    }
}
