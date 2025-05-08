<?php

namespace App\Http\Controllers;

//import model
use App\Models\Product;
use App\Models\Category;
use App\Models\Unit;  
use App\Models\Supplier;
use App\Models\StockChangeLog;  

//import return type View
use Illuminate\View\View;

//import return type redirectResponse
use Illuminate\Http\RedirectResponse;

//import Http Request
use Illuminate\Http\Request;

//import Storage
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    /**
     * index
     *
     * @return void
     */
    public function index() : View
    {
        $products = Product::with('category', 'unit', 'supplier')->paginate(10);
        $categories = Category::all();
        $units = Unit::all();
        $suppliers = Supplier::all();

        return view('products.index', compact('products', 'categories', 'units', 'suppliers'));
    }

    /**
     * STORE PRODUCT
     *
     * @param  mixed $request
     * @return RedirectResponse
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'product_id' => 'required|string|unique:products,product_id',
            'product_name' => 'required|string|max:255',
            'product_category' => 'required|string',
            'product_description' => 'nullable|string',
            'product_qty' => 'required|integer|min:0',
            'purchase_price' => 'required|numeric|min:0',
            'selling_price' => 'required|numeric|min:0',
            'product_unit' => 'required|string|max:50',
            'supplier_id' => 'required|string|max:50',
            'product_status' => 'required|in:active,inactive',
            'product_img' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // Validasi gambar
        ]);

        try {
            // Simpan produk
            $product = new Product($request->all());

            // Simpan gambar jika ada
            if ($request->hasFile('product_img')) {
                $imagePath = $request->file('product_img')->store('products', 'public');
                $product->product_img = $imagePath;
            }

            $product->save();

            return redirect()->route('products.index')->with('success', 'Product added successfully!');
        } catch (\Exception $e) {
            return redirect()->route('products.index')->with('error', 'Failed to add product. Please check the image format or size.');
        }
    }
    //SHOW DETAIL
    public function getDetail($product_id)
    {
        // Cari produk berdasarkan product_id
        $product = Product::where('product_id', $product_id)->first();
    
        // Jika produk tidak ditemukan, kembalikan error 404
        if (!$product) {
            return response()->json(['error' => 'Product not found'], 404);
        }
    
        // Kembalikan data produk dalam format JSON
        return response()->json([
            'product_id' => $product->product_id,
            'product_name' => $product->product_name,
            'product_category' => $product->category ? $product->category->category_id : null,
            'category_name' => $product->category ? $product->category->category_name : 'No Category', // Untuk modal show
            'product_description' => $product->product_description,
            'purchase_price' => $product->purchase_price,
            'selling_price' => $product->selling_price,
            'product_qty' => $product->product_qty,
            'product_unit' => $product->product_unit,
            'unit_name' => $product->unit ? $product->unit->unit_name : 'No Unit', // Untuk modal show
            'supplier_id' => $product->supplier_id,
            'supplier_name' => $product->supplier ? $product->supplier->supplier_name : 'No Supplier', // Untuk modal show
            'product_status' => $product->product_status,
            'product_img' => $product->product_img ? asset('storage/' . $product->product_img) : null, // URL gambar
        ]);
    }

    // DELETE PRODUCT
    public function destroy($id)
    {
        // Cari produk berdasarkan product_id
        $product = Product::where('product_id', $id)->first();
    
        if (!$product) {
            return redirect()->route('products.index')->with('status', 'Product not found!');
        }
    
        // Hapus gambar produk jika ada
        if ($product->product_img) {
            Storage::disk('public')->delete($product->product_img);
        }
    
        // Hapus produk
        $product->delete();
    
         // Redirect dengan flash message
    return redirect()->route('products.index')->with('success', 'Product deleted successfully!');
    }

    // EDIT PRODUCT
    public function update(Request $request, $id): RedirectResponse
    {
        // Validasi form
        $request->validate([
            'product_name'           => 'required',
            'product_category'       => 'required',
            'product_description'    => 'required',
            'product_qty'            => 'required|numeric',
            'purchase_price'         => 'required|numeric',
            'selling_price'          => 'required|numeric',
            'product_unit'           => 'required',
            'supplier_id'            => 'required',
            'product_status'         => 'required',
        ]);
    
        // Cari produk berdasarkan product_id
        $product = Product::where('product_id', $id)->first();
    
        if (!$product) {
            return redirect()->route('products.index')->with('error', 'Product not found!');
        }
    
        // Update data produk
        $product->update($request->all());
    
        return redirect()->route('products.index')->with('success', 'Product updated successfully!');
    }


    // CHANGE IMAGE
    public function changeImage(Request $request, $id): RedirectResponse
    {
        $request->validate([
            'product_img' => 'required|image|mimes:jpeg,jpg,png,gif|max:2048', // Validasi gambar
        ]);
    
        $product = Product::where('product_id', $id)->first();
    
        if (!$product) {
            return redirect()->route('products.index')->with('error', 'Product not found!');
        }
    
        try {
            // Hapus gambar lama jika ada
            if ($product->product_img) {
                Storage::disk('public')->delete($product->product_img);
            }
    
            // Simpan gambar baru
            $product->product_img = $request->file('product_img')->store('products', 'public');
            $product->save();
    
            return redirect()->route('products.index')->with('success', 'Product image updated successfully!');
        } catch (\Exception $e) {
            return redirect()->route('products.index')->with('error', 'Failed to update product image. Please check the image format or size.');
        }
    }

    // GET UNIT
    public function getUnit($id)
    {
        // Cari produk berdasarkan product_id
        $product = Product::with('unit')->where('product_id', $id)->first();

        // Jika produk ditemukan dan memiliki unit
        if ($product && $product->unit) {
            return response()->json(['unit_name' => $product->unit->unit_name]);
        }

        // Jika produk atau unit tidak ditemukan
        return response()->json(['unit_name' => 'No unit found'], 404);
    }

    //Product Stock Adjustment
    public function adjustStock(Request $request, $id)
    {
        $request->validate([
            'qty_changed' => 'required|integer',
            'change_note' => 'required|string|max:255',
        ]);

        // Ambil produk berdasarkan ID
        $product = Product::findOrFail($id);

        // Hitung nilai untuk stock_change_logs
        $qtyBefore = $product->product_qty;
        $qtyChanged = $request->qty_changed;
        $qtyAfter = $qtyBefore + $qtyChanged;

        // Perbarui product_qty di tabel products
        $product->update([
            'product_qty' => $qtyAfter,
        ]);

        // Tambahkan data ke tabel stock_change_logs
        StockChangeLog::create([
            'stock_change_log_id' => uniqid('SC'),
            'stock_change_type' => 'Adjustment', // Tipe perubahan
            'reference_id' => '', // Tipe perubahan
            'product_id' => $product->product_id,
            'qty_before' => $qtyBefore,
            'qty_changed' => $qtyChanged,
            'qty_after' => $qtyAfter,
            'changed_at' => now(),
            'changed_by' => auth()->user()->id,
            'change_note' => $request->change_note,
        ]);

        // Redirect kembali dengan pesan sukses
        return redirect()->back()->with('success', 'Stock adjusted successfully!');
    }


}