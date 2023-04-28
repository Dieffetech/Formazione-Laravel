<?php

namespace App\Http\Controllers\Api;

use App\Exceptions\WrongCredentialsException;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\TokenRequest;
use App\Models\Customer;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    /**
     * @throws WrongCredentialsException
     */
    public function loginCustomer(TokenRequest $request)
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

    public function loginUser(TokenRequest $request)
    {
        $user = User::query()
            ->where('email', $request->email)
            ->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            throw new WrongCredentialsException();
        }

        return response()->json([
            'user' => $user,
            ...$user->createAllAuthTokens("frontend"),
        ]);
    }
}
