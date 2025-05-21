<?php
namespace App\Http\Controllers;

use App\Models\DispatchingHeader;
use App\Models\DispatchingDetail;
use App\Models\Product;
use App\Models\Category;
use App\Models\Unit;
use App\Models\Supplier;
use App\Models\Customer;
use App\Models\UserCompany;
use App\Models\BankAccount;
use App\Models\StockChangeLog;

use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Yajra\DataTables\Facades\DataTables;

class DispatchingController extends Controller
{
    //HEADER DATATABLE
    public function GetDatatableHeader(Request $request)
{
    $headers = DispatchingHeader::with(['customer', 'createdByUser', 'confirmedByUser']);
    // Hapus ->orderBy('created_at', 'desc'); di sini, biarkan DataTables yang handle order

    return DataTables::of($headers)
        ->addIndexColumn()
        ->addColumn('designation', function($row) {
            return $row->dispatching_header_name;
        })
        ->addColumn('customer', function($row) {
            return $row->customer ? $row->customer->customer_name : 'N/A';
        })
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
        ->addColumn('dispatching_header_status', function($row) {
            $class = $row->dispatching_header_status === 'Confirmed' ? 'badge-success' : 'badge-warning';
            return '<span class="badge '.$class.'">'.ucfirst($row->dispatching_header_status).'</span>';
        })
        ->addColumn('actions', function($row) {
            return view('dispatching.partials.actionsHeader', compact('row'))->render();
        })
        // Tambahkan orderColumn berikut:
        ->orderColumn('designation', function ($query, $order) {
            $query->orderBy('dispatching_headers.dispatching_header_name', $order);
        })
        ->orderColumn('customer', function ($query, $order) {
            $query->leftJoin('customers as c', 'dispatching_headers.customer_id', '=', 'c.customer_id')
                  ->orderBy('c.customer_name', $order);
        })
        ->orderColumn('created_at', function ($query, $order) {
            $query->orderBy('dispatching_headers.created_at', $order);
        })
        ->orderColumn('created_by', function ($query, $order) {
            $query->leftJoin('users as u', 'dispatching_headers.created_by', '=', 'u.id')
                  ->orderBy('u.name', $order);
        })
        ->orderColumn('confirmed_at', function ($query, $order) {
            $query->orderBy('dispatching_headers.confirmed_at', $order);
        })
        ->orderColumn('confirmed_by', function ($query, $order) {
            $query->leftJoin('users as u2', 'dispatching_headers.confirmed_by', '=', 'u2.id')
                  ->orderBy('u2.name', $order);
        })
        ->rawColumns(['dispatching_header_status', 'actions'])
        ->make(true);
}

    // Show all dispatching headers
    public function index(): View
    {
        $dispatching_headers = DispatchingHeader::orderBy('created_at', 'desc')->paginate(10);
        $customers = Customer::all(); // Ambil semua data customer
        return view('dispatching.header', compact('dispatching_headers', 'customers'));
    }

    // Create dispatching header
    public function storeHeader(Request $request): RedirectResponse
    {
        $request->validate([
            'dispatching_header_id'             => 'required',
            'dispatching_header_name'           => 'required',
            'customer_id'                       => 'required',
            'dispatching_header_description'    => 'nullable',
            'created_by'                        => 'required',
            'dispatching_header_status'         => 'required',
            'confirmed_by'                      => 'nullable',
            'confirmed_at'                      => 'nullable|date',
        ]);

        DispatchingHeader::create([
            'dispatching_header_id'             => $request->dispatching_header_id,
            'dispatching_header_name'           => $request->dispatching_header_name,
            'customer_id'                       => $request->customer_id,
            'dispatching_header_description'    => $request->dispatching_header_description,
            'created_by'                        => $request->created_by,
            'dispatching_header_status'         => $request->dispatching_header_status,
            'confirmed_by'                      => $request->confirmed_by,
            'confirmed_at'                      => $request->confirmed_at,
        ]);

        return redirect()->route('dispatching.header')->with('success', 'Dispatching draft created successfully!');
    }

