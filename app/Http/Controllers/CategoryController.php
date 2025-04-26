<?php

namespace App\Http\Controllers;

//import model category
use App\Models\Category; 

//import return type View
use Illuminate\View\View;

//import return type redirectResponse
use Illuminate\Http\RedirectResponse;

//import Http Request
use Illuminate\Http\Request;

//import Storage
use Illuminate\Support\Facades\Storage;

class CategoryController extends Controller
{
    /**
     * index
     *
     * @return void
     */
    public function index() : View
    {
        //get all category
        $categories = Category::latest()->paginate(10);

        //render view with category
        return view('categories.index', compact('categories'));
    }

    /**
     * ADD CATEGORY
     *
     * @param  mixed $request
     * @return RedirectResponse
     */
    public function store(Request $request): RedirectResponse
    {
        //validate form
        $request->validate([
            'category_id'             => 'required',
            'category_name'           => 'required',
            'category_description'    => 'required',
        ]);

        //create categories
        Category::create([
            'category_id'          => $request->category_id,
            'category_name'        => $request->category_name,
            'category_description' => $request->category_description,
        ]);

        //redirect to index
        return redirect()->route('categories.index')->with('success', 'Category added successfully!');
    }

    //show category
    public function show($id)
    {
        \Log::info("Fetching category with ID: $id");
    
        $category = Category::where('category_id', $id)->first();
    
        if (!$category) {
            return response()->json(['message' => 'Category not found'], 404);
        }
    
        return response()->json($category);
    }
       
    //edit category
    public function update(Request $request, $id)
    {
        $request->validate([
            'category_name' => 'required|string|max:255',
            'category_description' => 'required|string',
        ]);
    
        $category = Category::where('category_id', $id)->first();
    
        if (!$category) {
            return response()->json(['message' => 'Category not found'], 404);
        }
    
        $category->update([
            'category_name' => $request->category_name,
            'category_description' => $request->category_description,
        ]);
        
        // Redirect dengan flash message
        return redirect()->route('categories.index')->with('success', 'Category updated successfully.');
        
    }

    //delete category
    public function destroy($id)
    {
        $category = Category::where('category_id', $id)->first();

        if (!$category) {
            return response()->json(['message' => 'Category not found'], 404);
        }

        $category->delete();

        // Redirect dengan flash message
        return redirect()->route('categories.index')->with('success', 'Product deleted successfully!');
    }


    
}