<?php

namespace App\Http\Controllers\Api;

use App\Exceptions\WrongCredentialsException;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\TokenRequest;
use App\Http\Requests\CustomerInsertRequest;
use App\Http\Resources\CustomerCollection;
use App\Models\Customer;
use App\Http\Resources\Customer as CustomerResource;
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
        $perPage = $request->input('perPage', 10);
        $search = $request->input('search');
        $query = Customer::paginate();

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'LIKE', "%$search%")
                    ->orWhere('surname', 'LIKE', "%$search%")
                    ->orWhere('email', 'LIKE', "%$search%");
            });
        }

        $customer = $query->paginate($perPage);

        return new CustomerCollection($customer);
    }

    public function show(Customer $customer, Request $request)
    {
        $return = [];
        $return["data"] = (new CustomerResource($customer))->toArray($request);

        return $return;
    }

    public function delete(Customer $customer)
    {
            $customer->delete();

            return response()->json([
                "message" => "Customer eliminato con successo"
            ]);
    }
}
