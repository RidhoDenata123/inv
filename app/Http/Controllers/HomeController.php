<?php
  
namespace App\Http\Controllers;
  
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\RedirectResponse;

use App\Models\User;
use App\Models\UserCompany;
use App\Models\BankAccount;
use App\Models\StockChangeLog;
use App\Models\Product;
use App\Models\Customer;
use App\Models\DispatchingDetail;
use App\Models\DispatchingHeader;
use App\Models\ReceivingDetail;
use App\Models\ReceivingHeader;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }
  
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function userDashboard(): View
    {
         //ITEM SOLD COUNT
        $itemSold = abs(StockChangeLog::where('stock_change_type', 'Sales Order')->sum('qty_changed'));
        //TRANSACTION COUNT
        $transaction = DispatchingHeader::where('dispatching_header_status', 'Confirmed')->count();

        //TOTAL INCOME FROM SALES ORDER
        $salesOrders = StockChangeLog::where('stock_change_type', 'Sales Order')->get(['product_id', 'qty_changed']);

        $totalIncome = 0;
            foreach ($salesOrders as $order) {
                $product = Product::where('product_id', $order->product_id)->first();
                if ($product) {
                    $totalIncome += abs($order->qty_changed) * $product->selling_price;
                }
            }
        //CUSTOMER COUNT
        $customerCount = Customer::count();

        // Data stok rendah
        $lowStockProducts = Product::where('product_qty', '<', 5)->get();
        $lowStockCount = $lowStockProducts->count();

        // Data dispatching pending
        $pendingDispatchings = DispatchingHeader::where('dispatching_header_status', 'Pending')->get();
        $pendingDispatchingCount = $pendingDispatchings->count();

        // Total alert
        $totalAlertCount = $lowStockCount + $pendingDispatchingCount;

        //MyAreaChart
        $receivingCount = \App\Models\ReceivingDetail::count();
        $dispatchingCount = \App\Models\DispatchingDetail::count();

        //MyPieChart
        $stockChangeSummary = StockChangeLog::select('stock_change_type')
        ->selectRaw('COUNT(*) as total')
        ->groupBy('stock_change_type')
        ->pluck('total', 'stock_change_type')
        ->toArray();


            //VIEW DAHBOARD
            return view('userDashboard', compact('itemSold','transaction','totalIncome','customerCount',
            'lowStockProducts', 'lowStockCount',
            'pendingDispatchings', 'pendingDispatchingCount', 'receivingCount',  'dispatchingCount', 'stockChangeSummary',
            'totalAlertCount',));
        }
  
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function adminDashboard(): View
    {
        //ITEM SOLD COUNT
        $itemSold = abs(StockChangeLog::where('stock_change_type', 'Sales Order')->sum('qty_changed'));
        //TRANSACTION COUNT
        $transaction = DispatchingHeader::where('dispatching_header_status', 'Confirmed')->count();

        //TOTAL INCOME FROM SALES ORDER
        $salesOrders = StockChangeLog::where('stock_change_type', 'Sales Order')->get(['product_id', 'qty_changed']);

        $totalIncome = 0;
            foreach ($salesOrders as $order) {
                $product = Product::where('product_id', $order->product_id)->first();
                if ($product) {
                    $totalIncome += abs($order->qty_changed) * $product->selling_price;
                }
            }
        //CUSTOMER COUNT
        $customerCount = Customer::count();

        // Data stok rendah
        $lowStockProducts = Product::where('product_qty', '<', 5)->get();
        $lowStockCount = $lowStockProducts->count();

        // Data dispatching pending
        $pendingDispatchings = DispatchingHeader::where('dispatching_header_status', 'Pending')->get();
        $pendingDispatchingCount = $pendingDispatchings->count();

        // Total alert
        $totalAlertCount = $lowStockCount + $pendingDispatchingCount;

        //MyAreaChart
        $receivingCount = \App\Models\ReceivingDetail::count();
        $dispatchingCount = \App\Models\DispatchingDetail::count();

        //MyPieChart
        $stockChangeSummary = StockChangeLog::select('stock_change_type')
        ->selectRaw('COUNT(*) as total')
        ->groupBy('stock_change_type')
        ->pluck('total', 'stock_change_type')
        ->toArray();


            //VIEW DAHBOARD
            return view('adminDashboard', compact('itemSold','transaction','totalIncome','customerCount',
            'lowStockProducts', 'lowStockCount',
            'pendingDispatchings', 'pendingDispatchingCount',  'receivingCount',  'dispatchingCount', 'stockChangeSummary',  
            'totalAlertCount',));
        }


    // Halaman Setting Admin
    public function AdminSetting(): View
    {
        $user = auth()->user(); // Ambil data user yang sedang login
        $usercompany = UserCompany::where('company_id', $user->company_id)->first(); // Ambil data perusahaan berdasarkan company_id user
        $BankAccounts = BankAccount::orderBy('created_at', 'desc')->paginate(5);
    
        return view('setting.admin', compact('user', 'usercompany', 'BankAccounts'));
    }

    
    // Halaman Setting Admin
    public function UserSetting(): View
    {
        $user = auth()->user(); // Ambil data user yang sedang login
        
    
        return view('setting.user', compact('user'));
    }



    // Admin Update Profile
    public function updateProfile(Request $request)
    {
        $user = auth()->user();

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . $user->id,
            'phone' => 'required|string|max:15',
            'password' => 'nullable|string|min:8|confirmed',
        ]);

        $user->name = $request->name;
        $user->email = $request->email;
        $user->phone = $request->phone;

        if ($request->filled('password')) {
            $user->password = bcrypt($request->password);
        }

        $user->save();

        // Redirect with flash message
        return redirect()->back()->with('success', 'Profile updated successfully!')->with('activeTab', 'myProfile');
    }

    // Admin Update Profile Image
    public function updateUserImage(Request $request)
    {
        $request->validate([
            'user_img' => 'required|image|mimes:jpg,jpeg,png|max:2048', // Validasi file
        ]);

        $user = auth()->user();

        // Hapus gambar lama jika ada
        if ($user->user_img && Storage::exists('public/' . $user->user_img)) {
            Storage::delete('public/' . $user->user_img);
        }

        // Simpan gambar baru
        $path = $request->file('user_img')->store('user_images', 'public');
        $user->user_img = $path;
        $user->save();

        return redirect()->back()->with('success', 'Profile picture updated successfully!')->with('activeTab', 'myProfile');
    }

    // Admin Update update password
    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'new_password' => 'required|min:8',
            'new_password_confirmation' => 'required|min:8',
        ]);

        $user = auth()->user();

        // Periksa apakah password saat ini cocok
        if (!Hash::check($request->current_password, $user->password)) {

            return redirect()->back()->with('error', 'The current password is incorrect.')->with('activeTab', 'myPassword');
        }
        // Periksa apakah password baru sama dengan konfirmasi password
        if ($request->new_password !== $request->new_password_confirmation) {
          
            return redirect()->back()->with('error', 'The new password and confirmation password do not match.')->with('activeTab', 'myPassword');
            
        }
        // Periksa apakah password baru sama dengan password lama
        if (Hash::check($request->new_password, $user->password)) {

            return redirect()->back()->with('error', 'The new password cannot be the same as the current password.')->with('activeTab', 'myPassword');
        }

        // Perbarui password
        $user->password = bcrypt($request->new_password);
        $user->save();


        return redirect()->back()->with('success', 'Password updated successfully!')->with('activeTab', 'myPassword');
    }


    //company profile edit
    public function AdminUpdateCompany(Request $request)
    {
        $request->validate([
            'company_name' => 'required|string|max:255',
            'company_description' => 'required|string|max:255',
            'company_address' => 'required|string|max:255',
            'company_email' => 'required|email|max:255',
            'company_phone' => 'required|string|max:15',
            'company_fax' => 'required|string|max:15',
            'company_website' => 'required|string|max:255',
            'company_img' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'company_currency' => 'required|string|max:255',
            'company_bank_account' => 'required|string|max:255',
        ]);

        $userCompany = UserCompany::findOrFail(auth()->user()->company_id);

        $userCompany->company_name = $request->company_name;
        $userCompany->company_description = $request->company_description;
        $userCompany->company_address = $request->company_address;
        $userCompany->company_email = $request->company_email;
        $userCompany->company_phone = $request->company_phone;
        $userCompany->company_fax = $request->company_fax;
        $userCompany->company_website = $request->company_website;
        $userCompany->company_currency = $request->company_currency;
        $userCompany->company_bank_account = $request->company_bank_account;

        $userCompany->save();


        return redirect()->back()->with('success', 'Company details updated successfully!')->with('activeTab', 'companyProfile');
    }

    //change company img
    public function updateCompanyImage(Request $request)
    {
        $request->validate([
            'company_img' => 'required|image|mimes:jpg,jpeg,png|max:2048', // Validasi file
        ]);

        $userCompany = UserCompany::findOrFail(auth()->user()->company_id);

        // Hapus gambar lama jika ada
        if ($userCompany->company_img && Storage::exists('public/' . $userCompany->company_img)) {
            Storage::delete('public/' . $userCompany->company_img);
        }

        // Simpan gambar baru
        $path = $request->file('company_img')->store('company_img', 'public');
        $userCompany->company_img = $path;
        $userCompany->save();

        
        return redirect()->back()->with('success', 'Company logo updated successfully!')->with('activeTab', 'companyProfile');
    }

    //ADD BANK ACCOUNT
    public function addBankAccount(Request $request): RedirectResponse
    {
        //validate form
        $request->validate([
            'account_id'        => 'required',
            'account_name'      => 'required',
            'bank_name'         => 'required',
        ]);

        //create BankAccount
        BankAccount::create([
            'account_id'        => $request->account_id,
            'account_name'      => $request->account_name,
            'bank_name'         => $request->bank_name,
        ]);

        //redirect to index
        return redirect()->back()->with('success', 'Bank Account added successfully!')->with('activeTab', 'companyProfile');
        
    }

   // Tampilkan data bank account (untuk modal edit, AJAX)
    public function showBankAccount($id)
    {
        $bank = BankAccount::where('account_id', $id)->first();
        if (!$bank) {
            return response()->json(['message' => 'Bank account not found'], 404);
        }
        return response()->json($bank);
    }

    // Update data bank account
    public function updateBankAccount (Request $request, $id)
    {
        $bank = BankAccount::where('account_id', $id)->firstOrFail();

        $request->validate([
            'account_name' => 'required|string|max:255',
            'bank_name' => 'required|string|max:255',
        ]);

        $bank->update([
            'account_name' => $request->account_name,
            'bank_name' => $request->bank_name,
        ]);

        return redirect()->route('setting.admin')->with('success', 'Bank account updated successfully.');
    }

    //delete bank
    public function deleteBankAccount($id)
    {
        $bank = BankAccount::where('account_id', $id)->first();

        if (!$bank) {
            return redirect()->back()->with('error', 'Bank account not found.');
        }

        $bank->delete();

        return redirect()->route('setting.admin')->with('success', 'Bank account deleted successfully!');
    }
    
}
