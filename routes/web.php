<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\UnitController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\ReceivingController;
use App\Http\Controllers\DispatchingController;
use App\Http\Controllers\ReportController;



Route::get('/', function () {
    return view('welcome');
}); 

Auth::routes();

Route::get('/forgot-password', [ForgotPasswordController::class, 'showLinkRequestForm'])->name('password.request');
Route::post('/forgot-password', [ForgotPasswordController::class, 'sendResetLinkEmail'])->name('password.email');



/*------------------------------------------
--------------------------------------------
All Normal Users Routes List
--------------------------------------------
--------------------------------------------*/
Route::middleware(['auth', 'user-access:user'])->group(function () {
  
    // User dashboard Route
    Route::get('/user/dashboard', [HomeController::class, 'userDashboard'])->name('user.dashboard');

    // Profile page Route
    Route::get('/user/profile', [HomeController::class, 'profile'])->name('user.profile.index');
    // Profile update Route
    Route::put('/user/profile', [HomeController::class, 'updateProfile'])->name('user.profile.update');

// ALL DISPATCHING HEADER TRANSACTION ROUTE  

    // Dispatching Header page Route
    Route::get('/user/dispatching/header', [DispatchingController::class, 'UserDispatching'])->name('dispatching.user_header');
    // Dispatching Header add Route
    Route::post('/user/dispatching/header', [DispatchingController::class, 'UserStoreHeader'])->name('dispatching.user_header.UserStoreHeader');
    // Dispatching Header edit Route
    Route::get('/user/dispatching/header/{id}', [DispatchingController::class, 'UserEditHeader'])->name('dispatching.user_header.UserEditHeader');
    // Dispatching Header update Route
    Route::put('/user/dispatching/header/{id}', [DispatchingController::class, 'UserUpdateHeader'])->name('dispatching.user_header.UserUpdateHeader');
    // Dispatching Header delete Route
    Route::delete('/user/dispatching/header/{id}', [DispatchingController::class, 'UserDestroyHeader'])->name('dispatching.user_header.UserDestroyHeader');


// ALL DISPATCHING DETAIL TRANSACTION ROUTE  

    // Dispatching detail Route
    Route::get('/user/dispatching/detail/{id}', [DispatchingController::class, 'UserShowDetail'])->name('dispatching.user_detail.UserShowDetail');
    // Dispatching detail add Route
    Route::post('/user/dispatching/detail', [DispatchingController::class, 'UserAddDetail'])->name('dispatching.user_detail.UserAddDetail');
    // get unit
    Route::get('/user/products/{id}/unit', [DispatchingController::class, 'UserGetUnit'])->name('products.UserGetUnit');
    Route::get('/user/products/{productId}/qty', [ProductController::class, 'UserGetProductQty']);
    // Product detail Route
    Route::get('/user/products/detail/{product_id}', [ProductController::class, 'UserGetProduct']);
    // Dispatching detail delete Route
    Route::delete('/user/dispatching/detail/{id}', [DispatchingController::class, 'UserDestroyDetail'])->name('dispatching.user_detail.UserDestroyDetail');
    // Rute untuk mendapatkan detail Dispatching detail
    Route::get('/user/dispatching/detail-modal/{id}', [DispatchingController::class, 'UserEditDetail'])->name('dispatching.user_detail.UserEditDetail');
    // Rute untuk memperbarui Dispatching detail
    Route::put('/user/dispatching/detail/{id}', [DispatchingController::class, 'UserUpdateDetail'])->name('dispatching.user_detail.UserUpdateDetail');
    // Rute untuk mengonfirmasi all Dispatching
    Route::put('/user/dispatching/confirm-all/{id}', [DispatchingController::class, 'UserConfirmAll'])->name('dispatching.UserConfirmAll');
    // Rute untuk mengonfirmasi Dispatching by id
    Route::put('/user/dispatching/detail/confirm/{id}', [DispatchingController::class, 'UserConfirmDetail'])->name('dispatching.user_detail.UserConfirmDetail');
    // Rute untuk mencetak faktur Dispatching
    Route::get('/user/dispatching/invoice/{id}', [DispatchingController::class, 'UserPrintInvoice'])->name('dispatching.user_invoice');
    // Rute untuk mencetak nota pengiriman Dispatching
    Route::get('/user/dispatching/delivery-note/{id}', [DispatchingController::class, 'UserPrintDeliveryNote'])->name('dispatching.user_deliveryNote');

//ALL SETTING ROUTE

    //ADMIN SETTING PAGE
    Route::get('/user/setting', [HomeController::class, 'UserSetting'])->name('setting.user');
    //ADMIN SETTING UPDATEPROFILE
    Route::put('/user/setting/profile', [HomeController::class, 'updateProfile'])->name('setting.user.updateProfile');
    //ADMIN SETTING UPDATE PASSWORD
    Route::put('/user/setting/update-password', [HomeController::class, 'updatePassword'])->name('setting.user.updatePassword');
    //ADMIN SETTING CHANGE IMAGE
    Route::put('/user/setting/update-user-image', [HomeController::class, 'updateUserImage'])->name('setting.user.updateUserImage');


    
    
    
});
  