    // Edit dispatching header
    public function editHeader($id)
    {
        $dispatchingHeader = DispatchingHeader::find($id);

        if (!$dispatchingHeader) {
            return response()->json(['error' => 'Dispatching Header not found'], 404);
        }

        return response()->json($dispatchingHeader);
    }

    // Update dispatching header
    public function updateHeader(Request $request, $id)
    {
        $request->validate([
            'dispatching_header_name'           => 'required',
            'customer_id'                       => 'required',
            'dispatching_header_description'    => 'nullable',
            
        ]);

        $dispatching_header = DispatchingHeader::where('dispatching_header_id', $id)->first();

        if (!$dispatching_header) {
            return response()->json(['message' => 'Dispatching draft not found'], 404);
        }

        $dispatching_header->update([
            'dispatching_header_name'           => $request->dispatching_header_name,
            'customer_id'                       => $request->customer_id,
            'dispatching_header_description'    => $request->dispatching_header_description,
            
        ]);

        return redirect()->route('dispatching.header')->with('success', 'Dispatching draft updated successfully.');
    }

    // Delete dispatching header
    public function destroyHeader($id)
    {
        $dispatchingHeader = DispatchingHeader::where('dispatching_header_id', $id)->firstOrFail();
        $dispatchingHeader->details()->delete(); // Hapus semua Dispatching Details terkait
        $dispatchingHeader->delete(); // Hapus Dispatching Header

        return redirect()->route('dispatching.header')->with('success', 'Dispatching header and details deleted successfully!');
    }


    //DETAIL DATATABLE
    public function GetDatatableDetail($dispatching_header_id)
    {
        $details = DispatchingDetail::with(['product.unit'])
            ->where('dispatching_header_id', $dispatching_header_id);
            // Hapus ->orderBy('created_at', 'desc'); biarkan DataTables yang handle order

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
            ->addColumn('dispatching_detail_status', function($row) {
                $class = $row->dispatching_detail_status === 'Confirmed' ? 'badge-success' : 'badge-warning';
                return '<span class="badge '.$class.'">'.ucfirst($row->dispatching_detail_status).'</span>';
            })
            ->addColumn('actions', function($row) {
                return view('dispatching.partials.actionsDetail', compact('row'))->render();
            })
            // Tambahkan orderColumn berikut:
            ->orderColumn('product_name', function ($query, $order) {
                $query->leftJoin('products as p', 'dispatching_details.product_id', '=', 'p.product_id')
                    ->orderBy('p.product_name', $order);
            })
            ->orderColumn('unit_name', function ($query, $order) {
                $query->leftJoin('products as p2', 'dispatching_details.product_id', '=', 'p2.product_id')
                    ->leftJoin('units as u', 'p2.unit_id', '=', 'u.unit_id')
                    ->orderBy('u.unit_name', $order);
            })
            ->orderColumn('created_by', function ($query, $order) {
                $query->leftJoin('users as u2', 'dispatching_details.created_by', '=', 'u2.id')
                    ->orderBy('u2.name', $order);
            })
            ->orderColumn('confirmed_by', function ($query, $order) {
                $query->leftJoin('users as u3', 'dispatching_details.confirmed_by', '=', 'u3.id')
                    ->orderBy('u3.name', $order);
            })
            ->orderColumn('created_at', function ($query, $order) {
                $query->orderBy('dispatching_details.created_at', $order);
            })
            ->orderColumn('confirmed_at', function ($query, $order) {
                $query->orderBy('dispatching_details.confirmed_at', $order);
            })
            ->rawColumns(['dispatching_detail_status', 'actions'])
            ->make(true);
    }

    // Show dispatching header by ID
    public function showById($id)
    {
        $dispatchingHeader = DispatchingHeader::where('dispatching_header_id', $id)->firstOrFail();

        $dispatchingDetails = DispatchingDetail::where('dispatching_header_id', $id)
        ->orderBy('created_at', 'desc') // Urutkan berdasarkan created_at secara descending
        ->paginate(10);

        // Filter produk dengan status Active dan quantity > 0
        $products = Product::where('product_status', 'Active')
        ->where('product_qty', '>', 0)
        ->get();
        
        $categories = Category::all();
        $units = Unit::all();
        $suppliers = Supplier::all();

        return view('dispatching.detail', compact('dispatchingHeader', 'dispatchingDetails', 'products', 'categories', 'units', 'suppliers'));
    }

