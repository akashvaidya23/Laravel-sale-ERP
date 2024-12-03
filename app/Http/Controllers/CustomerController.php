<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $customers = Customer::paginate(100);
        return view('customers.index', compact('customers'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('customers.create',);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email|unique:customers',
            'phone' => 'required|min:10|max:10|unique:customers',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $customer = new Customer();
        $customer->name = $request->name;
        $customer->email = $request->email;
        $customer->phone = $request->phone;
        $customer->save();
        return redirect()->route('customer.index')->with('success', 'Customer Created Successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(Customer $customer)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Customer $customer)
    {
        $customer = Customer::find($customer->id);
        return view('customers.edit', compact('customer'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Customer $customer)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email|unique:customers,email,' . $customer->id,
            'phone' => 'required|min:10|max:10|unique:customers,phone,' . $customer->id
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $customer = Customer::find($customer->id);
        $customer->name = $request->name;
        $customer->email = $request->email;
        $customer->phone = $request->phone;
        $customer->save();

        return redirect()->route('customer.index')->with('success', "Customer Updated Successfully");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Customer $customer)
    {
        $customer->find($customer->id)->delete();
        return redirect()->route('customer.index')->with('danger', 'Customer Deleted Successfully');
    }

    public function search(Request $request)
    {
        $search = $request->input('search_text');
        $customers = Customer::where(function ($query) use ($search) {
            $query->where('name', 'LIKE', '%' . $search . '%')
                ->orWhere('phone', 'like', '%' . $search . '%')
                ->orWhere('email', 'like', '%' . $search . '%');
        })->paginate(100);

        $output = '';
        foreach ($customers as $key => $customer) {
            $output .= "<tr>
                    <td style='border: 1px solid black; text-align:center;'>" . ($customers->firstItem() + $key) . "</td>
                    <td style='border: 1px solid black; text-align:center;'>{$customer->name}</td>
                    <td style='border: 1px solid black; text-align:center;'>{$customer->phone}</td>
                    <td style='border: 1px solid black; text-align:center;'>{$customer->email}</td>
                    <td style='border: 1px solid black; text-align:center;'>
                        <div class='action-buttons'>
                            <a class='btn btn-info' href='" . route('customer.edit', [$customer->id]) . "'>Edit</a>
                            <form action='" . route('customer.destroy', [$customer->id]) . "' method='POST' style='display: inline;'>
                                <input type='hidden' name='_token' value='" . csrf_token() . "'>
                                <input type='hidden' name='_method' value='DELETE'>
                                <button class='btn btn-danger' type='submit' onclick='return confirm(\"Are you sure you want to delete this customer?\")'>
                                    Delete
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>";
        }

        $paginationLinks = $customers->links()->render();

        return response()->json([
            'table' => $output,
            'pagination' => $paginationLinks,
        ]);
    }
}
