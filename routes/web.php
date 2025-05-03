<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\UnitController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\ReceivingController;
use App\Http\Controllers\DispatchingController;


Route::get('/', function () {
    return view('welcome');
});

Auth::routes();





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

    
    
});
  
/*------------------------------------------
--------------------------------------------
All Admin Routes List
--------------------------------------------
--------------------------------------------*/
Route::middleware(['auth', 'user-access:admin'])->group(function () {
  
    // Admin dashboard Route
    Route::get('/admin/dashboard', [HomeController::class, 'adminDashboard'])->name('admin.dashboard');

    // Profile page Route
    Route::get('/admin/profile', [HomeController::class, 'AdminProfile'])->name('admin.profile.index');
    // Profile update Route
    Route::put('/admin/profile', [HomeController::class, 'AdminUpdateProfile'])->name('admin.profile.update');


// ALL PRODUCT ROUTE

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

// ALL CATEGORY ROUTE

    // Category page Route
    Route::get('/categories', [CategoryController::class, 'index'])->name('categories.index');

    // Category add Route
    Route::post('/categories', [CategoryController::class, 'store'])->name('categories.store');

    // Category detail Route
    Route::get('/categories/{id}', [CategoryController::class, 'show'])->name('categories.show');

    // Category edit Route
    Route::put('/categories/{id}', [CategoryController::class, 'update'])->name('categories.update');

    // Category delete Route
    Route::delete('/categories/{id}', [CategoryController::class, 'destroy'])->name('categories.destroy');
    
// ALL UNIT ROUTE

    // Unit page Route
    Route::get('/units', [UnitController::class, 'index'])->name('units.index');

    // Unit add Route
    Route::post('/units', [UnitController::class, 'store'])->name('units.store');

    // Unit detail Route
    Route::get('/units/{id}', [UnitController::class, 'show'])->name('units.show');

    // Unit edit Route
    Route::put('/units/{id}', [UnitController::class, 'update'])->name('units.update');

    // Unit delete Route
    Route::delete('/units/{id}', [UnitController::class, 'destroy'])->name('units.destroy');

// ALL SUPPLIER ROUTE

    // Supplier page Route
    Route::get('/suppliers', [SupplierController::class, 'index'])->name('suppliers.index');

    // Supplier add Route
    Route::post('/suppliers', [SupplierController::class, 'store'])->name('suppliers.store');

    // Supplier detail Route
    Route::get('/suppliers/{id}', [SupplierController::class, 'show'])->name('suppliers.show');

    // Supplier edit Route
    Route::put('/suppliers/{id}', [SupplierController::class, 'update'])->name('suppliers.update');

    // Supplier delete Route
    Route::delete('/suppliers/{id}', [SupplierController::class, 'destroy'])->name('suppliers.destroy');

// ALL CUSTOMER ROUTE

    // Supplier page Route
    Route::get('/customers', [CustomerController::class, 'index'])->name('customers.index');

    // Supplier add Route
    Route::post('/customers', [CustomerController::class, 'store'])->name('customers.store');

    // Supplier detail Route
    Route::get('/customers/{id}', [CustomerController::class, 'show'])->name('customers.show');

    // Supplier edit Route
    Route::put('/customers/{id}', [CustomerController::class, 'update'])->name('customers.update');

    // Supplier delete Route
    Route::delete('/customers/{id}', [CustomerController::class, 'destroy'])->name('customers.destroy');


// ALL RECEIVING HEADER TRANSACTION ROUTE  

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

    // Dispatching detail Route
    Route::get('/dispatching/detail/{id}', [DispatchingController::class, 'ShowById'])->name('dispatching.detail.ShowById');
    
    // Dispatching Header add Route
    Route::post('/dispatching/detail', [DispatchingController::class, 'addDetail'])->name('dispatching.detail.addDetail');

    // get unit
    Route::get('/products/{id}/unit', [DispatchingController::class, 'getUnit'])->name('products.getUnit');

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
});


  
