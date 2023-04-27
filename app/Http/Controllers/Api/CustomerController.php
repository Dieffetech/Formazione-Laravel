<?php

namespace App\Http\Controllers\Api;

use App\Exceptions\WrongCredentialsException;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\TokenRequest;
use App\Http\Requests\CustomerInsertRequest;
use App\Http\Resources\CustomerCollection;
use App\Models\Customer;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class CustomerController extends Controller
{
    /**
     * Display the specified resource.
     *
     * @param CustomerInsertRequest $request
     * @return JsonResponse
     */
    public function insert(CustomerInsertRequest $request)
    {

        $customer_id = $request->input('customer_id');
        $customer = Customer::query()->where("id", $customer_id)->first();

        if ($customer) {
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

    public function index(Request $request)
    {
        $customer = Customer::query()->where("status", "=", true)->get();

        return new CustomerCollection($customer);
    }

    public function delete($customer_id)
    {
        try {
            $customer_delete = Customer::findOrFail($customer_id);
            $customer_delete->delete();

            return response()->json([
                "message" => "Customer eliminato con successo"
            ]);

        } catch (ModelNotFoundException) {
            return response()->json([
                "error" => "Nessun Customer Trovato"
            ]);
        }
    }
}
