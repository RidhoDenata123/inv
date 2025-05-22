<?php

namespace App\Http\Controllers;

//import model supplier
use App\Models\Supplier; 

//import return type View
use Illuminate\View\View;

//import return type redirectResponse
use Illuminate\Http\RedirectResponse;

//import Http Request
use Illuminate\Http\Request;

//import Storage
use Illuminate\Support\Facades\Storage;

//YAJRA
use Yajra\DataTables\Facades\DataTables;

class SupplierController extends Controller
{

    //DATATABLE
    public function getDatatable(Request $request)
    {
        $suppliers = \App\Models\Supplier::query();

        return \DataTables::of($suppliers)
            ->addIndexColumn()
            ->addColumn('actions', function($row) {
                return view('suppliers.partials.actions', compact('row'))->render();
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

    //SUPPLIER PAGE
    public function index() : View
    {
        //get all suppliers
        $suppliers = Supplier::orderBy('created_at', 'desc')->paginate(10);

        //render view with suppliers
        return view('suppliers.index', compact('suppliers'));
    }

    //ADD SUPPLIER
    public function store(Request $request): RedirectResponse
    {
        //validate form
        $request->validate([
            'supplier_id'             => 'required',
            'supplier_name'           => 'required',
            'supplier_description'    => 'required',
            'supplier_address'        => 'required',
            'supplier_phone'          => 'required',
            'supplier_email'          => 'required|email',
            'supplier_website'        => 'nullable|url|max:255', // Field ini opsional
        ]);

        //create supplier
        Supplier::create([
            'supplier_id'          => $request->supplier_id,
            'supplier_name'        => $request->supplier_name,
            'supplier_description' => $request->supplier_description,
            'supplier_address'     => $request->supplier_address,
            'supplier_phone'       => $request->supplier_phone,
            'supplier_email'       => $request->supplier_email,
            'supplier_website'     => $request->supplier_website,
        ]);

        //redirect to index
        return redirect()->route('suppliers.index')->with('success', 'Supplier added successfully!');
    }

    //show supplier
    public function show($id)
    {
        \Log::info("Fetching supplier with ID: $id");
    
        $supplier = Supplier::where('supplier_id', $id)->first();
    
        if (!$supplier) {
            return response()->json(['message' => 'Supplier not found'], 404);
        }
    
        return response()->json($supplier);
    }
       
    //edit supplier
    public function update(Request $request, $id)
    {
        $request->validate([
            'supplier_name'           => 'required',
            'supplier_description'    => 'required',
            'supplier_address'        => 'required',
            'supplier_phone'          => 'required',
            'supplier_email'          => 'required|email',
            'supplier_website'        => 'nullable|url|max:255', // Field ini opsional
        ]);
    
        $supplier = Supplier::where('supplier_id', $id)->first();
    
        if (!$supplier) {
            return response()->json(['message' => 'Supplier not found'], 404);
        }
    
        $supplier->update([
            'supplier_name'        => $request->supplier_name,
            'supplier_description' => $request->supplier_description,
            'supplier_address'     => $request->supplier_address,
            'supplier_phone'       => $request->supplier_phone,
            'supplier_email'       => $request->supplier_email,
            'supplier_website'     => $request->supplier_website,
        ]);
        
        // Redirect dengan flash message
        return redirect()->route('suppliers.index')->with('success', 'Supplier updated successfully.');
        
    }

    //delete supplier
    public function destroy($id)
    {
        $supplier = Supplier::where('supplier_id', $id)->first();

        if (!$supplier) {
            return response()->json(['message' => 'Supplier not found'], 404);
        }

        $supplier->delete();

        // Redirect dengan flash message
        return redirect()->route('suppliers.index')->with('success', 'Supplier deleted successfully!');
    }


    
}