    // Create dispatching detail
    public function addDetail(Request $request): RedirectResponse
    {
        $request->validate([
            'dispatching_detail_id'             => 'required',
            'dispatching_header_id'             => 'required',
            'product_id'                        => 'required',
            'dispatching_qty'                   => 'required',
            'created_by'                        => 'nullable',
            'dispatching_detail_status'         => 'nullable',
            'confirmed_by'                      => 'nullable',
            'confirmed_at'                      => 'nullable|date',
        ]);

        DispatchingDetail::create([
            'dispatching_detail_id'             => $request->dispatching_detail_id,
            'dispatching_header_id'             => $request->dispatching_header_id,
            'product_id'                        => $request->product_id,
            'dispatching_qty'                   => $request->dispatching_qty,
            'created_by'                        => $request->created_by,
            'dispatching_detail_status'         => $request->dispatching_detail_status,
            'confirmed_by'                      => $request->confirmed_by,
            'confirmed_at'                      => $request->confirmed_at,
        ]);

        return redirect()->back()->with('success', 'Dispatching detail added successfully!');
    }

    // Delete dispatching detail
    public function destroyDetail($id)
    {
        $dispatchingDetail = DispatchingDetail::findOrFail($id);
        $dispatchingDetail->delete();

        return redirect()->back()->with('success', 'Dispatching detail deleted successfully!');
    }

    // Edit dispatching detail
    public function showDetail($id)
    {
        $dispatchingDetail = DispatchingDetail::where('dispatching_detail_id', $id)->first();
    
        if (!$dispatchingDetail) {
            return response()->json(['error' => 'Dispatching detail not found'], 404);
        }
    
        return response()->json($dispatchingDetail);
    }

    // Update dispatching detail
    public function updateDetail(Request $request, $id)
    {
        $dispatchingDetail = DispatchingDetail::findOrFail($id);

        $request->validate([
            'product_id' => 'required|string|exists:products,product_id',
            'dispatching_qty' => 'required|integer|min:1',
            'dispatching_detail_status' => 'required|string|in:Pending,Confirmed',
        ]);

        $dispatchingDetail->update($request->all());

        return redirect()->back()->with('success', 'Dispatching detail updated successfully!');
    }

    // Confirm all pending dispatching details
    public function confirmAll($id)
    {
        // Ambil Dispatching Header berdasarkan ID
        $dispatchingHeader = DispatchingHeader::where('dispatching_header_id', $id)->firstOrFail();
    
        // Perbarui status Dispatching Header
        $dispatchingHeader->update([
            'dispatching_header_status' => 'Confirmed',
            'confirmed_at' => now(),
            'confirmed_by' => Auth::user()->id,
        ]);
    
        // Ambil semua Dispatching Details dengan status 'Pending'
        $pendingDetails = DispatchingDetail::where('dispatching_header_id', $id)
            ->where('dispatching_detail_status', 'Pending')
            ->get();
    
        foreach ($pendingDetails as $detail) {
            // Ambil produk terkait
            $product = Product::where('product_id', $detail->product_id)->firstOrFail();
    
            // Hitung nilai untuk stock_change_logs
            $qtyBefore = $product->product_qty;
            $qtyChanged = $detail->dispatching_qty;
            $qtyAfter = $qtyBefore - $qtyChanged;
    
            // Perbarui product_qty di tabel products
            $product->update([
                'product_qty' => $qtyAfter,
            ]);
    
            // Perbarui dispatching_detail_status di tabel dispatching_details
            $detail->update([
                'dispatching_detail_status' => 'Confirmed',
                'confirmed_at' => now(),
                'confirmed_by' => Auth::user()->id,
            ]);
    
            // Tambahkan data ke tabel stock_change_logs
            StockChangeLog::create([
                'stock_change_log_id' => uniqid('SC'),
                'stock_change_type' => $dispatchingHeader->dispatching_header_name,
                'product_id' => $product->product_id,
                'reference_id' => $detail->dispatching_detail_id,
                'qty_before' => $qtyBefore,
                'qty_changed' => -$qtyChanged, // Negatif karena stok berkurang
                'qty_after' => $qtyAfter,
                'changed_at' => now(),
                'changed_by' => Auth::user()->id,
                'change_note' => $dispatchingHeader->dispatching_header_description,
            ]);
        }
    
        // Redirect kembali ke halaman sebelumnya dengan pesan sukses
        return redirect()->back()->with('success', 'All pending dispatching details confirmed successfully!');
    }


