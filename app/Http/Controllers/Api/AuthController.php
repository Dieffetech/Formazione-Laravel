<?php

namespace App\Http\Controllers\Api;

use App\Exceptions\WrongCredentialsException;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\TokenRequest;
use App\Models\Customer;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    /**
     * @throws WrongCredentialsException
     */
    public function login(TokenRequest $request)
    {
        $customer = Customer::query()
            ->where('email', $request->email)
            ->first();

        if (!$customer || !Hash::check($request->password, $customer->password)) {
            throw new WrongCredentialsException();
        }

        return response()->json([
            'customer' => $customer,
            ...$customer->createAllAuthTokens("frontend"),
        ]);
    }
}
