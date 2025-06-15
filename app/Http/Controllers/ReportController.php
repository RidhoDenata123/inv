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
use App\Models\Report;
use App\Models\StockChangeLog;

use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\Facades\DataTables;

class ReportController extends Controller
{
    //ADD REPORT
    public function store(Request $request)
    {
        $request->validate([
            'report_title' => 'required|string|max:255',
            'report_description' => 'required|string',
            'report_document' => 'nullable|file|mimes:pdf,doc,docx,xlsx,jpg,png|max:2048',
        ]);
    
        $documentPath = $request->file('report_document') ? $request->file('report_document')->store('reports', 'public') : null;
    
        Report::create([
            'report_id' => uniqid('REP'),
            'report_type' => 'stock',
            'report_title' => $request->report_title,
            'report_description' => $request->report_description,
            'report_document' => $documentPath,
            'generated_by' => auth()->user()->name,
        ]);
    
        return redirect()->route('reports.stock')->with('success', 'Report added successfully.');
    }

    //SHOW REPORT
    public function show($id)
    {
        \Log::info("Fetching report with ID: $id");

        // Ambil data report berdasarkan report_id
        $report = Report::where('report_id', $id)->first();

        if (!$report) {
            return response()->json(['message' => 'Report not found'], 404);
        }

        return response()->json($report);
    }

    //UPDATE REPORT
    public function update(Request $request, $id)
    {
        $report = Report::findOrFail($id);
    
        $request->validate([
            'report_title' => 'required|string|max:255',
            'report_description' => 'required|string',
            'report_document' => 'nullable|file|mimes:pdf,doc,docx,xlsx,jpg,png|max:2048',
        ]);
    
        if ($request->hasFile('report_document')) {
            if ($report->report_document) {
                Storage::disk('public')->delete($report->report_document);
            }
            $report->report_document = $request->file('report_document')->store('reports', 'public');
        }
    
        $report->update([
            'report_title' => $request->report_title,
            'report_description' => $request->report_description,
        ]);
    
        return redirect()->route('reports.archive')->with('success', 'Report updated successfully.');
    }
    //DELETE REPORT
    public function destroy($id)
    {
        $report = Report::findOrFail($id);
    
        if ($report->report_document) {
            Storage::disk('public')->delete($report->report_document);
        }
    
        $report->delete();
    
        return redirect()->route('reports.archive')->with('success', 'Report deleted successfully.');
    
    }

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    
    //ARCHIVE
    public function archive()
    {
        // Ambil data untuk masing-masing tab
        $stockReports = Report::where('report_type', 'stock')->orderBy('created_at', 'desc')->paginate(10);
        $stockMovementReports = Report::where('report_type', 'stock_movement')->orderBy('created_at', 'desc')->paginate(10);
        $stockMinimumReports = Report::where('report_type', 'minimum_stock')->orderBy('created_at', 'desc')->paginate(10);
        $receivingReports = Report::where('report_type', 'receiving')->orderBy('created_at', 'desc')->paginate(10);
        $dispatchingReports = Report::where('report_type', 'dispatching')->orderBy('created_at', 'desc')->paginate(10);
        $adjustmentReports = Report::where('report_type', 'stock_adjustment')->orderBy('created_at', 'desc')->paginate(10);
        // Kirim data ke view
        return view('reports.archive', compact('stockReports', 'stockMovementReports', 'stockMinimumReports', 'receivingReports', 'dispatchingReports', 'adjustmentReports'));
    }


    //STOCK ARCHIVE DATATABLE
    public function getStockDatatable(Request $request)
    {
        $stockReports = Report::where('report_type', 'stock');
        // Hapus ->orderBy('created_at', 'desc');

        return DataTables::of($stockReports)
            ->addIndexColumn()
            ->addColumn('document', function($row) {
                if ($row->report_document) {
                    return '<a href="'.asset('storage/' . $row->report_document).'" target="_blank">View Document</a>';
                }
                return 'No Document';
            })
            ->addColumn('actions', function($row) {
                return view('reports.partials.actions', compact('row'))->render();
            })
            // Tambahkan orderColumn berikut:
            ->orderColumn('created_at', function ($query, $order) {
                $query->orderBy('reports.created_at', $order);
            })
            ->orderColumn('report_title', function ($query, $order) {
                $query->orderBy('reports.report_title', $order);
            })
            ->orderColumn('report_description', function ($query, $order) {
                $query->orderBy('reports.report_description', $order);
            })
            ->orderColumn('generated_by', function ($query, $order) {
                $query->orderBy('reports.generated_by', $order);
            })
            ->rawColumns(['document', 'actions'])
            ->make(true);
    }

