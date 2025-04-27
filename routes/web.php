<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\UnitController;
use App\Http\Controllers\SupplierController;

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

    
    
});
  
/*------------------------------------------
--------------------------------------------
All Admin Routes List
--------------------------------------------
--------------------------------------------*/
Route::middleware(['auth', 'user-access:admin'])->group(function () {
  
    // Admin dashboard Route
    Route::get('/admin/dashboard', [HomeController::class, 'adminDashboard'])->name('admin.dashboard');


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
});


  
