<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    public function index()
    {
        return view('pages.customers.index');
    }

    public function store(Request $request)
    {
        $request->validate([
            'fullname' => 'required',
            'phone' => 'required|numeric|digits:9|unique:customers',
            'birthday' => 'date',
        ]);
        $customer = Customer::create($request->all());
        return redirect()->route('customers.index')->with('success', 'Клиент успешно добавлен');
    }

    public function show(Customer $customer)
    {
        return view('pages.customers.show', compact('customer'));
    }

    public function update(Request $request, Customer $customer)
    {
        $request->validate([
            'fullname' => 'required',
            'phone' => 'required|numeric|digits:9',
            'birthday' => 'date',
        ]);
        $customer->update($request->all());
        return redirect()->back()->with('success', 'Клиент успешно обновлен');
    }


}

