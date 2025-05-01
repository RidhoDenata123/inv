<?php

namespace App\Http\Controllers;

//import model Receiving Header
use App\Models\ReceivingHeader; 
use App\Models\ReceivingDetail; 
use App\Models\Product; 
use App\Models\Category;
use App\Models\Unit;
use App\Models\Supplier;

//import return type View
use Illuminate\View\View;

//import return type redirectResponse
use Illuminate\Http\RedirectResponse;

//import Http Request
use Illuminate\Http\Request;

//import Storage
use Illuminate\Support\Facades\Storage;

class ReceivingController extends Controller
{

    //show all receiving headers
    public function index() : View
    {
        //get all ReceivingHeaders
        $receiving_headers = ReceivingHeader::paginate(10); // Ambil data dengan pagination

        //render view with receiving headers
        return view('receiving.header', compact('receiving_headers'));
    }

    //create receiving header
    public function storeHeader(Request $request): RedirectResponse
    {
        //validate form
        $request->validate([
            'receiving_header_id'             => 'required',
            'receiving_header_name'           => 'required',
            'receiving_header_description'    => 'nullable',
            'created_by'                      => 'required',
            'receiving_header_status'         => 'required',
            'confirmed_at'                    => 'nullable|date',
        ]);

        //create receiving header
        ReceivingHeader::create([
            'receiving_header_id'             => $request->receiving_header_id,
            'receiving_header_name'           => $request->receiving_header_name,
            'receiving_header_description'    => $request->receiving_header_description,
            'created_by'                      => $request->created_by,
            'receiving_header_status'         => $request->receiving_header_status,
            'confirmed_at'                    => $request->confirmed_at,
        ]);

        //redirect to index
        return redirect()->route('receiving.header')->with('success', 'Receiving draft created successfully!');
    }

    //edit receiving header
    public function editHeader($id)
    {
        $receivingHeader = ReceivingHeader::find($id);

        if (!$receivingHeader) {
            return response()->json(['error' => 'Receiving Header not found'], 404);
        }

        return response()->json($receivingHeader);
    }

       
    //edit receiving header
    public function updateHeader(Request $request, $id)
    {
        $request->validate([
            'receiving_header_name'           => 'required',
            'receiving_header_description'    => 'nullable',
           
        ]);
    
        $receiving_headers = ReceivingHeader::where('receiving_header_id', $id)->first();
    
        if (!$receiving_headers) {
            return response()->json(['message' => 'Receiving draft not found'], 404);
        }
    
        $receiving_headers->update([
            'receiving_header_name'           => $request->receiving_header_name,
            'receiving_header_description'    => $request->receiving_header_description,
           
        ]);
        
        // Redirect dengan flash message
        return redirect()->route('receiving.header')->with('success', 'Receiving draft updated successfully.');
        
    }

    //delete receiving header
    public function destroyHeader($id)
    {
        // Cari Receiving Header berdasarkan ID
        $receivingHeader = ReceivingHeader::where('receiving_header_id', $id)->firstOrFail();
    
        // Hapus semua Receiving Details yang terkait
        $receivingHeader->details()->delete();
    
        // Hapus Receiving Header
        $receivingHeader->delete();
    
        // Redirect dengan pesan sukses
        return redirect()->route('receiving.header')->with('success', 'Receiving header and Details deleted successfully!');
    }

//DETAIL CONTROLLERS

    //show receiving headers by id
    public function ShowById($id)
    {
        // Ambil data Receiving Header berdasarkan ID
        $receivingHeader = ReceivingHeader::where('receiving_header_id', $id)->firstOrFail();

        // Ambil data Receiving Details yang terkait dengan Receiving Header
        $receivingDetails = ReceivingDetail::where('receiving_header_id', $id)->get();

        $products = Product::all();
        $categories = Category::all();
        $units = Unit::all();
        $suppliers = Supplier::all();

        // Tampilkan view detail dengan data Receiving Header, Receiving Details, dan Products
        return view('receiving.detail', compact('receivingHeader', 'receivingDetails', 'products', 'categories', 'units', 'suppliers'));
    }

    //create receiving detail
    public function addDetail(Request $request): RedirectResponse
    {
        //validate form
        $request->validate([
            'receiving_detail_id'             => 'required',
            'receiving_header_id'             => 'required',
            'product_id'                      => 'required',
            'receiving_qty'                   => 'required',
            
            'receiving_detail_status'         => 'nullable',
            'confirmed_at'                    => 'nullable|date',
        ]);

        //create receiving detail
        ReceivingDetail::create([
            'receiving_detail_id'             => $request->receiving_detail_id,
            'receiving_header_id'             => $request->receiving_header_id,
            'product_id'                      => $request->product_id,
            'receiving_qty'                   => $request->receiving_qty,
           
            'receiving_detail_status'         => $request->receiving_detail_status,
            'confirmed_at'                    => $request->confirmed_at,
        ]);

       // Redirect back to the detail page with the same receiving_header_id
       return redirect()->back()->with('success', 'Receiving detail added successfully!');
    }

    //delete receiving detail
    public function destroyDetail($id)
    {
        $receivingDetail = ReceivingDetail::findOrFail($id);
        $receivingDetail->delete();
    
        return redirect()->back()->with('success', 'Receiving detail deleted successfully!');
    }
    
    //edit receiving detail
    public function showDetail($id)
    {
        $receivingDetail = ReceivingDetail::findOrFail($id);
        return response()->json($receivingDetail);
    }

    //update receiving detail
    public function updateDetail(Request $request, $id)
    {
        $receivingDetail = ReceivingDetail::findOrFail($id);

        $request->validate([
            'product_id' => 'required|string|exists:products,product_id',
            'receiving_qty' => 'required|integer|min:1',
            'receiving_detail_status' => 'required|string|in:Pending,Confirmed',
        ]);

        $receivingDetail->update($request->all());

        return redirect()->back()->with('success', 'Receiving detail updated successfully!');
    }

    public function confirm($id)
    {
        // Ambil Receiving Header berdasarkan ID
        $receivingHeader = ReceivingHeader::where('receiving_header_id', $id)->firstOrFail();
    
        // Update status Receiving Header menjadi Confirmed dan isi confirmed_at
        $receivingHeader->update([
            'receiving_header_status' => 'Confirmed',
            'confirmed_at' => now(), // Isi tanggal dan waktu konfirmasi
        ]);
    
        // Ambil semua Receiving Details terkait
        $receivingDetails = ReceivingDetail::where('receiving_header_id', $id)->get();
    
        foreach ($receivingDetails as $detail) {
            // Update status Receiving Detail menjadi Confirmed dan isi confirmed_at
            $detail->update([
                'receiving_detail_status' => 'Confirmed',
                'confirmed_at' => now(), // Isi tanggal dan waktu konfirmasi
            ]);
    
            // Update product_qty pada tabel products
            $product = Product::where('product_id', $detail->product_id)->first();
            if ($product) {
                $product->update([
                    'product_qty' => $product->product_qty + $detail->receiving_qty,
                ]);
            }
        }
    
        // Redirect dengan pesan sukses
        return redirect()->route('receiving.header')->with('success', 'Receiving confirmed successfully!');
    }



}