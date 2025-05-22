<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Yajra\DataTables\Facades\DataTables;

class UserController extends Controller
{
    // DATATABLE
    public function getDatatable(Request $request)
    {
        $users = \App\Models\User::query();

        return \DataTables::of($users)
            ->addIndexColumn()
            ->addColumn('actions', function($row) {
                return view('users.partials.actions', compact('row'))->render();
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

    // USER PAGE
    public function index(): View
    {
        $users = User::orderBy('created_at', 'desc')->paginate(10);
        return view('users.index', compact('users'));
    }


    // ADD USER
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:users',
            'phone'    => 'nullable|string|max:20',
            'password' => 'required|string|min:6',
            'type'     => 'required|in:0,1,2'
        ]);

        User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'phone'    => $request->phone,
            'password' => Hash::make($request->password),
            'company_id'     => 1, // default
            'type'     => $request->type,
            
        ]);

        return redirect()->route('users.index')->with('success', 'User added successfully!');
    }

    // SHOW USER (untuk detail via ajax/modal)
    public function show($id)
    {
        $user = User::find($id);

        if (!$user) {
            return response()->json(['message' => 'User not found'], 404);
        }

        return response()->json($user);
    }

    // UPDATE USER
    public function update(Request $request, $id)
    {
        $user = User::find($id);

        if (!$user) {
            return response()->json(['message' => 'User not found'], 404);
        }

        $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:users,email,'.$user->id,
            'phone'    => 'nullable|string|max:20',
            'password' => 'nullable|string|min:6|confirmed',
            'type'     => 'required|in:0,1,2'
        ]);

        $user->name  = $request->name;
        $user->email = $request->email;
        $user->phone = $request->phone;
        $user->type  = $request->type;
        if ($request->password) {
            $user->password = Hash::make($request->password);
        }
        $user->save();

        return redirect()->route('users.index')->with('success', 'User updated successfully.');
    }

    // DELETE USER
    public function destroy($id)
    {
        $user = User::find($id);

        if (!$user) {
            return response()->json(['message' => 'User not found'], 404);
        }

        $user->delete();

        return redirect()->route('users.index')->with('success', 'User deleted successfully!');
    }
}