    //STOCK MOVEMENT ARCHIVE DATATABLE
    public function getMovementDatatable(Request $request)
    {
        $movementReports = Report::where('report_type', 'stock_movement');
        // Hapus ->orderBy('created_at', 'desc');

        return DataTables::of($movementReports)
            ->addIndexColumn()
            ->addColumn('document', function($row) {
                if ($row->report_document) {
                    return '<a href="'.asset('storage/' . $row->report_document).'" target="_blank">View Document</a>';
                }
                return 'No Document';
            })
            ->addColumn('actions', function($row) {
                return view('reports.partials.actions', compact('row'))->render();
            })
            // Tambahkan orderColumn berikut:
            ->orderColumn('created_at', function ($query, $order) {
                $query->orderBy('reports.created_at', $order);
            })
            ->orderColumn('report_title', function ($query, $order) {
                $query->orderBy('reports.report_title', $order);
            })
            ->orderColumn('report_description', function ($query, $order) {
                $query->orderBy('reports.report_description', $order);
            })
            ->orderColumn('generated_by', function ($query, $order) {
                $query->orderBy('reports.generated_by', $order);
            })
            ->rawColumns(['document', 'actions'])
            ->make(true);
    }

    //MINIMUM STOCK ARCHIVE DATATABLE
    public function getMinimumDatatable(Request $request)
    {
        $minimumReports = Report::where('report_type', 'minimum_stock')->orderBy('created_at', 'desc');
        return DataTables::of($minimumReports)
            ->addIndexColumn()
            ->addColumn('document', function($row) {
                if ($row->report_document) {
                    return '<a href="'.asset('storage/' . $row->report_document).'" target="_blank">View Document</a>';
                }
                return 'No Document';
            })
            ->addColumn('actions', function($row) {
                return view('reports.partials.actions', compact('row'))->render();
            })
            ->rawColumns(['document', 'actions'])
            ->make(true);
    }

    //RECEIVING ARCHIVE DATATABLE
    public function getReceivingDatatable(Request $request)
    {
        $receivingReports = Report::where('report_type', 'receiving')->orderBy('created_at', 'desc');

        return DataTables::of($receivingReports)
            ->addIndexColumn()
            ->addColumn('document', function($row) {
                if ($row->report_document) {
                    return '<a href="'.asset('storage/' . $row->report_document).'" target="_blank">View Document</a>';
                }
                return 'No Document';
            })
            ->addColumn('actions', function($row) {
                return view('reports.partials.actions', compact('row'))->render();
            })
            ->rawColumns(['document', 'actions'])
            ->make(true);
    }

    //DISPATCHING ARCHIVE DATATABLE
    public function getDispatchingDatatable(Request $request)
    {
        $dispatchingReports = Report::where('report_type', 'dispatching')->orderBy('created_at', 'desc');
        return DataTables::of($dispatchingReports)
            ->addIndexColumn()
            ->addColumn('document', function($row) {
                if ($row->report_document) {
                    return '<a href="'.asset('storage/' . $row->report_document).'" target="_blank">View Document</a>';
                }
                return 'No Document';
            })
            ->addColumn('actions', function($row) {
                return view('reports.partials.actions', compact('row'))->render();
            })
            ->rawColumns(['document', 'actions'])
            ->make(true);
    }

