<?php
  
namespace App\Http\Controllers;
  
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\UserCompany;
use Illuminate\Http\RedirectResponse;

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
        return view('userDashboard');
    } 
  
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function adminDashboard(): View
    {
        return view('adminDashboard');
    }


    // Halaman Setting Admin
    public function AdminSetting(): View
    {
        $user = auth()->user(); // Ambil data user yang sedang login
        $usercompany = UserCompany::where('company_id', $user->company_id)->first(); // Ambil data perusahaan berdasarkan company_id user
    
        return view('setting.admin', compact('user', 'usercompany'));
    }

    // Admin Profile
    public function AdminProfile()
    {
        $user = auth()->user(); // Ambil data user yang sedang login
        return view('profile.admin', compact('user'));
        
    }

    // Admin Update Profile
    public function AdminUpdateProfile(Request $request)
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
        return redirect()->route('setting.admin')->with('success', 'Profile updated successfully!');
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

        return redirect()->back()->with('success', 'Profile picture updated successfully!');
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
            return redirect()->back()->with('error', 'The current password is incorrect.');
        }
        // Periksa apakah password baru sama dengan konfirmasi password
        if ($request->new_password !== $request->new_password_confirmation) {
            return redirect()->back()->with('error', 'The new password and confirmation password do not match.');
        }
        // Periksa apakah password baru sama dengan password lama
        if (Hash::check($request->new_password, $user->password)) {
            return redirect()->back()->with('error', 'The new password cannot be the same as the current password.');
        }

        // Perbarui password
        $user->password = bcrypt($request->new_password);
        $user->save();

        return redirect()->back()->with('success', 'Password updated successfully!');
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

        // Handle company_img upload
        if ($request->hasFile('company_img')) {
            // Delete old company_img if exists
            if ($userCompany->company_img && Storage::exists('public/' . $userCompany->company_img)) {
                Storage::delete('public/' . $userCompany->company_img);
            }

            // Store new company_img
            $path = $request->file('company_img')->store('company_img', 'public');
            $userCompany->company_img = $path;
        }

        $userCompany->save();

        return redirect()->back()->with('success', 'Company details updated successfully!');
    }


  
}