    // Confirm dispatching detail by ID
    public function confirmDetail($id)
    {
        // Ambil Dispatching Detail berdasarkan ID
        $dispatchingDetail = DispatchingDetail::where('dispatching_detail_id', $id)->firstOrFail();

        // Ambil Dispatching Header terkait
        $dispatchingHeader = DispatchingHeader::where('dispatching_header_id', $dispatchingDetail->dispatching_header_id)->firstOrFail();

        // Ambil produk terkait
        $product = Product::where('product_id', $dispatchingDetail->product_id)->firstOrFail();

        // Hitung nilai untuk stock_change_logs
        $qtyBefore = $product->product_qty;
        $qtyChanged = $dispatchingDetail->dispatching_qty;
        $qtyAfter = $qtyBefore - $qtyChanged;

        // Perbarui product_qty di tabel products
        $product->update([
            'product_qty' => $qtyAfter,
        ]);

        // Perbarui dispatching_detail_status di tabel dispatching_details
        $dispatchingDetail->update([
            'dispatching_detail_status' => 'Confirmed',
            'confirmed_at' => now(),
            'confirmed_by' => Auth::user()->id,
        ]);

        // Tambahkan data ke tabel stock_change_logs
        StockChangeLog::create([
            'stock_change_log_id' => uniqid('SC'),
            'stock_change_type' => $dispatchingHeader->dispatching_header_name, // Ambil dari dispatching_header_name
            'product_id' => $product->product_id,
            'reference_id' => $dispatchingDetail->dispatching_detail_id,
            'qty_before' => $qtyBefore,
            'qty_changed' => -$qtyChanged, // Negatif karena stok berkurang
            'qty_after' => $qtyAfter,
            'changed_at' => now(),
            'changed_by' => Auth::user()->id,
            'change_note' => $dispatchingHeader->dispatching_header_description, // Ambil dari dispatching_header_description
        ]);

        // Redirect kembali ke halaman detail dengan pesan sukses
        return redirect()->back()->with('success', 'Dispatching detail confirmed successfully!');
    }

    // Get product unit by product ID
    public function getUnit($id)
    {
        // Cari produk berdasarkan product_id
        $product = Product::with('unit')->where('product_id', $id)->first();

        if ($product && $product->unit) {
            return response()->json(['unit_name' => $product->unit->unit_name]);
        }

        return response()->json(['unit_name' => 'No unit found'], 404);
    }
    //GET PRODUCT QTY
    public function getProductQty($productId)
    {
        $product = Product::findOrFail($productId);
        return response()->json(['product_qty' => $product->product_qty]);
    }

    // Print invoice
    public function printInvoice($id)
    {
        $dispatchingHeader = DispatchingHeader::findOrFail($id);
        $dispatchingDetails = DispatchingDetail::where('dispatching_header_id', $id)->get();
        
        // Ambil data perusahaan berdasarkan company_id pengguna yang sedang login
        $userCompany = UserCompany::where('company_id', auth()->user()->company_id)->first();
        $bankAccount = BankAccount::where('account_id', $userCompany->company_bank_account)->first();
    
        return view('dispatching.invoice', compact('dispatchingHeader', 'dispatchingDetails', 'userCompany', 'bankAccount'));
    }
    
    // Print delivery note
    public function printDeliveryNote($id)
    {
        $dispatchingHeader = DispatchingHeader::findOrFail($id);
        $dispatchingDetails = DispatchingDetail::where('dispatching_header_id', $id)->get();
        
        // Ambil data perusahaan berdasarkan company_id pengguna yang sedang login
        $userCompany = UserCompany::where('company_id', auth()->user()->company_id)->first();
        $bankAccount = BankAccount::where('account_id', $userCompany->company_bank_account)->first();
    
        
        return view('dispatching.delivery-note', compact('dispatchingHeader', 'dispatchingDetails', 'userCompany', 'bankAccount'));
    }