    //STOCK ADJUSTMENT ARCHIVE DATATABLE
    public function getAdjustmentDatatable(Request $request)
    {
        $adjustmentReports = Report::where('report_type', 'stock_adjustment')->orderBy('created_at', 'desc');
        return DataTables::of($adjustmentReports)
            ->addIndexColumn()
            ->addColumn('document', function($row) {
                if ($row->report_document) {
                    return '<a href="'.asset('storage/' . $row->report_document).'" target="_blank">View Document</a>';
                }
                return 'No Document';
            })
            ->addColumn('actions', function($row) {
                return view('reports.partials.actions', compact('row'))->render();
            })
            ->rawColumns(['document', 'actions'])
            ->make(true);
    }

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

    //STOCK REPORTS DATATABLE
    public function getStockProductDatatable(Request $request)
    {
        $products = Product::with(['category', 'supplier', 'unit']);

        return DataTables::of($products)
            ->addIndexColumn()
            ->addColumn('category', function($row) {
                return $row->category ? $row->category->category_name : 'No Category';
            })
            ->addColumn('purchase_price', function($row) {
                return 'Rp ' . number_format($row->purchase_price, 2, ',', '.');
            })
            ->addColumn('selling_price', function($row) {
                return 'Rp ' . number_format($row->selling_price, 2, ',', '.');
            })
            ->addColumn('supplier', function($row) {
                return $row->supplier ? $row->supplier->supplier_name : 'No Supplier';
            })
            ->addColumn('unit', function($row) {
                return $row->unit ? $row->unit->unit_name : 'No Unit';
            })
            ->addColumn('created_at', function($row) {
                return $row->created_at ? \Carbon\Carbon::parse($row->created_at)->format('d-m-Y H:i') : '';
            })


            // Tambahkan orderColumn berikut:
            ->orderColumn('category', function ($query, $order) {
                $query->leftJoin('categories as c', 'products.product_category', '=', 'c.category_id')
                    ->orderBy('c.category_name', $order);
            })
            ->orderColumn('supplier', function ($query, $order) {
                $query->leftJoin('suppliers as s', 'products.product_supplier', '=', 's.supplier_id')
                    ->orderBy('s.supplier_name', $order);
            })
            ->orderColumn('unit', function ($query, $order) {
                $query->leftJoin('units as u', 'products.product_unit', '=', 'u.unit_id')
                    ->orderBy('u.unit_name', $order);
            })
            ->orderColumn('purchase_price', function ($query, $order) {
                $query->orderBy('products.purchase_price', $order);
            })
            ->orderColumn('selling_price', function ($query, $order) {
                $query->orderBy('products.selling_price', $order);
            })
            ->orderColumn('product_id', function ($query, $order) {
                $query->orderBy('products.product_id', $order);
            })
            ->orderColumn('product_name', function ($query, $order) {
                $query->orderBy('products.product_name', $order);
            })
            ->orderColumn('product_qty', function ($query, $order) {
                $query->orderBy('products.product_qty', $order);
            })
            ->orderColumn('created_at', function ($query, $order) {
                $query->orderBy('products.created_at', $order);
            })
            ->make(true);
    }

    //STOCK REPORTS PAGE
    public function stockReports()
    {
 
        $products = Product::with('category', 'unit', 'supplier')
        ->orderBy('created_at', 'desc') // Urutkan berdasarkan created_at secara descending
        ->paginate(10);
        $categories = Category::all();
        $units = Unit::all();
        $suppliers = Supplier::all();

        return view('reports.stock', compact('products', 'categories', 'units', 'suppliers'));
    }
    
    //GENERATE STOCK REPORT with DOm pdf
    public function generateStockReport()
    {
        //Info
        $company = UserCompany::first();
        $generatedBy = auth()->user()->name;

        // Ambil semua data produk
        $products = Product::with(['category', 'unit'])->get();

        // Generate PDF menggunakan view
        $pdf = Pdf::loadView('reports.stock_pdf', compact('products', 'company', 'generatedBy'));

        // Nama file PDF
        $fileName = 'stock_report_' . now()->format('d_m_Y') . '.pdf';

        // Simpan file PDF ke storage (folder public/reports)
        Storage::disk('public')->put('reports/' . $fileName, $pdf->output());

        // Buat data baru di tabel reports
        Report::create([
            'report_id' => uniqid('REP'),
            'report_type' => 'stock',
            'report_title' => 'Stock Report ' . now()->format('d_m_Y'),
            'report_description' => 'Generated stock report.',
            'report_document' => 'reports/' . $fileName,
            'generated_by' => auth()->user()->name,
        ]);

        // Redirect kembali ke halaman laporan dengan pesan sukses
        return redirect()->route('reports.archive')->with('success', 'Stock report generated successfully.');
    }

