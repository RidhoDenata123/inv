<?php

namespace App\Http\Controllers;

//import model unit
use App\Models\Unit; 

//import return type View
use Illuminate\View\View;

//import return type redirectResponse
use Illuminate\Http\RedirectResponse;

//import Http Request
use Illuminate\Http\Request;

//import Storage
use Illuminate\Support\Facades\Storage;

class UnitController extends Controller
{
    /**
     * index
     *
     * @return void
     */
    public function index() : View
    {
        //get all Units
        $units = Unit::latest()->paginate(10);

        //render view with Units
        return view('units.index', compact('units'));
    }

    /**
     * ADD UNIT
     *
     * @param  mixed $request
     * @return RedirectResponse
     */
    public function store(Request $request): RedirectResponse
    {
        //validate form
        $request->validate([
            'unit_id'             => 'required',
            'unit_name'           => 'required',
            'unit_description'    => 'required',
        ]);

        //create unit
        Unit::create([
            'unit_id'          => $request->unit_id,
            'unit_name'        => $request->unit_name,
            'unit_description' => $request->unit_description,
        ]);

        //redirect to index
        return redirect()->route('units.index')->with('success', 'Unit added successfully!');
    }

    //show unit
    public function show($id)
    {
        \Log::info("Fetching unit with ID: $id");
    
        $unit = Unit::where('unit_id', $id)->first();
    
        if (!$unit) {
            return response()->json(['message' => 'Unit not found'], 404);
        }
    
        return response()->json($unit);
    }
       
    //edit unit
    public function update(Request $request, $id)
    {
        $request->validate([
            'unit_name' => 'required|string|max:255',
            'unit_description' => 'required|string',
        ]);
    
        $unit = Unit::where('unit_id', $id)->first();
    
        if (!$unit) {
            return response()->json(['message' => 'Unit not found'], 404);
        }
    
        $unit->update([
            'unit_name' => $request->unit_name,
            'unit_description' => $request->unit_description,
        ]);
        
        // Redirect dengan flash message
        return redirect()->route('units.index')->with('success', 'Unit updated successfully.');
        
    }

    //delete unit
    public function destroy($id)
    {
        $unit = Unit::where('unit_id', $id)->first();

        if (!$unit) {
            return response()->json(['message' => 'Unit not found'], 404);
        }

        $unit->delete();

        // Redirect dengan flash message
        return redirect()->route('units.index')->with('success', 'Product deleted successfully!');
    }


    
}