<?php

namespace App\Http\Controllers\Api;

use App\Exceptions\WrongCredentialsException;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\TokenRequest;
use App\Models\Customer;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class CustomerController extends Controller
{
    /**
     * Display the specified resource.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function insert(Request $request)
    {

        $customer_id = $request->input('customer_id');
        $customer = Customer::query()->where("id", $customer_id)->first();

        if ($customer){
            $customer->fill($request->all());
            $customer->password = bcrypt($customer->password);
            $customer->save();
        } else {
            $customer = new Customer();
            $id = Customer::max("id") ?? 0;
            $customer->id = ($id + 1);
            $customer->fill($request->all());
            $customer->password = bcrypt($customer->password);
            $customer->save();
        }

        return response()->json([
            'customer' => $customer,
        ]);
    }
}