    //STOCK MOVEMENT REPORTS DATATABLE
    public function getStockMovementDatatable(Request $request)
    {
        $query = \App\Models\StockChangeLog::with(['changedBy', 'product'])
            ->when($request->start_date, function($q) use ($request) {
                $q->whereDate('changed_at', '>=', $request->start_date);
            })
            ->when($request->end_date, function($q) use ($request) {
                $q->whereDate('changed_at', '<=', $request->end_date);
            });

        return DataTables::of($query)
            ->addIndexColumn()
            ->addColumn('changed_at', function($row) {
                return $row->changed_at ? \Carbon\Carbon::parse($row->changed_at)->timezone('Asia/Jakarta')->format('l, d F Y H:i') : 'N/A';
            })
            ->addColumn('changed_by', function($row) {
                return $row->changedBy->name ?? 'System';
            })
            ->addColumn('product_id', function($row) {
                return $row->product->product_id ?? 'N/A';
            })
            ->addColumn('product_name', function($row) {
                return $row->product->product_name ?? 'N/A';
            })
            // Tambahkan ini untuk enable sorting kolom relasi:
            ->orderColumn('changed_at', function ($query, $order) {
                $query->orderBy('changed_at', $order);
            })
            ->orderColumn('changed_by', function ($query, $order) {
            // Join ke users, atau gunakan subquery jika perlu
                $query->leftJoin('users as u', 'stock_change_logs.changed_by', '=', 'u.id')
                ->orderBy('u.name', $order);
            })
            ->orderColumn('product_id', function ($query, $order) {
                $query->leftJoin('products as p', 'stock_change_logs.product_id', '=', 'p.product_id')
                ->orderBy('p.product_id', $order);
            })
            ->orderColumn('product_name', function ($query, $order) {
                $query->leftJoin('products as p2', 'stock_change_logs.product_id', '=', 'p2.product_id')
                ->orderBy('p2.product_name', $order);
            })

            ->addColumn('row_class', function($row) {
                $type = $row->stock_change_type;
                if (in_array($type, ['Sales Order', 'Transfer Out'])) {
                    return 'table-success';
                } elseif (in_array($type, ['Restock', 'Opening Balance', 'Transfer In'])) {
                    return 'table-primary';
                } elseif ($type === 'Stock Adjustment') {
                    return 'table-warning';
                } elseif ($type === 'Write-Off') {
                    return 'table-danger';
                } elseif (in_array($type, ['Return to Supplier', 'Return from Customer'])) {
                    return 'table-secondary';
                }
                return '';
            })
            ->rawColumns([])
            ->make(true);
    }

    //Stock Movement Report
    public function stockMovementReports(Request $request)
    {
        // Ambil parameter start_date dan end_date dari request
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');

        // Jika Start Date dan End Date tidak diisi, kembalikan paginator kosong
        if (!$startDate || !$endDate) {
            $stockChangeLogs = StockChangeLog::whereRaw('1 = 0')->paginate(10); // Paginator kosong
        } else {
            // Query StockChangeLog dengan filter periode
            $query = StockChangeLog::with('product', 'changedBy')->orderBy('changed_at', 'desc');

            if ($startDate) {
                $query->whereDate('changed_at', '>=', $startDate);
            }

            if ($endDate) {
                $query->whereDate('changed_at', '<=', $endDate);
            }

            // Paginate hasil query
            $stockChangeLogs = $query->paginate(10)->appends([
                'start_date' => $startDate,
                'end_date' => $endDate,
            ]);
        }

        // Kirim data ke view
        return view('reports.stockMovement', compact('stockChangeLogs', 'startDate', 'endDate'));
    }

