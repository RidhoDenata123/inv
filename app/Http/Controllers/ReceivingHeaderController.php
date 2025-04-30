<?php

namespace App\Http\Controllers;

//import model Receiving Header
use App\Models\ReceivingHeader; 

//import return type View
use Illuminate\View\View;

//import return type redirectResponse
use Illuminate\Http\RedirectResponse;

//import Http Request
use Illuminate\Http\Request;

//import Storage
use Illuminate\Support\Facades\Storage;

class ReceivingHeaderController extends Controller
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
    public function store(Request $request): RedirectResponse
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

    //show receiving header
    public function show($id)
    {
        $receivingHeader = ReceivingHeader::find($id);

        if (!$receivingHeader) {
            return response()->json(['error' => 'Receiving Header not found'], 404);
        }

        return response()->json($receivingHeader);
    }

       
    //edit receiving header
    public function update(Request $request, $id)
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
    public function destroy($id)
    {
        $receiving_headers = ReceivingHeader::where('receiving_header_id', $id)->first();

        if (!$receiving_headers) {
            return response()->json(['message' => 'Receiving draft not found'], 404);
        }

        $receiving_headers->delete();

        // Redirect dengan flash message
        return redirect()->route('receiving.header')->with('success', 'Receiving draft deleted successfully!');
    }


    
}