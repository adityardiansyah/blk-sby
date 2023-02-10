<?php

use App\Http\Controllers\ColorController;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\SellerController;
use App\Http\Controllers\ShopController;
use App\Http\Controllers\SizeController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\URL;

Auth::routes();

// URL::forceScheme('https');
Route::middleware(['auth'])->group(function () {
    Route::get('/', function () {
        Session::put('menu_active','dashboard');
        return view('home');
    });
    Route::get('shop', [ShopController::class, 'index'])->name('shop.index');
    Route::get('size', [SizeController::class, 'index'])->name('master.size');
    Route::get('color', [ColorController::class, 'index'])->name('master.color');
    Route::get('users', [UserController::class, 'index'])->name('users.index');
    Route::get('seller', [SellerController::class, 'index'])->name('seller.index');
    Route::post('seller', [SellerController::class, 'store'])->name('seller.store');
    Route::get('laporan', [ReportController::class, 'index'])->name('laporan.index');
    Route::get('laporan/{date_start}/{date_end}/{shop_id}', [ReportController::class, 'laporan_stock'])->name('laporan.stock');
    Route::get('laporan-excel/{type}/{date_start}/{date_end}/{shop_id}', [ReportController::class, 'download_excel'])->name('laporan.excel');
    Route::get('test', function(){
        return view('exports.stock');
    });
});

