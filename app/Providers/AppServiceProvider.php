<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use App\Models\Product;
use App\Models\DispatchingHeader;
use App\Models\ReceivingHeader;
class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        View::composer(['partials.adminTopbar'], function ($view) {
           // Low stock products
        $lowStockProducts = Product::where('product_qty', '<', 5)->get();
        $lowStockCount = $lowStockProducts->count();

        // Pending dispatching
        $pendingDispatchings = DispatchingHeader::where('dispatching_header_status', 'Pending')->get();
        $pendingDispatchingCount = $pendingDispatchings->count();

        // Pending receiving
        $pendingReceivings = ReceivingHeader::where('receiving_header_status', 'Pending')->get();
        $pendingReceivingCount = $pendingReceivings->count();

        // Total alert
        $totalAlertCount = $lowStockCount + $pendingDispatchingCount + $pendingReceivingCount;

        $view->with('lowStockProducts', $lowStockProducts)
            ->with('lowStockCount', $lowStockCount)
            ->with('pendingDispatchings', $pendingDispatchings)
            ->with('pendingDispatchingCount', $pendingDispatchingCount)
            ->with('pendingReceivings', $pendingReceivings)
            ->with('pendingReceivingCount', $pendingReceivingCount)
            ->with('totalAlertCount', $totalAlertCount);
        });

         View::composer(['partials.userTopbar'], function ($view) {
           // Low stock products
        $lowStockProducts = Product::where('product_qty', '<', 5)->get();
        $lowStockCount = $lowStockProducts->count();

        // Pending dispatching
        $pendingDispatchings = DispatchingHeader::where('dispatching_header_status', 'Pending')->get();
        $pendingDispatchingCount = $pendingDispatchings->count();

        // Pending receiving
        $pendingReceivings = ReceivingHeader::where('receiving_header_status', 'Pending')->get();
        $pendingReceivingCount = $pendingReceivings->count();

        // Total alert
        $totalAlertCount = $lowStockCount + $pendingDispatchingCount + $pendingReceivingCount;

        $view->with('lowStockProducts', $lowStockProducts)
            ->with('lowStockCount', $lowStockCount)
            ->with('pendingDispatchings', $pendingDispatchings)
            ->with('pendingDispatchingCount', $pendingDispatchingCount)
            ->with('pendingReceivings', $pendingReceivings)
            ->with('pendingReceivingCount', $pendingReceivingCount)
            ->with('totalAlertCount', $totalAlertCount);
        });
    }

    
}
