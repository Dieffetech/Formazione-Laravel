<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $customers = Customer::all();
        return view('customers.index', compact('customers'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $customer = new Customer();
        return view('customers.create', compact('customer'));
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|max:255',
            'surname' => 'required|max:255',
            'email' => 'required|email|unique:customers|max:255',
            'password' => (Customer::PASSWORD_VALIDATION),
            'status' => 'required|max:255',
        ]);

        $validatedData['password'] = bcrypt($validatedData['password']);

        Customer::create($validatedData);

        return redirect()->route('customers.index')
            ->with('success', 'Cliente creato con successo.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $customer = Customer::findOrFail($id);
        return view('customers.show', compact('customer'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $customer = Customer::findOrFail($id);
        return view('customers.edit', compact('customer'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $customer = Customer::findOrFail($id);

        $validatedData = $request->validate([
            'name' => 'required|max:255',
            'surname' => 'required|max:255',
            'email' => [
                'required',
                'email',
                Rule::unique('customers')->ignore($customer->id),
                'max:255'
            ],
            'password' => Customer::PASSWORD_VALIDATION,
            'status' => 'required|max:255',
        ]);

        $validatedData['password'] = bcrypt($validatedData['password']);

        $customer->update($validatedData);

        return redirect()->route('customers.index')
            ->with('success', 'Cliente aggiornato con successo.');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $customer = Customer::findOrFail($id);
        $customer->delete();

        return redirect()->route('customers.index')->with('success', 'Customer deleted successfully');
    }
}
