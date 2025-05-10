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
    
        return redirect()->route('reports.stock')->with('success', 'Report updated successfully.');
    }
    //DELETE REPORT
    public function destroy($id)
    {
        $report = Report::findOrFail($id);
    
        if ($report->report_document) {
            Storage::disk('public')->delete($report->report_document);
        }
    
        $report->delete();
    
        return redirect()->route('reports.stock')->with('success', 'Report deleted successfully.');
    }

    //ARCHIVE
    public function archive()
    {
        // Ambil data untuk masing-masing tab
        $stockReports = Report::where('report_type', 'stock')->orderBy('created_at', 'desc')->paginate(10);
        $stockMovementReports = Report::where('report_type', 'stock_movement')->orderBy('created_at', 'desc')->paginate(10);

        // Kirim data ke view
        return view('reports.archive', compact('stockReports', 'stockMovementReports'));
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
        // Ambil semua data produk
        $products = Product::with(['category', 'unit'])->get();

        // Generate PDF menggunakan view
        $pdf = Pdf::loadView('reports.stock_pdf', compact('products'));

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
        return redirect()->route('reports.stock')->with('success', 'Stock report generated successfully.');
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

        // Ambil data StockChangeLog berdasarkan Start Date dan End Date
        $stockChangeLogs = StockChangeLog::with('product', 'changedBy')
            ->whereDate('changed_at', '>=', $request->start_date)
            ->whereDate('changed_at', '<=', $request->end_date)
            ->orderBy('changed_at', 'desc')
            ->get();

        // Generate PDF menggunakan view
        $pdf = Pdf::loadView('reports.stockMovementPDF', compact('stockChangeLogs', 'request'));

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
        return redirect()->route('reports.stockMovement')->with('success', 'Stock Movement Report generated successfully.');
    }

}
