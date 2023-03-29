<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\ColorController;
use App\Http\Controllers\ConversionController;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\SellerController;
use App\Http\Controllers\ShopController;
use App\Http\Controllers\SizeController;
use App\Http\Controllers\SKUController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\SalesController;
use App\Http\Controllers\GoodsReceiveController;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\URL;

Route::get('login', [LoginController::class, 'login']);
Route::post('login', [LoginController::class, 'check_login'])->name('login'); 
Route::post('logout', [LoginController::class, 'logout'])->name('logout'); 

// URL::forceScheme('https');
Route::middleware(['auth'])->group(function () {
    Route::get('/', function () {
        Session::put('menu_active','dashboard');
        return view('home');
// Route::get('/sales', 'Controller@fungsi')->middleware([Auth::user()->id == 1]);

    });
    Route::get('shop', [ShopController::class, 'index'])->name('shop.index');
    Route::post('shop', [ShopController::class, 'store'])->name('master.shop.store');
    Route::get('shop/edit/{id}', [ShopController::class, 'edit']);
    Route::put('shop/update', [ShopController::class,'update'])->name('master.shop.update');
    Route::get('sku', [SKUController::class, 'index'])->name('master.sku');
    Route::get('list-sku', [SKUController::class, 'list_sku'])->name('master.list-sku');
    Route::post('sku', [SKUController::class, 'store'])->name('master.sku.store');
    Route::get('size', [SizeController::class, 'index'])->name('master.size');
    Route::post('size', [SizeController::class, 'store'])->name('master.size.store');
    Route::delete('size/{id}', [SizeController::class, 'destroy']);
    Route::get('color', [ColorController::class, 'index'])->name('master.color');
    Route::post('color', [ColorController::class, 'store'])->name('master.color.store');
    Route::get('users', [UserController::class, 'index'])->name('users.index');
    Route::get('seller', [SellerController::class, 'index'])->name('seller.index');
    Route::post('seller', [SellerController::class, 'store'])->name('seller.store');
    Route::get('sales', [SalesController::class, 'index'])->name('sales.index');
    Route::get('sales/{id}', [SalesController::class, 'show'])->name('sales.show');
    Route::get('conversion', [ConversionController::class, 'index'])->name('conversion.index');
    Route::get('laporan', [ReportController::class, 'index'])->name('laporan.index');
    Route::delete('color/{id}', [ColorController::class, 'destroy']);
    Route::delete('sku/{id}', [SKUController::class, 'destroy']);
    Route::get('sku/edit/{id}', [SKUController::class, 'edit']);
    Route::put('/sku/update/{id}', [SKUController::class, 'update'])->name('master.sku.update');
    Route::get('goodsreceive', [GoodsReceiveController::class, 'index'])->name('goodsreceive.index');
    Route::get('goodsreceive/{id}', [GoodsReceiveController::class, 'show'])->name('goodsreceive.show');
    Route::get('laporan/{date_start}/{date_end}/{shop_id}', [ReportController::class, 'laporan_stock'])->name('laporan.stock');
    Route::get('laporan-excel/{type}/{date_start}/{date_end}/{shop_id}', [ReportController::class, 'download_excel'])->name('laporan.excel');
});