    //GENERATE STOCK MOVEMENT REPORT with DOm pdf
    public function generateStockMovementReport(Request $request)
    {
        // Validasi input
        $request->validate([
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
        ]);

        //Info
        $company = UserCompany::first();
        $generatedBy = auth()->user()->name;

        // Ambil data StockChangeLog berdasarkan Start Date dan End Date
        $stockChangeLogs = StockChangeLog::with('product', 'changedBy')
            ->whereDate('changed_at', '>=', $request->start_date)
            ->whereDate('changed_at', '<=', $request->end_date)
            ->orderBy('changed_at', 'desc')
            ->get();

        // Generate PDF menggunakan view
        $pdf = Pdf::loadView('reports.stockMovementPDF', compact('stockChangeLogs', 'request', 'company', 'generatedBy'));

        // Nama file PDF
        $fileName = 'stock_movement_report_' . now()->format('d_m_Y') . '.pdf';

        // Simpan file PDF ke storage (folder public/reports)
        Storage::disk('public')->put('reports/' . $fileName, $pdf->output());

        // Buat data baru di tabel reports
        Report::create([
            'report_id' => uniqid('REP'),
            'report_type' => 'stock_movement',
            'report_title' => 'Stock Movement Report ' . now()->format('d_m_Y'),
            'report_description' => 'Generated stock movement report for the period ' . $request->start_date . ' to ' . $request->end_date,
            'report_document' => 'reports/' . $fileName,
            'generated_by' => auth()->user()->name,
        ]);

        // Redirect kembali ke halaman laporan dengan pesan sukses
        return redirect()->route('reports.archive')->with('success', 'Stock Movement Report generated successfully.');
    }




    //STOCK MINIMUM REPORT DATATABLE
    public function getMinimumStockProductDatatable(Request $request)
    {
        $products = Product::with(['category', 'supplier', 'unit'])
            ->where('product_qty', '<', 5); // Minimum stock 5

        return \DataTables::of($products)
            ->addIndexColumn()
            ->addColumn('category', function($row) {
                return $row->category ? $row->category->category_name : 'No Category';
            })
            ->addColumn('purchase_price', function($row) {
                return 'Rp ' . number_format($row->purchase_price, 2, ',', '.');
            })
            ->addColumn('selling_price', function($row) {
                return 'Rp ' . number_format($row->selling_price, 2, ',', '.');
            })
            ->addColumn('supplier', function($row) {
                return $row->supplier ? $row->supplier->supplier_name : 'No Supplier';
            })
            ->addColumn('unit', function($row) {
                return $row->unit ? $row->unit->unit_name : 'No Unit';
            })
            // Tambahkan orderColumn jika ingin sorting kolom relasi
            ->orderColumn('category', function ($query, $order) {
                $query->leftJoin('categories as c', 'products.product_category', '=', 'c.category_id')
                    ->orderBy('c.category_name', $order);
            })
            ->orderColumn('supplier', function ($query, $order) {
                $query->leftJoin('suppliers as s', 'products.product_supplier', '=', 's.supplier_id')
                    ->orderBy('s.supplier_name', $order);
            })
            ->orderColumn('unit', function ($query, $order) {
                $query->leftJoin('units as u', 'products.product_unit', '=', 'u.unit_id')
                    ->orderBy('u.unit_name', $order);
            })
            ->orderColumn('product_id', function ($query, $order) {
                $query->orderBy('products.product_id', $order);
            })
            ->orderColumn('product_name', function ($query, $order) {
                $query->orderBy('products.product_name', $order);
            })
            ->orderColumn('product_qty', function ($query, $order) {
                $query->orderBy('products.product_qty', $order);
            })
            ->make(true);
    }

    //Stock Minimum Report
    public function minimumStockReport()
    {
        // Ambil data produk dengan product_qty kurang dari 5
        $products = Product::where('product_qty', '<', 5)->orderBy('product_qty', 'asc')->paginate(10);

        // Kirim data ke view
        return view('reports.minimumStock', compact('products'));
    }

