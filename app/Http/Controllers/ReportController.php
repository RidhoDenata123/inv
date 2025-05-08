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

use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Storage;

class ReportController extends Controller
{
    
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
    
    public function destroy($id)
    {
        $report = Report::findOrFail($id);
    
        if ($report->report_document) {
            Storage::disk('public')->delete($report->report_document);
        }
    
        $report->delete();
    
        return redirect()->route('reports.stock')->with('success', 'Report deleted successfully.');
    }




    //STOCK REPORTS PAGE
    public function stockReports()
    {
        // Ambil data dari tabel reports dengan report_type = 'stock'
        $reports = Report::where('report_type', 'stock')->paginate(10);

        // Kirim data ke view
        return view('reports.stock', compact('reports'));
    }
    
    //GENERATE STOCK REPORT with DOm pdf
    public function generateStockReport()
    {
        // Ambil semua data produk
        $products = Product::with(['category', 'unit'])->get();

        // Generate PDF menggunakan view
        $pdf = Pdf::loadView('reports.stock_pdf', compact('products'));

        // Nama file PDF
        $fileName = 'stock_report_' . now()->format('Ymd_His') . '.pdf';

        // Simpan file PDF ke storage (folder public/reports)
        Storage::disk('public')->put('reports/' . $fileName, $pdf->output());

        // Buat data baru di tabel reports
        Report::create([
            'report_id' => uniqid('REP'),
            'report_type' => 'stock',
            'report_title' => 'Stock Report ' . now()->format('Y-m-d H:i:s'),
            'report_description' => 'Generated stock report.',
            'report_document' => 'reports/' . $fileName,
            'generated_by' => auth()->user()->name,
        ]);

        // Redirect kembali ke halaman laporan dengan pesan sukses
        return redirect()->route('reports.stock')->with('success', 'Stock report generated successfully.');
    }
}