/*------------------------------------------
--------------------------------------------
All Admin Routes List
--------------------------------------------
--------------------------------------------*/
Route::middleware(['auth', 'user-access:admin'])->group(function () {
  
    // Admin dashboard Route
    Route::get('/admin/dashboard', [HomeController::class, 'adminDashboard'])->name('admin.dashboard');

//ALL SETTING ROUTE

    //ADMIN SETTING PAGE
    Route::get('/setting', [HomeController::class, 'AdminSetting'])->name('setting.admin');
    //ADMIN SETTING UPDATEPROFILE
    Route::put('/setting/profile', [HomeController::class, 'updateProfile'])->name('setting.admin.updateProfile');
    //ADMIN SETTING UPDATE PASSWORD
    Route::put('/setting/update-password', [HomeController::class, 'updatePassword'])->name('setting.admin.updatePassword');
    //ADMIN SETTING CHANGE IMAGE
    Route::put('/setting/update-user-image', [HomeController::class, 'updateUserImage'])->name('setting.admin.updateUserImage');
    //ADMIN SETTING COMPANY UPDATE
    Route::put('/setting/update-company', [HomeController::class, 'AdminUpdateCompany'])->name('setting.admin.updateCompany');
    //ADMIN SETTING COMPANY CHANGE IMAGE
    Route::put('/setting/update-company-image', [HomeController::class, 'updateCompanyImage'])->name('setting.admin.updateCompanyImage');
    //ADMIN SETTING ADD BANK ACCOUNT
    Route::post('/setting/add-bank', [HomeController::class, 'addBankAccount'])->name('setting.admin.addBankAccount');
    //ADMIN SETTING SHOW BANK ACCOUNT
    Route::get('/setting/show-bank/{id}', [HomeController::class, 'showBankAccount'])->name('setting.admin.showBankAccount');
    //ADMIN SETTING EDIT BANK ACCOUNT
    Route::put('/setting/update-bank/{id}', [HomeController::class, 'updateBankAccount'])->name('setting.admin.updateBankAccount');
    //ADMIN SETTING DELETE BANK ACCOUNT
    Route::delete('/setting/delete-bank/{id}', [HomeController::class, 'deleteBankAccount'])->name('setting.admin.deleteBankAccount');

    // Profile page Route
    Route::get('/admin/profile', [HomeController::class, 'AdminProfile'])->name('admin.profile.index');
    // Profile update Route
    Route::put('/admin/profile', [HomeController::class, 'AdminUpdateProfile'])->name('admin.profile.update');


// ALL PRODUCT ROUTE

    Route::get('/products/datatables', [ProductController::class, 'getProductsDatatable'])->name('products.datatable');
    // Product page Route
    Route::get('/products', [ProductController::class, 'index'])->name('products.index');
    // Product add Route
    Route::post('/products', [ProductController::class, 'store'])->name('products.store');
    // Product detail Route
    Route::get('/products/{product_id}/detail', [ProductController::class, 'getDetail'])->name('products.detail');
    // Product delete Route
    Route::delete('/products/{product_id}', [ProductController::class, 'destroy'])->name('products.destroy');
    // Product edit Route
    Route::put('/products/{product_id}', [ProductController::class, 'update'])->name('products.update');
    // Product change image Route
    Route::put('/products/{id}/change-image', [ProductController::class, 'changeImage'])->name('products.change-image');
     // Product stock adjustment Route
    Route::put('/products/{id}/adjust-stock', [ProductController::class, 'adjustStock'])->name('products.adjustStock');

// ALL CATEGORY ROUTE

    Route::get('/categories/datatables', [CategoryController::class, 'getDatatable'])->name('categories.datatable');
    // Category page Route
    Route::get('/categories', [CategoryController::class, 'index'])->name('categories.index');
    // Category add Route
    Route::post('/categories', [CategoryController::class, 'store'])->name('categories.store');
    // Category detail Route
    Route::get('/categories/show/{id}', [CategoryController::class, 'show'])->name('categories.show');
    // Category edit update
    Route::put('/categories/update/{id}', [CategoryController::class, 'update'])->name('categories.update');
    // Category delete Route
    Route::delete('/categories/delete/{id}', [CategoryController::class, 'destroy'])->name('categories.destroy');
    
// ALL UNIT ROUTE

    Route::get('/units/datatables', [UnitController::class, 'getDatatable'])->name('units.datatable');
    // Unit page Route
    Route::get('/units', [UnitController::class, 'index'])->name('units.index');
    // Unit add Route
    Route::post('/units', [UnitController::class, 'store'])->name('units.store');
    // Unit detail Route
    Route::get('/units/show/{id}', [UnitController::class, 'show'])->name('units.show');
    // Unit update Route
    Route::put('/units/update/{id}', [UnitController::class, 'update'])->name('units.update');
    // Unit delete Route
    Route::delete('/units/delete/{id}', [UnitController::class, 'destroy'])->name('units.destroy');

// ALL SUPPLIER ROUTE

    Route::get('/suppliers/datatables', [SupplierController::class, 'getDatatable'])->name('suppliers.datatable');
    // Supplier page Route
    Route::get('/suppliers', [SupplierController::class, 'index'])->name('suppliers.index');
    // Supplier add Route
    Route::post('/suppliers', [SupplierController::class, 'store'])->name('suppliers.store');
    // Supplier detail Route
    Route::get('/suppliers/show/{id}', [SupplierController::class, 'show'])->name('suppliers.show');
    // Supplier update Route
    Route::put('/suppliers/update/{id}', [SupplierController::class, 'update'])->name('suppliers.update');
    // Supplier delete Route
    Route::delete('/suppliers/delete/{id}', [SupplierController::class, 'destroy'])->name('suppliers.destroy');

// ALL CUSTOMER ROUTE

    Route::get('/customers/datatables', [CustomerController::class, 'getDatatable'])->name('customers.datatable');
    // Supplier page Route
    Route::get('/customers', [CustomerController::class, 'index'])->name('customers.index');
    // Supplier add Route
    Route::post('/customers', [CustomerController::class, 'store'])->name('customers.store');
    // Supplier detail Route
    Route::get('/customers/show/{id}', [CustomerController::class, 'show'])->name('customers.show');
    // Supplier update Route
    Route::put('/customers/update/{id}', [CustomerController::class, 'update'])->name('customers.update');
    // Supplier delete Route
    Route::delete('/customers/delete/{id}', [CustomerController::class, 'destroy'])->name('customers.destroy');


// ALL RECEIVING HEADER TRANSACTION ROUTE  

    Route::get('/receiving/header/datatables', [ReceivingController::class, 'GetDatatableHeader'])->name('receiving.header.datatable');
    // Receiving Header page Route
    Route::get('/receiving/header', [ReceivingController::class, 'index'])->name('receiving.header');
    // Receiving Header add Route
    Route::post('/receiving/header', [ReceivingController::class, 'storeHeader'])->name('receiving.header.storeHeader');
    // Receiving Header edit Route
    Route::get('/receiving/header/{id}', [ReceivingController::class, 'editHeader'])->name('receiving.header.editHeader');
    // Receiving Header update Route
    Route::put('/receiving/header/{id}', [ReceivingController::class, 'updateHeader'])->name('receiving.header.updateHeader');
    // Receiving Header delete Route
    Route::delete('/receiving/header/{id}', [ReceivingController::class, 'destroyHeader'])->name('receiving.header.destroyHeader');

// ALL RECEIVING DETAIL TRANSACTION ROUTE  

    Route::get('/receiving/detail/datatables/{receiving_header_id}', [ReceivingController::class, 'getDatatableDetail'])->name('receiving.detail.datatable');
    // Receiving detail Route
    Route::get('/receiving/detail/{id}', [ReceivingController::class, 'ShowById'])->name('receiving.detail.ShowById');
    // Receiving Header add Route
    Route::post('/receiving/detail', [ReceivingController::class, 'addDetail'])->name('receiving.detail.addDetail');
    // get unit
    Route::get('/products/{id}/unit', [ProductController::class, 'getUnit'])->name('products.getUnit');
    // Receiving Header delete Route
    Route::delete('/receiving/detail/{id}', [ReceivingController::class, 'destroyDetail'])->name('receiving.detail.destroy');
    // Rute untuk mendapatkan detail receiving detail
    Route::get('/receiving/detail-modal/{id}', [ReceivingController::class, 'showDetail'])->name('receiving.detail.show');

    // Rute untuk memperbarui receiving detail
    Route::put('/receiving/detail/{id}', [ReceivingController::class, 'updateDetail'])->name('receiving.detail.update');
    // Rute untuk mengonfirmasi all receiving
    Route::put('/receiving/confirm-all/{id}', [ReceivingController::class, 'confirmAll'])->name('receiving.confirmAll');
    // Rute untuk mengonfirmasi receiving by id
    Route::put('/receiving/detail/confirm/{id}', [ReceivingController::class, 'confirmDetail'])->name('receiving.detail.confirm');


// ALL DISPATCHING HEADER TRANSACTION ROUTE  

    Route::get('/dispatching/header/datatables', [DispatchingController::class, 'GetDatatableHeader'])->name('dispatching.header.datatable');
    // Dispatching Header page Route
    Route::get('/dispatching/header', [DispatchingController::class, 'index'])->name('dispatching.header');
    // Dispatching Header add Route
    Route::post('/dispatching/header', [DispatchingController::class, 'storeHeader'])->name('dispatching.header.storeHeader');
    // Dispatching Header edit Route
    Route::get('/dispatching/header/{id}', [DispatchingController::class, 'editHeader'])->name('dispatching.header.editHeader');
    // Dispatching Header update Route
    Route::put('/dispatching/header/{id}', [DispatchingController::class, 'updateHeader'])->name('dispatching.header.updateHeader');
    // Dispatching Header delete Route
    Route::delete('/dispatching/header/{id}', [DispatchingController::class, 'destroyHeader'])->name('dispatching.header.destroyHeader');


// ALL DISPATCHING DETAIL TRANSACTION ROUTE  

    Route::get('/dispatching/detail/datatables/{dispatching_header_id}', [DispatchingController::class, 'GetDatatableDetail'])->name('dispatching.detail.datatable');
    // Dispatching detail Route
    Route::get('/dispatching/detail/{id}', [DispatchingController::class, 'ShowById'])->name('dispatching.detail.ShowById');
    // Dispatching Header add Route
    Route::post('/dispatching/detail', [DispatchingController::class, 'addDetail'])->name('dispatching.detail.addDetail');
    // get unit
    Route::get('/products/{id}/unit', [DispatchingController::class, 'getUnit'])->name('products.getUnit');
    Route::get('/products/{productId}/qty', [ProductController::class, 'getProductQty']);
    // Dispatching Header delete Route
    Route::delete('/dispatching/detail/{id}', [DispatchingController::class, 'destroyDetail'])->name('dispatching.detail.destroy');
    // Rute untuk mendapatkan detail Dispatching detail
    Route::get('/dispatching/detail-modal/{id}', [DispatchingController::class, 'showDetail'])->name('dispatching.detail.show');
    // Rute untuk memperbarui Dispatching detail
    Route::put('/dispatching/detail/{id}', [DispatchingController::class, 'updateDetail'])->name('dispatching.detail.update');
    // Rute untuk mengonfirmasi all Dispatching
    Route::put('/dispatching/confirm-all/{id}', [DispatchingController::class, 'confirmAll'])->name('dispatching.confirmAll');
    // Rute untuk mengonfirmasi Dispatching by id
    Route::put('/dispatching/detail/confirm/{id}', [DispatchingController::class, 'confirmDetail'])->name('dispatching.detail.confirm');
    // Rute untuk mencetak faktur Dispatching
    Route::get('/dispatching/invoice/{id}', [DispatchingController::class, 'printInvoice'])->name('dispatching.invoice');
    // Rute untuk mencetak nota pengiriman Dispatching
    Route::get('/dispatching/delivery-note/{id}', [DispatchingController::class, 'printDeliveryNote'])->name('dispatching.deliveryNote');



//ALL REPORT ROUTE

    //Report Archive
    Route::get('/archive', [ReportController::class, 'archive'])->name('reports.archive');
    

    // Report add Route
    Route::post('/reports/stock', [ReportController::class, 'store'])->name('reports.store');
    // Report detail Route
    Route::get('/reports/show/{id}', [ReportController::class, 'show'])->name('reports.show');
    // Report edit Route
    Route::put('/reports/update/{id}', [ReportController::class, 'update'])->name('reports.update');
    // Report delete Route
    Route::delete('/reports/delete/{id}', [ReportController::class, 'destroy'])->name('reports.destroy');

    
    //Stock Report
    Route::get('/reports/stock/datatables', [ReportController::class, 'getStockDatatable'])->name('reports.stock.datatable');
    Route::get('/reports/stock', [ReportController::class, 'stockReports'])->name('reports.stock');
    //DOMpdf generate stock report
    Route::get('/reports/stock/generate', [ReportController::class, 'generateStockReport'])->name('reports.stockGenerate');

    //Stock Movement Report Route
    Route::get('/reports/stock-movement', [ReportController::class, 'stockMovementReports'])->name('reports.stockMovement');
    //DOMpdf generate stock movement report
    Route::post('/reports/stock-movement/generate', [ReportController::class, 'generateStockMovementReport'])->name('reports.stockMovement.generate');
    
    //Stock minimum Report Route
    Route::get('/reports/minimum-stock', [ReportController::class, 'minimumStockReport'])->name('reports.minimumStock');
    //DOMpdf generate stock minimum report
    Route::post('/reports/minimum-stock/generate', [ReportController::class, 'generateMinimumStockReport'])->name('reports.minimumStock.generate');

    //Receiving Report Route
    Route::get('/reports/receiving', [ReportController::class, 'receivingReport'])->name('reports.receiving');
    //DOMpdf generate Receiving report
    Route::post('/reports/receiving/generate', [ReportController::class, 'generateReceivingReport'])->name('reports.receiving.generate');

    //Dispatching Report Route
    Route::get('/reports/dispatching', [ReportController::class, 'dispatchingReport'])->name('reports.dispatching');
    //DOMpdf generate Dispatching report
    Route::post('/reports/dispatching/generate', [ReportController::class, 'generateDispatchingReport'])->name('reports.dispatching.generate');

    //Stock adjustment Report Route
    Route::get('/reports/stock-adjustment', [ReportController::class, 'stockAdjustmentReport'])->name('reports.stockAdjustment');
    //DOMpdf generate stock adjustment report
    Route::post('/reports/stock-adjustment/generate', [ReportController::class, 'generateStockAdjustmentReport'])->name('reports.stockAdjustment.generate');


});


  