    //GENERATE STOCK MINIMUM REPORT with DOm pdf
    public function generateMinimumStockReport()
    {
        //Info
        $company = UserCompany::first();
        $generatedBy = auth()->user()->name;

        // Ambil data produk dengan product_qty kurang dari 5
        $products = Product::where('product_qty', '<', 5)->orderBy('product_qty', 'asc')->get();

        // Generate PDF menggunakan view
        $pdf = Pdf::loadView('reports.minimumStockPDF', compact('products', 'company', 'generatedBy'));

        // Nama file PDF
        $fileName = 'minimum_stock_report_' . now()->format('d_m_Y') . '.pdf';

        // Simpan file PDF ke storage (folder public/reports)
        Storage::disk('public')->put('reports/' . $fileName, $pdf->output());

        // Buat data baru di tabel reports
        Report::create([
            'report_id' => uniqid('REP'),
            'report_type' => 'minimum_stock',
            'report_title' => 'Minimum Stock Report ' . now()->format('d_m_Y'),
            'report_description' => 'Generated minimum stock report.',
            'report_document' => 'reports/' . $fileName,
            'generated_by' => auth()->user()->name,
        ]);

        // Redirect kembali ke halaman laporan dengan pesan sukses
        return redirect()->route('reports.archive')->with('success', 'Minimum Stock Report generated successfully.');
    }




    //RECEIVING REPORT DATATABLE
    public function getReceivingReportDatatable(Request $request)
    {
        $logs = \App\Models\StockChangeLog::with(['product', 'changedBy'])
            ->whereIn('stock_change_type', ['Restock', 'Opening Balance', 'Transfer In', 'Return from Customer']);

        return \DataTables::of($logs)
            ->addIndexColumn()
            ->addColumn('changed_at', function($row) {
                return $row->changed_at ? \Carbon\Carbon::parse($row->changed_at)->timezone('Asia/Jakarta')->format('l, d F Y H:i') : 'N/A';
            })
            ->addColumn('product_id', function($row) {
                return $row->product->product_id ?? 'N/A';
            })
            ->addColumn('product_name', function($row) {
                return $row->product->product_name ?? 'N/A';
            })
            ->addColumn('changed_by', function($row) {
                return $row->changedBy->name ?? 'System';
            })
            // Tambahkan orderColumn berikut:
            ->orderColumn('changed_at', function ($query, $order) {
                $query->orderBy('stock_change_logs.changed_at', $order);
            })
            ->orderColumn('product_id', function ($query, $order) {
                $query->leftJoin('products as p', 'stock_change_logs.product_id', '=', 'p.product_id')
                    ->orderBy('p.product_id', $order);
            })
            ->orderColumn('product_name', function ($query, $order) {
                $query->leftJoin('products as p2', 'stock_change_logs.product_id', '=', 'p2.product_id')
                    ->orderBy('p2.product_name', $order);
            })
            ->orderColumn('changed_by', function ($query, $order) {
                $query->leftJoin('users as u', 'stock_change_logs.changed_by', '=', 'u.id')
                    ->orderBy('u.name', $order);
            })
            ->make(true);
    }

    //Receiving Report
    public function receivingReport()
    {
        // Ambil data dari StockChangeLog dengan stock_change_type tertentu
        $receivingLogs = StockChangeLog::whereIn('stock_change_type', ['Restock', 'Opening Balance', 'Transfer In', 'Return from Customer'])
            ->orderBy('changed_at', 'desc')
            ->paginate(10);

        // Kirim data ke view
        return view('reports.receivingReport', compact('receivingLogs'));
    }

    //GENERATE RECEIVING REPORT with DOm pdf
    public function generateReceivingReport()
    {
        //Info
        $company = UserCompany::first();
        $generatedBy = auth()->user()->name;

        // Ambil data dari StockChangeLog dengan stock_change_type tertentu
        $receivingLogs = StockChangeLog::whereIn('stock_change_type', ['Restock', 'Opening Balance', 'Transfer In', 'Return from Customer'])
            ->orderBy('changed_at', 'desc')
            ->get();

        // Generate PDF menggunakan view
        $pdf = Pdf::loadView('reports.receivingReportPDF', compact('receivingLogs', 'company', 'generatedBy'));

        // Nama file PDF
        $fileName = 'receiving_report_' . now()->format('d_m_Y') . '.pdf';

        // Simpan file PDF ke storage (folder public/reports)
        Storage::disk('public')->put('reports/' . $fileName, $pdf->output());

        // Buat data baru di tabel reports
        Report::create([
            'report_id' => uniqid('REP'),
            'report_type' => 'receiving',
            'report_title' => 'Receiving Report ' . now()->format('d_m_Y'),
            'report_description' => 'Generated receiving report.',
            'report_document' => 'reports/' . $fileName,
            'generated_by' => auth()->user()->name,
        ]);

        // Redirect kembali ke halaman laporan dengan pesan sukses
        return redirect()->route('reports.archive')->with('success', 'Receiving Report generated successfully.');
    }




