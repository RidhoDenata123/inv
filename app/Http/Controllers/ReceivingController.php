<?php
namespace App\Http\Controllers;

//import model Receiving Header
use App\Models\ReceivingHeader; 
use App\Models\ReceivingDetail; 
use App\Models\Product; 
use App\Models\Category;
use App\Models\Unit;
use App\Models\Supplier;
use App\Models\StockChangeLog;

//import return type View
use Illuminate\View\View;

//import return type RedirectResponse
use Illuminate\Http\RedirectResponse;

//import Http Request
use Illuminate\Http\Request;

//import Storage
use Illuminate\Support\Facades\Storage;

//import Auth
use Illuminate\Support\Facades\Auth;

//carbon
use Carbon\Carbon;

// Mendapatkan waktu saat ini dengan zona waktu Jakarta
$timeInJakarta = Carbon::now('Asia/Jakarta');

//YAJRA
use Yajra\DataTables\Facades\DataTables;

class ReceivingController extends Controller
{
    //DATATABLE
    public function GetDatatableHeader(Request $request)
    {
        $headers = ReceivingHeader::with(['createdByUser', 'confirmedByUser']);

        return DataTables::of($headers)
            ->addIndexColumn()
            ->addColumn('created_at', function($row) {
                return $row->created_at ? \Carbon\Carbon::parse($row->created_at)->timezone('Asia/Jakarta')->format('l, d F Y H:i') : 'N/A';
            })
            ->addColumn('created_by', function($row) {
                return $row->created_by ? optional($row->createdByUser)->name : 'N/A';
            })
            ->addColumn('confirmed_at', function($row) {
                return $row->confirmed_at ? \Carbon\Carbon::parse($row->confirmed_at)->timezone('Asia/Jakarta')->format('l, d F Y H:i') : 'N/A';
            })
            ->addColumn('confirmed_by', function($row) {
                return $row->confirmed_by ? optional($row->confirmedByUser)->name : 'N/A';
            })
            ->addColumn('receiving_header_status', function($row) {
                $class = $row->receiving_header_status === 'Confirmed' ? 'badge-success' : 'badge-warning';
                return '<span class="badge '.$class.'">'.ucfirst($row->receiving_header_status).'</span>';
            })
            ->addColumn('actions', function($row) {
                return view('receiving.partials.actionsHeader', compact('row'))->render();
            })
            // Tambahkan orderColumn berikut:
            ->orderColumn('created_at', function ($query, $order) {
                $query->orderBy('receiving_headers.created_at', $order);
            })
            ->orderColumn('created_by', function ($query, $order) {
                $query->leftJoin('users as u', 'receiving_headers.created_by', '=', 'u.id')
                    ->orderBy('u.name', $order);
            })
            ->orderColumn('confirmed_at', function ($query, $order) {
                $query->orderBy('receiving_headers.confirmed_at', $order);
            })
            ->orderColumn('confirmed_by', function ($query, $order) {
                $query->leftJoin('users as u2', 'receiving_headers.confirmed_by', '=', 'u2.id')
                    ->orderBy('u2.name', $order);
            })
            ->rawColumns(['receiving_header_status', 'actions'])
            ->make(true);
    }

    
    //show all receiving headers
    public function index() : View
    {
        //get all ReceivingHeaders
        $receiving_headers = ReceivingHeader::orderBy('created_at', 'desc')->paginate(10);

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
            'confirmed_by'                    => 'nullable',
            'confirmed_at'                    => 'nullable|date',
            

            
        ]);

        //create receiving header
        ReceivingHeader::create([
            'receiving_header_id'             => $request->receiving_header_id,
            'receiving_header_name'           => $request->receiving_header_name,
            'receiving_header_description'    => $request->receiving_header_description,
            'created_by'                      => $request->created_by,
            'receiving_header_status'         => $request->receiving_header_status,
            'confirmed_by'                    => $request->confirmed_by,
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

    //DATATABLE
    public function getDatatableDetail($receiving_header_id)
    {
        $details = ReceivingDetail::with(['product.unit'])
            ->where('receiving_header_id', $receiving_header_id);

        return DataTables::of($details)
            ->addIndexColumn()
            ->addColumn('product_name', function($row) {
                return $row->product ? $row->product->product_name : 'No product name';
            })
            ->addColumn('unit_name', function($row) {
                return $row->product && $row->product->unit ? $row->product->unit->unit_name : 'No unit';
            })
            ->addColumn('created_by', function($row) {
                return $row->created_by ? optional(\App\Models\User::find($row->created_by))->name : 'N/A';
            })
            ->addColumn('confirmed_by', function($row) {
                return $row->confirmed_by ? optional(\App\Models\User::find($row->confirmed_by))->name : 'N/A';
            })
            ->addColumn('created_at', function($row) {
                return $row->created_at ? \Carbon\Carbon::parse($row->created_at)->timezone('Asia/Jakarta')->format('l, d F Y H:i') : 'N/A';
            })
            ->addColumn('confirmed_at', function($row) {
                return $row->confirmed_at ? \Carbon\Carbon::parse($row->confirmed_at)->timezone('Asia/Jakarta')->format('l, d F Y H:i') : 'N/A';
            })
            ->addColumn('receiving_detail_status', function($row) {
                $class = $row->receiving_detail_status === 'Confirmed' ? 'badge-success' : 'badge-warning';
                return '<span class="badge '.$class.'">'.ucfirst($row->receiving_detail_status).'</span>';
            })
            ->addColumn('actions', function($row) {
                return view('receiving.partials.actionsDetail', compact('row'))->render();
            })
            // Tambahkan orderColumn berikut:
            ->orderColumn('product_name', function ($query, $order) {
                $query->leftJoin('products as p', 'receiving_details.product_id', '=', 'p.product_id')
                    ->orderBy('p.product_name', $order);
            })
            ->orderColumn('unit_name', function ($query, $order) {
                $query->leftJoin('products as p2', 'receiving_details.product_id', '=', 'p2.product_id')
                    ->leftJoin('units as u', 'p2.unit_id', '=', 'u.unit_id')
                    ->orderBy('u.unit_name', $order);
            })
            ->orderColumn('created_by', function ($query, $order) {
                $query->leftJoin('users as u2', 'receiving_details.created_by', '=', 'u2.id')
                    ->orderBy('u2.name', $order);
            })
            ->orderColumn('confirmed_by', function ($query, $order) {
                $query->leftJoin('users as u3', 'receiving_details.confirmed_by', '=', 'u3.id')
                    ->orderBy('u3.name', $order);
            })
            ->orderColumn('created_at', function ($query, $order) {
                $query->orderBy('receiving_details.created_at', $order);
            })
            ->orderColumn('confirmed_at', function ($query, $order) {
                $query->orderBy('receiving_details.confirmed_at', $order);
            })
            ->rawColumns(['receiving_detail_status', 'actions'])
            ->make(true);
    }

    //show receiving headers by id
    public function ShowById($id)
    {
        // Ambil data Receiving Header berdasarkan ID
        $receivingHeader = ReceivingHeader::where('receiving_header_id', $id)->firstOrFail();
    
        // Ambil data Receiving Details dengan pagination
        $receivingDetails = ReceivingDetail::where('receiving_header_id', $id)
        ->orderBy('created_at', 'desc') // Urutkan berdasarkan created_at secara descending
        ->paginate(10);
    
        $products = Product::all();
        $categories = Category::all();
        $units = Unit::all();
        $suppliers = Supplier::all();
    
        // Tampilkan view detail dengan data Receiving Header, Receiving Details, dan Products
        return view('receiving.detail', compact('receivingHeader', 'receivingDetails', 'products', 'categories', 'units', 'suppliers'));
    }

    //get product unit
        public function getUnit($id)
    {
        $product = Product::with('unit')->where('product_id', $id)->first();

        if ($product && $product->unit) {
            return response()->json(['unit_name' => $product->unit->unit_name]);
        }

        return response()->json(['unit_name' => 'No unit found'], 404);
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
            'created_by'                      => 'nullable',
            'receiving_detail_status'         => 'nullable',
            'confirmed_by'                    => 'nullable',
            'confirmed_at'                    => 'nullable|date',
        ]);

        //create receiving detail
        ReceivingDetail::create([
            'receiving_detail_id'             => $request->receiving_detail_id,
            'receiving_header_id'             => $request->receiving_header_id,
            'product_id'                      => $request->product_id,
            'receiving_qty'                   => $request->receiving_qty,
            'created_by'                      => $request->created_by,
            'receiving_detail_status'         => $request->receiving_detail_status,
            'confirmed_by'                    => $request->confirmed_by,
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

    //confirm receiving all
    public function confirmAll(Request $request, $id)
    {
        $request->validate([
            'receiving_document' => 'required|file|mimes:pdf,jpg,jpeg,png|max:2048', // Validasi file
        ]);
    
        $receivingHeader = ReceivingHeader::findOrFail($id);
    
        // Upload file ke storage
        if ($request->hasFile('receiving_document')) {
            $file = $request->file('receiving_document');
            $filePath = $file->store('receiving_documents', 'public'); // Simpan di folder 'receiving_documents' di storage/public
    
            // Simpan path file di database
            $receivingHeader->receiving_document = $filePath;
        }
    
        // Update status header
        $receivingHeader->update([
            'receiving_header_status' => 'Confirmed',
            'confirmed_at' => now(),
            'confirmed_by' => Auth::user()->id,
        ]);
    
        // Ambil semua Receiving Details dengan status 'Pending'
        $pendingDetails = ReceivingDetail::where('receiving_header_id', $id)
            ->where('receiving_detail_status', 'Pending')
            ->get();
    
        foreach ($pendingDetails as $detail) {
            // Ambil produk terkait
            $product = Product::findOrFail($detail->product_id);
    
            // Hitung nilai untuk stock_change_logs
            $qtyBefore = $product->product_qty;
            $qtyChanged = $detail->receiving_qty;
            $qtyAfter = $qtyBefore + $qtyChanged;
    
            // Perbarui product_qty di tabel products
            $product->update([
                'product_qty' => $qtyAfter,
            ]);
    
            // Perbarui receiving_detail_status di tabel receiving_details
            $detail->update([
                'receiving_detail_status' => 'Confirmed',
                'confirmed_at' => now(),
                'confirmed_by' => Auth::user()->id,
            ]);
    
            // Tambahkan data ke tabel stock_change_logs
            StockChangeLog::create([
                'stock_change_log_id' => uniqid('SC'),
                'stock_change_type' => $receivingHeader->receiving_header_name, 
                'product_id' => $product->product_id,
                'reference_id' => $detail->receiving_detail_id,
                'qty_before' => $qtyBefore,
                'qty_changed' => $qtyChanged,
                'qty_after' => $qtyAfter,
                'changed_at' => now(),
                'changed_by' => Auth::user()->id,
                'change_note' => $receivingHeader->receiving_header_description, 
            ]);
        }
    
        return redirect()->back()->with('success', 'All pending receiving details confirmed successfully!');
    }


    //confirm receiving detail per id
    public function confirmDetail($id)
    {
        // Ambil Receiving Detail berdasarkan ID
        $receivingDetail = ReceivingDetail::findOrFail($id);

        // Ambil Receiving Header terkait
        $receivingHeader = ReceivingHeader::findOrFail($receivingDetail->receiving_header_id);

        // Ambil produk terkait
        $product = Product::findOrFail($receivingDetail->product_id);

        // Hitung nilai untuk stock_change_logs
        $qtyBefore = $product->product_qty;
        $qtyChanged = $receivingDetail->receiving_qty;
        $qtyAfter = $qtyBefore + $qtyChanged;

        // Perbarui product_qty di tabel products
        $product->update([
            'product_qty' => $qtyAfter,
        ]);

        // Perbarui receiving_detail_status di tabel receiving_details
        $receivingDetail->update([
            'receiving_detail_status' => 'Confirmed',
            'confirmed_at' => now(),
            'confirmed_by' => auth()->user()->id,
        ]);

        // Tambahkan data ke tabel stock_change_logs
        StockChangeLog::create([
            'stock_change_log_id' => uniqid('SC'),
            'stock_change_type' => $receivingHeader->receiving_header_name, // Ambil dari receiving_header_name
            'product_id' => $product->product_id,
            'reference_id' => $receivingDetail->receiving_detail_id,
            'qty_before' => $qtyBefore,
            'qty_changed' => $qtyChanged,
            'qty_after' => $qtyAfter,
            'changed_at' => now(),
            'changed_by' => auth()->user()->id,
            'change_note' => $receivingHeader->receiving_header_description, // Ambil dari receiving_header_description
        ]);

        // Redirect dengan pesan sukses
        return redirect()->back()->with('success', 'Receiving detail confirmed successfully!');
    }

}