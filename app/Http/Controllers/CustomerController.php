<?php

namespace App\Http\Controllers;

// Import model Customer
use App\Models\Customer;

// Import return type View
use Illuminate\View\View;

// Import return type RedirectResponse
use Illuminate\Http\RedirectResponse;

// Import Http Request
use Illuminate\Http\Request;
//YAJRA
use Yajra\DataTables\Facades\DataTables;

class CustomerController extends Controller
{
    //DATATABLE
    public function getDatatable(Request $request)
    {
        $customers = \App\Models\Customer::query();

        return \DataTables::of($customers)
            ->addIndexColumn()
            ->addColumn('actions', function($row) {
                return view('customers.partials.actions', compact('row'))->render();
            })
            ->addColumn('created_at', function($row) {
                return $row->created_at ? $row->created_at->format('d-m-Y H:i') : '';
            })
            // Tambahkan orderColumn untuk created_at:
            ->orderColumn('created_at', function ($query, $order) {
                $query->orderBy('created_at', $order);
            })
            ->rawColumns(['actions'])
            ->make(true);
    }

    //CUSTOMER PAGE
    public function index(): View
    {
        // Get all customers
        $customers = Customer::orderBy('created_at', 'desc')->paginate(10);

        // Render view with customers
        return view('customers.index', compact('customers'));
    }

    //ADD CUSTOMER
    public function store(Request $request): RedirectResponse
    {

        // Validate form
        $request->validate([
            'customer_id'             => 'required',
            'customer_name'           => 'required',
            'customer_description'    => 'required',
            'customer_address'        => 'required',
            'customer_phone'          => 'required',
            'customer_email'          => 'required|email',
            'customer_website'        => 'nullable|url|max:255', // Field ini opsional
        ]);

        // Create customer
        Customer::create([
            'customer_id'             => $request->customer_id,
            'customer_name'           => $request->customer_name,
            'customer_description'    => $request->customer_description,
            'customer_address'        => $request->customer_address,
            'customer_phone'          => $request->customer_phone,
            'customer_email'          => $request->customer_email,
            'customer_website'        => $request->customer_website,
            

        ]);

        // Redirect to index
        return redirect()->route('customers.index')->with('success', 'Customer added successfully!');
    }

    /**
     * Show Customer
     *
     * @param  string $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        $customer = Customer::where('customer_id', $id)->first();

        if (!$customer) {
            return response()->json(['message' => 'Customer not found'], 404);
        }

        return response()->json($customer);
    }

    /**
     * Update Customer
     *
     * @param  Request $request
     * @param  string $id
     * @return RedirectResponse
     */
    public function update(Request $request, $id): RedirectResponse
    {
        // Validate form
        $request->validate([
            
            'customer_name'           => 'required',
            'customer_description'    => 'required',
            'customer_address'        => 'required',
            'customer_phone'          => 'required',
            'customer_email'          => 'required|email',
            'customer_website'        => 'nullable|url|max:255', // Field ini opsional
        ]);

        $customer = Customer::where('customer_id', $id)->first();

        if (!$customer) {
            return response()->json(['message' => 'Customer not found'], 404);
        }

        // Update customer
        $customer->update([
            
            'customer_name'           => $request->customer_name,
            'customer_description'    => $request->customer_description,
            'customer_address'        => $request->customer_address,
            'customer_phone'          => $request->customer_phone,
            'customer_email'          => $request->customer_email,
            'customer_website'        => $request->customer_website,
        ]);

        // Redirect with flash message
        return redirect()->route('customers.index')->with('success', 'Customer updated successfully!');
    }

    /**
     * Delete Customer
     *
     * @param  string $id
     * @return RedirectResponse
     */
    public function destroy($id): RedirectResponse
    {
        $customer = Customer::where('customer_id', $id)->first();

        if (!$customer) {
            return response()->json(['message' => 'Customer not found'], 404);
        }

        // Delete customer
        $customer->delete();

        // Redirect with flash message
        return redirect()->route('customers.index')->with('success', 'Customer deleted successfully!');
    }
}