    //USER
    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////


    //USER HEADER DATATABLE
    public function getUserDispatchingHeaderDatatable(Request $request)
    {
        $headers = \App\Models\DispatchingHeader::with(['customer', 'createdByUser', 'confirmedByUser']);

        return \DataTables::of($headers)
            ->addIndexColumn()
            ->addColumn('dispatching_header_id', function($row) {
                return $row->dispatching_header_id;
            })
            ->addColumn('designation', function($row) {
                return $row->dispatching_header_name;
            })
            ->addColumn('customer', function($row) {
                return $row->customer ? $row->customer->customer_name : 'N/A';
            })
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
            ->addColumn('dispatching_header_status', function($row) {
                $class = $row->dispatching_header_status === 'Confirmed' ? 'badge-success' : 'badge-warning';
                return '<span class="badge '.$class.'">'.ucfirst($row->dispatching_header_status).'</span>';
            })
            ->addColumn('actions', function($row) {
                return view('dispatching.partials.actionsUserHeader', compact('row'))->render();
            })
            // Tambahkan orderColumn jika ingin sorting kolom relasi
            ->orderColumn('designation', function ($query, $order) {
                $query->orderBy('dispatching_headers.dispatching_header_name', $order);
            })
            ->orderColumn('customer', function ($query, $order) {
                $query->leftJoin('customers as c', 'dispatching_headers.customer_id', '=', 'c.customer_id')
                    ->orderBy('c.customer_name', $order);
            })
            ->orderColumn('created_at', function ($query, $order) {
                $query->orderBy('dispatching_headers.created_at', $order);
            })
            ->orderColumn('created_by', function ($query, $order) {
                $query->leftJoin('users as u', 'dispatching_headers.created_by', '=', 'u.id')
                    ->orderBy('u.name', $order);
            })
            ->orderColumn('confirmed_at', function ($query, $order) {
                $query->orderBy('dispatching_headers.confirmed_at', $order);
            })
            ->orderColumn('confirmed_by', function ($query, $order) {
                $query->leftJoin('users as u2', 'dispatching_headers.confirmed_by', '=', 'u2.id')
                    ->orderBy('u2.name', $order);
            })
            ->rawColumns(['dispatching_header_status', 'actions'])
            ->make(true);
    }

     // Show all dispatching headers
    public function UserDispatching(): View
    {
        $dispatching_headers = DispatchingHeader::orderBy('created_at', 'desc')->paginate(10);
        $customers = Customer::all(); // Ambil semua data customer
        return view('dispatching.user_header', compact('dispatching_headers', 'customers'));
    }

    // Create dispatching header
    public function UserStoreHeader(Request $request): RedirectResponse
    {
        $request->validate([
            'dispatching_header_id'             => 'required',
            'dispatching_header_name'           => 'required',
            'customer_id'                       => 'required',
            'dispatching_header_description'    => 'nullable',
            'created_by'                        => 'required',
            'dispatching_header_status'         => 'required',
            'confirmed_by'                      => 'nullable',
            'confirmed_at'                      => 'nullable|date',
        ]);

        DispatchingHeader::create([
            'dispatching_header_id'             => $request->dispatching_header_id,
            'dispatching_header_name'           => $request->dispatching_header_name,
            'customer_id'                       => $request->customer_id,
            'dispatching_header_description'    => $request->dispatching_header_description,
            'created_by'                        => $request->created_by,
            'dispatching_header_status'         => $request->dispatching_header_status,
            'confirmed_by'                      => $request->confirmed_by,
            'confirmed_at'                      => $request->confirmed_at,
        ]);

        return redirect()->route('dispatching.user_header')->with('success', 'Dispatching draft created successfully!');
    }

    // Edit dispatching header
    public function UserEditHeader($id)
    {
        $dispatchingHeader = DispatchingHeader::find($id);

        if (!$dispatchingHeader) {
            return response()->json(['error' => 'Dispatching Header not found'], 404);
        }

        return response()->json($dispatchingHeader);
    }

