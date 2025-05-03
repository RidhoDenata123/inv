<?php
namespace App\Http\Controllers;

use App\Models\DispatchingHeader;
use App\Models\DispatchingDetail;
use App\Models\Product;
use App\Models\Category;
use App\Models\Unit;
use App\Models\Supplier;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class DispatchingController extends Controller
{
    // Show all dispatching headers
    public function index(): View
    {
        $dispatching_headers = DispatchingHeader::paginate(10); // Ambil data dengan pagination
        return view('dispatching.header', compact('dispatching_headers'));
    }

    // Create dispatching header
    public function storeHeader(Request $request): RedirectResponse
    {
        $request->validate([
            'dispatching_header_id'             => 'required',
            'dispatching_header_name'           => 'required',
            'dispatching_header_description'    => 'nullable',
            'created_by'                        => 'required',
            'dispatching_header_status'         => 'required',
            'confirmed_by'                      => 'nullable',
            'confirmed_at'                      => 'nullable|date',
        ]);

        DispatchingHeader::create([
            'dispatching_header_id'             => $request->dispatching_header_id,
            'dispatching_header_name'           => $request->dispatching_header_name,
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
            'dispatching_header_description'    => 'nullable',
        ]);

        $dispatching_header = DispatchingHeader::where('dispatching_header_id', $id)->first();

        if (!$dispatching_header) {
            return response()->json(['message' => 'Dispatching draft not found'], 404);
        }

        $dispatching_header->update([
            'dispatching_header_name'           => $request->dispatching_header_name,
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

    // Show dispatching header by ID
    public function showById($id)
    {
        $dispatchingHeader = DispatchingHeader::where('dispatching_header_id', $id)->firstOrFail();
        $dispatchingDetails = DispatchingDetail::where('dispatching_header_id', $id)->get();
        $products = Product::all();
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
        $dispatchingHeader = DispatchingHeader::where('dispatching_header_id', $id)->firstOrFail();

        $dispatchingHeader->update([
            'dispatching_header_status' => 'Confirmed',
            'confirmed_at' => now(),
            'confirmed_by' => Auth::user()->id,
        ]);

        $pendingDetails = DispatchingDetail::where('dispatching_header_id', $id)
            ->where('dispatching_detail_status', 'Pending')
            ->get();

        foreach ($pendingDetails as $detail) {
            $detail->update([
                'dispatching_detail_status' => 'Confirmed',
                'confirmed_at' => now(),
                'confirmed_by' => Auth::user()->id,
            ]);

            $product = Product::where('product_id', $detail->product_id)->first();
            if ($product) {
                $product->update([
                    'product_qty' => $product->product_qty - $detail->dispatching_qty,
                ]);
            }
        }

        return redirect()->back()->with('success', 'All pending dispatching details confirmed successfully!');
    }

    // Confirm dispatching detail by ID
    public function confirmDetail($id)
    {
        $dispatchingDetail = DispatchingDetail::where('dispatching_detail_id', $id)->firstOrFail();

        $dispatchingDetail->update([
            'dispatching_detail_status' => 'Confirmed',
            'confirmed_at' => now(),
            'confirmed_by' => Auth::user()->id,
        ]);

        $product = Product::where('product_id', $dispatchingDetail->product_id)->first();
        if ($product) {
            $product->update([
                'product_qty' => $product->product_qty - $dispatchingDetail->dispatching_qty,
            ]);
        }

        return redirect()->back()->with('success', 'Dispatching detail confirmed successfully!');
    }

    public function getUnit($id)
{
    // Cari produk berdasarkan product_id
    $product = Product::with('unit')->where('product_id', $id)->first();

    if ($product && $product->unit) {
        return response()->json(['unit_name' => $product->unit->unit_name]);
    }

    return response()->json(['unit_name' => 'No unit found'], 404);
}
}