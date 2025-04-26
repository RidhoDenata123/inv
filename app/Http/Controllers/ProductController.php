<?php

namespace App\Http\Controllers;

//import model
use App\Models\Product;
use App\Models\Category; 

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
        $products = Product::with('category')->paginate(10); // Eager load relasi category
        $categories = Category::all(); // Ambil semua data kategori
    
        return view('products.index', compact('products', 'categories'));
    }

    /**
     * store
     *
     * @param  mixed $request
     * @return RedirectResponse
     */
    public function store(Request $request): RedirectResponse
    {
        //validate form
        $request->validate([
            'product_id'             => 'required',
            'product_name'           => 'required',
            'product_category'       => 'required',
            'product_description'    => 'required',
            'product_qty'            => 'required|numeric',
            'purchase_price'         => 'required|numeric',
            'selling_price'          => 'required|numeric',
            'product_unit'           => 'required',
            'product_img'            => 'nullable|image|mimes:jpeg,jpg,png|max:2048',
            'supplier_id'            => 'required',
            'product_status'         => 'required',
        ]);

        //upload image
        $image = $request->file('product_img');
        $imageName = $image ? $image->store('products', 'public') : null;

        //create product
        Product::create([
            'product_id'          => $request->product_id,
            'product_name'        => $request->product_name,
            'product_category'    => $request->product_category,
            'product_description' => $request->product_description,
            'product_qty'         => $request->product_qty,
            'purchase_price'      => $request->purchase_price,
            'selling_price'       => $request->selling_price,
            'product_unit'        => $request->product_unit,
            'product_img'         => $imageName,
            'supplier_id'         => $request->supplier_id,
            'product_status'      => $request->product_status,
        ]);

        //redirect to index
        return redirect()->route('products.index')->with('success', 'Product added successfully!');
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
            'product_category' => $product->product_category,
            'product_description' => $product->product_description,
            'purchase_price' => $product->purchase_price,
            'selling_price' => $product->selling_price,
            'product_qty' => $product->product_qty,
            'product_unit' => $product->product_unit,
            'supplier_id' => $product->supplier_id,
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
        // Validasi form
        $request->validate([
            'product_img' => 'required|image|mimes:jpeg,jpg,png|max:2048',
        ]);

        // Cari produk berdasarkan product_id
        $product = Product::where('product_id', $id)->first();

        if (!$product) {
            return redirect()->route('products.index')->with('error', 'Product not found!');
        }

        // Hapus gambar lama jika ada
        if ($product->product_img) {
            Storage::disk('public')->delete($product->product_img);
        }

        // Simpan gambar baru
        $product->product_img = $request->file('product_img')->store('products', 'public');
        $product->save();

        return redirect()->route('products.index')->with('success', 'Product image updated successfully!');
    }

}