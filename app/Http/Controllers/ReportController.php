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

use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class ReportController extends Controller
{
    public function stockReport()
    {
        // Ambil data produk dari database
        $products = Product::all();

        return view('reports.stock', compact('products'));
    }
}