    // Update dispatching header
    public function UserUpdateHeader(Request $request, $id)
    {
        $request->validate([
            'dispatching_header_name'           => 'required',
            'customer_id'                       => 'required',
            'dispatching_header_description'    => 'nullable',
            
        ]);

        $dispatching_header = DispatchingHeader::where('dispatching_header_id', $id)->first();

        if (!$dispatching_header) {
            return response()->json(['message' => 'Dispatching draft not found'], 404);
        }

        $dispatching_header->update([
            'dispatching_header_name'           => $request->dispatching_header_name,
            'customer_id'                       => $request->customer_id,
            'dispatching_header_description'    => $request->dispatching_header_description,
            
        ]);

        return redirect()->route('dispatching.user_header')->with('success', 'Dispatching draft updated successfully.');
    }

    // Delete dispatching header
    public function UserDestroyHeader($id)
    {
        $dispatchingHeader = DispatchingHeader::where('dispatching_header_id', $id)->firstOrFail();
        $dispatchingHeader->details()->delete(); // Hapus semua Dispatching Details terkait
        $dispatchingHeader->delete(); // Hapus Dispatching Header

        return redirect()->route('dispatching.user_header')->with('success', 'Dispatching header and details deleted successfully!');
    }




    // USER DETAIL DATATABLE
    public function getUserDispatchingDetailDatatable($header_id)
    {
        $details = \App\Models\DispatchingDetail::with(['product.unit'])
            ->where('dispatching_header_id', $header_id);

        return \DataTables::of($details)
            ->addIndexColumn()
            ->addColumn('dispatching_detail_id', function($row) {
                return $row->dispatching_detail_id;
            })
            ->addColumn('product_id', function($row) {
                return $row->product_id;
            })
            ->addColumn('product_name', function($row) {
                return $row->product ? $row->product->product_name : 'No product name';
            })
            ->addColumn('dispatching_qty', function($row) {
                return $row->dispatching_qty;
            })
            ->addColumn('unit_name', function($row) {
                return $row->product && $row->product->unit ? $row->product->unit->unit_name : 'No unit';
            })
            ->addColumn('created_at', function($row) {
                return $row->created_at ? \Carbon\Carbon::parse($row->created_at)->timezone('Asia/Jakarta')->format('l, d F Y H:i') : 'N/A';
            })
            ->addColumn('created_by', function($row) {
                return $row->created_by ? optional(\App\Models\User::find($row->created_by))->name : 'N/A';
            })
            ->addColumn('confirmed_at', function($row) {
                return $row->confirmed_at ? \Carbon\Carbon::parse($row->confirmed_at)->timezone('Asia/Jakarta')->format('l, d F Y H:i') : 'N/A';
            })
            ->addColumn('confirmed_by', function($row) {
                return $row->confirmed_by ? optional(\App\Models\User::find($row->confirmed_by))->name : 'N/A';
            })
            ->addColumn('dispatching_detail_status', function($row) {
                $class = $row->dispatching_detail_status === 'Confirmed' ? 'badge-success' : 'badge-warning';
                return '<span class="badge '.$class.'">'.ucfirst($row->dispatching_detail_status).'</span>';
            })
            ->addColumn('actions', function($row) {
                return view('dispatching.partials.actionsUserDetail', compact('row'))->render();
            })
            ->rawColumns(['dispatching_detail_status', 'actions'])
            ->make(true);
    }

    // Show dispatching header by ID
    public function UserShowDetail($id)
    {
        $dispatchingHeader = DispatchingHeader::where('dispatching_header_id', $id)->firstOrFail();

        $dispatchingDetails = DispatchingDetail::where('dispatching_header_id', $id)
        ->orderBy('created_at', 'desc') // Urutkan berdasarkan created_at secara descending
        ->paginate(10);

        // Filter produk dengan status Active dan quantity > 0
        $products = Product::where('product_status', 'Active')
        ->where('product_qty', '>', 0)
        ->get();
        
        $categories = Category::all();
        $units = Unit::all();
        $suppliers = Supplier::all();

        return view('dispatching.user_detail', compact('dispatchingHeader', 'dispatchingDetails', 'products', 'categories', 'units', 'suppliers'));
    }