    //DISPATCHING REPORT DATATABLE
    public function getDispatchingReportDatatable(Request $request)
    {
        $logs = \App\Models\StockChangeLog::with(['product', 'changedBy'])
            ->whereIn('stock_change_type', ['Sales Order', 'Transfer Out', 'Write-Off', 'Return to Supplier']);
          

        return \DataTables::of($logs)
            ->addIndexColumn()
            ->addColumn('changed_at', function($row) {
                return $row->changed_at ? \Carbon\Carbon::parse($row->changed_at)->timezone('Asia/Jakarta')->format('l, d F Y H:i') : 'N/A';
            })
            ->addColumn('product_id', function($row) {
                return $row->product->product_id ?? 'N/A';
            })
            ->addColumn('product_name', function($row) {
                return $row->product->product_name ?? 'N/A';
            })
            ->addColumn('changed_by', function($row) {
                return $row->changedBy->name ?? 'System';
            })
            // Tambahkan orderColumn berikut:
            ->orderColumn('changed_at', function ($query, $order) {
                $query->orderBy('stock_change_logs.changed_at', $order);
            })
            ->orderColumn('product_id', function ($query, $order) {
                $query->leftJoin('products as p', 'stock_change_logs.product_id', '=', 'p.product_id')
                    ->orderBy('p.product_id', $order);
            })
            ->orderColumn('product_name', function ($query, $order) {
                $query->leftJoin('products as p2', 'stock_change_logs.product_id', '=', 'p2.product_id')
                    ->orderBy('p2.product_name', $order);
            })
            ->orderColumn('changed_by', function ($query, $order) {
                $query->leftJoin('users as u', 'stock_change_logs.changed_by', '=', 'u.id')
                    ->orderBy('u.name', $order);
            })
            ->make(true);
    }

    //Dispatching Report
    public function dispatchingReport()
    {
        // Ambil data dari StockChangeLog dengan stock_change_type tertentu
        $dispatchingLogs = StockChangeLog::whereIn('stock_change_type', ['Sales Order', 'Transfer Out', 'Return to Supplier'])
            ->orderBy('changed_at', 'desc')
            ->paginate(10);

        // Kirim data ke view
        return view('reports.dispatchingReport', compact('dispatchingLogs'));
    }

    //GENERATE DISPATCHING REPORT with DOm pdf
    public function generateDispatchingReport()
    {
        //Info
        $company = UserCompany::first();
        $generatedBy = auth()->user()->name;

        // Ambil data dari StockChangeLog dengan stock_change_type tertentu
        $dispatchingLogs = StockChangeLog::whereIn('stock_change_type', ['Sales Order', 'Transfer Out', 'Return to Supplier'])
            ->orderBy('changed_at', 'desc')
            ->get();

        // Generate PDF menggunakan view
        $pdf = Pdf::loadView('reports.dispatchingReportPDF', compact('dispatchingLogs', 'company', 'generatedBy'));

        // Nama file PDF
        $fileName = 'dispatching_report_' . now()->format('d_m_Y') . '.pdf';

        // Simpan file PDF ke storage (folder public/reports)
        Storage::disk('public')->put('reports/' . $fileName, $pdf->output());

        // Buat data baru di tabel reports
        Report::create([
            'report_id' => uniqid('REP'),
            'report_type' => 'dispatching',
            'report_title' => 'Dispatching Report ' . now()->format('d_m_Y'),
            'report_description' => 'Generated dispatching report for stock changes of type Sales Order, Transfer Out, and Return to Supplier.',
            'report_document' => 'reports/' . $fileName,
            'generated_by' => auth()->user()->name,
        ]);

        // Redirect kembali ke halaman laporan dengan pesan sukses
        return redirect()->route('reports.archive')->with('success', 'Dispatching Report generated successfully.');
    }