    // Create dispatching detail
    public function UserAddDetail(Request $request): RedirectResponse
    {
        $request->validate([
            'dispatching_detail_id'             => 'required',
            'dispatching_header_id'             => 'required',
            'product_id'                        => 'required',
            'dispatching_qty'                   => 'required',
            'created_by'                        => 'nullable',
            'dispatching_detail_status'         => 'nullable',
            'confirmed_by'                      => 'nullable',
            'confirmed_at'                      => 'nullable|date',
        ]);

        DispatchingDetail::create([
            'dispatching_detail_id'             => $request->dispatching_detail_id,
            'dispatching_header_id'             => $request->dispatching_header_id,
            'product_id'                        => $request->product_id,
            'dispatching_qty'                   => $request->dispatching_qty,
            'created_by'                        => $request->created_by,
            'dispatching_detail_status'         => $request->dispatching_detail_status,
            'confirmed_by'                      => $request->confirmed_by,
            'confirmed_at'                      => $request->confirmed_at,
        ]);

        return redirect()->back()->with('success', 'Dispatching detail added successfully!');
    }

    // Delete dispatching detail
    public function UserDestroyDetail($id)
    {
        $dispatchingDetail = DispatchingDetail::findOrFail($id);
        $dispatchingDetail->delete();

        return redirect()->back()->with('success', 'Dispatching detail deleted successfully!');
    }

    

    // Edit dispatching detail
    public function UserEditDetail($id)
    {
        $dispatchingDetail = DispatchingDetail::where('dispatching_detail_id', $id)->first();
    
        if (!$dispatchingDetail) {
            return response()->json(['error' => 'Dispatching detail not found'], 404);
        }
    
        return response()->json($dispatchingDetail);
    }

    // Update dispatching detail
    public function UserUpdateDetail(Request $request, $id)
    {
        $dispatchingDetail = DispatchingDetail::findOrFail($id);

        $request->validate([
            'product_id' => 'required|string|exists:products,product_id',
            'dispatching_qty' => 'required|integer|min:1',
            'dispatching_detail_status' => 'required|string|in:Pending,Confirmed',
        ]);

        $dispatchingDetail->update($request->all());

        return redirect()->back()->with('success', 'Dispatching detail updated successfully!');
    }

    // Confirm all pending dispatching details
    public function UserConfirmAll($id)
    {
        // Ambil Dispatching Header berdasarkan ID
        $dispatchingHeader = DispatchingHeader::where('dispatching_header_id', $id)->firstOrFail();
    
        // Perbarui status Dispatching Header
        $dispatchingHeader->update([
            'dispatching_header_status' => 'Confirmed',
            'confirmed_at' => now(),
            'confirmed_by' => Auth::user()->id,
        ]);
    
        // Ambil semua Dispatching Details dengan status 'Pending'
        $pendingDetails = DispatchingDetail::where('dispatching_header_id', $id)
            ->where('dispatching_detail_status', 'Pending')
            ->get();
    
        foreach ($pendingDetails as $detail) {
            // Ambil produk terkait
            $product = Product::where('product_id', $detail->product_id)->firstOrFail();
    
            // Hitung nilai untuk stock_change_logs
            $qtyBefore = $product->product_qty;
            $qtyChanged = $detail->dispatching_qty;
            $qtyAfter = $qtyBefore - $qtyChanged;
    
            // Perbarui product_qty di tabel products
            $product->update([
                'product_qty' => $qtyAfter,
            ]);
    
            // Perbarui dispatching_detail_status di tabel dispatching_details
            $detail->update([
                'dispatching_detail_status' => 'Confirmed',
                'confirmed_at' => now(),
                'confirmed_by' => Auth::user()->id,
            ]);
    
            // Tambahkan data ke tabel stock_change_logs
            StockChangeLog::create([
                'stock_change_log_id' => uniqid('SC'),
                'stock_change_type' => $dispatchingHeader->dispatching_header_name,
                'product_id' => $product->product_id,
                'reference_id' => $detail->dispatching_detail_id,
                'qty_before' => $qtyBefore,
                'qty_changed' => -$qtyChanged, // Negatif karena stok berkurang
                'qty_after' => $qtyAfter,
                'changed_at' => now(),
                'changed_by' => Auth::user()->id,
                'change_note' => $dispatchingHeader->dispatching_header_description,
            ]);
        }
    
        // Redirect kembali ke halaman sebelumnya dengan pesan sukses
        return redirect()->back()->with('success', 'All pending dispatching details confirmed successfully!');
    }


    // Confirm dispatching detail by ID
    public function UserConfirmDetail($id)
    {
        // Ambil Dispatching Detail berdasarkan ID
        $dispatchingDetail = DispatchingDetail::where('dispatching_detail_id', $id)->firstOrFail();

        // Ambil Dispatching Header terkait
        $dispatchingHeader = DispatchingHeader::where('dispatching_header_id', $dispatchingDetail->dispatching_header_id)->firstOrFail();

        // Ambil produk terkait
        $product = Product::where('product_id', $dispatchingDetail->product_id)->firstOrFail();

        // Hitung nilai untuk stock_change_logs
        $qtyBefore = $product->product_qty;
        $qtyChanged = $dispatchingDetail->dispatching_qty;
        $qtyAfter = $qtyBefore - $qtyChanged;

        // Perbarui product_qty di tabel products
        $product->update([
            'product_qty' => $qtyAfter,
        ]);

        // Perbarui dispatching_detail_status di tabel dispatching_details
        $dispatchingDetail->update([
            'dispatching_detail_status' => 'Confirmed',
            'confirmed_at' => now(),
            'confirmed_by' => Auth::user()->id,
        ]);

        // Tambahkan data ke tabel stock_change_logs
        StockChangeLog::create([
            'stock_change_log_id' => uniqid('SC'),
            'stock_change_type' => $dispatchingHeader->dispatching_header_name, // Ambil dari dispatching_header_name
            'product_id' => $product->product_id,
            'reference_id' => $dispatchingDetail->dispatching_detail_id,
            'qty_before' => $qtyBefore,
            'qty_changed' => -$qtyChanged, // Negatif karena stok berkurang
            'qty_after' => $qtyAfter,
            'changed_at' => now(),
            'changed_by' => Auth::user()->id,
            'change_note' => $dispatchingHeader->dispatching_header_description, // Ambil dari dispatching_header_description
        ]);

        // Redirect kembali ke halaman detail dengan pesan sukses
        return redirect()->back()->with('success', 'Dispatching detail confirmed successfully!');
    }

        // Get product unit by product ID
    public function UserGetUnit($id)
    {
        // Cari produk berdasarkan product_id
        $product = Product::with('unit')->where('product_id', $id)->first();

        if ($product && $product->unit) {
            return response()->json(['unit_name' => $product->unit->unit_name]);
        }

        return response()->json(['unit_name' => 'No unit found'], 404);
    }
    //GET PRODUCT QTY
    public function UserGetProductQty($productId)
    {
        $product = Product::findOrFail($productId);
        return response()->json(['product_qty' => $product->product_qty]);
    }


    // Print invoice
    public function UserPrintInvoice($id)
    {
        $dispatchingHeader = DispatchingHeader::findOrFail($id);
        $dispatchingDetails = DispatchingDetail::where('dispatching_header_id', $id)->get();
        
        // Ambil data perusahaan berdasarkan company_id pengguna yang sedang login
        $userCompany = UserCompany::where('company_id', auth()->user()->company_id)->first();
        $bankAccount = BankAccount::where('account_id', $userCompany->company_bank_account)->first();
    
        return view('dispatching.invoice', compact('dispatchingHeader', 'dispatchingDetails', 'userCompany', 'bankAccount'));
    }
    
    // Print delivery note
    public function UserPrintDeliveryNote($id)
    {
        $dispatchingHeader = DispatchingHeader::findOrFail($id);
        $dispatchingDetails = DispatchingDetail::where('dispatching_header_id', $id)->get();
        
        // Ambil data perusahaan berdasarkan company_id pengguna yang sedang login
        $userCompany = UserCompany::where('company_id', auth()->user()->company_id)->first();
        $bankAccount = BankAccount::where('account_id', $userCompany->company_bank_account)->first();
    
        
        return view('dispatching.delivery-note', compact('dispatchingHeader', 'dispatchingDetails', 'userCompany', 'bankAccount'));
    }



}