    //STOCK ADJUSTMENT REPORT DATATABLE
    public function getStockAdjustmentDatatable(Request $request)
    {
        $logs = \App\Models\StockChangeLog::with(['product', 'changedBy'])
            ->whereIn('stock_change_type', ['Stock Adjustment', 'Write-Off']);


        return \DataTables::of($logs)
            ->addIndexColumn()
            ->addColumn('changed_at', function($row) {
                return $row->changed_at ? \Carbon\Carbon::parse($row->changed_at)->timezone('Asia/Jakarta')->format('l, d F Y H:i') : 'N/A';
            })
            ->addColumn('product_id', function($row) {
                return $row->product->product_id ?? 'N/A';
            })
            ->addColumn('product_name', function($row) {
                return $row->product->product_name ?? 'N/A';
            })
            ->addColumn('changed_by', function($row) {
                return $row->changedBy->name ?? 'System';
            })
            // Tambahkan orderColumn berikut:
            ->orderColumn('changed_at', function ($query, $order) {
                $query->orderBy('stock_change_logs.changed_at', $order);
            })
            ->orderColumn('product_id', function ($query, $order) {
                $query->leftJoin('products as p', 'stock_change_logs.product_id', '=', 'p.product_id')
                    ->orderBy('p.product_id', $order);
            })
            ->orderColumn('product_name', function ($query, $order) {
                $query->leftJoin('products as p2', 'stock_change_logs.product_id', '=', 'p2.product_id')
                    ->orderBy('p2.product_name', $order);
            })
            ->orderColumn('changed_by', function ($query, $order) {
                $query->leftJoin('users as u', 'stock_change_logs.changed_by', '=', 'u.id')
                    ->orderBy('u.name', $order);
            })
            ->make(true);
    }

    //Stock adjustment Report
    public function stockAdjustmentReport()
    {
        // Ambil data dari StockChangeLog dengan stock_change_type tertentu
        $adjustmentLogs = StockChangeLog::whereIn('stock_change_type', ['Stock Adjustment', 'Write-Off'])
            ->orderBy('changed_at', 'desc')
            ->paginate(10);

        // Kirim data ke view
        return view('reports.stockAdjustmentReport', compact('adjustmentLogs'));
    }

    //GENERATE STOCK ADJUSTMENT REPORT with DOm pdf
    public function generateStockAdjustmentReport()
    {
        //Info
        $company = UserCompany::first();
        $generatedBy = auth()->user()->name;

        // Ambil data dari StockChangeLog dengan stock_change_type tertentu
        $adjustmentLogs = StockChangeLog::whereIn('stock_change_type', ['Stock Adjustment', 'Write-Off'])
            ->orderBy('changed_at', 'desc')
            ->get();

        // Generate PDF menggunakan view
        $pdf = Pdf::loadView('reports.stockAdjustmentReportPDF', compact('adjustmentLogs', 'company', 'generatedBy'));

        // Nama file PDF
        $fileName = 'stock_adjustment_report_' . now()->format('d_m_Y') . '.pdf';

        // Simpan file PDF ke storage (folder public/reports)
        Storage::disk('public')->put('reports/' . $fileName, $pdf->output());

        // Buat data baru di tabel reports
        Report::create([
            'report_id' => uniqid('REP'),
            'report_type' => 'stock_adjustment',
            'report_title' => 'Stock Adjustment Report ' . now()->format('d_m_Y'),
            'report_description' => 'Generated stock adjustment report.',
            'report_document' => 'reports/' . $fileName,
            'generated_by' => auth()->user()->name,
        ]);

        // Redirect kembali ke halaman laporan dengan pesan sukses
        return redirect()->route('reports.archive')->with('success', 'Stock Adjustment Report generated successfully.');
    }


    /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////


}

