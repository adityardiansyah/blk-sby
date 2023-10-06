<?php

use App\Http\Controllers\API\ReturnSalesController;
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
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ReturnSalesController as ControllersReturnSalesController;
use App\Http\Controllers\ReturnWarehouseController;
use App\Http\Controllers\StockOpnameController;
use App\Http\Controllers\AdjusmentController;
use App\Http\Controllers\SectionController;
use App\Http\Controllers\GroupController;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;

Route::get('login', [LoginController::class, 'login']);
Route::post('login', [LoginController::class, 'check_login'])->name('login'); 
Route::post('logout', [LoginController::class, 'logout'])->name('logout'); 

Route::get('/icons', function () {
    $iconPath = public_path('assets/extensions/@icon/dripicons/icons');
    $icons = File::allFiles($iconPath);

    return view('page.icon', compact('icons'));
});

Route::get('/section', [SectionController::class, 'index']);

// URL::forceScheme('https');
Route::middleware(['auth'])->group(function () {
    Route::get('/create-section', [SectionController::class, 'section']);
    Route::get('/',[HomeController::class, 'index'])->name('home.index');
    Route::get('shop', [ShopController::class, 'index'])->name('shop.index');
    Route::post('shop', [ShopController::class, 'store'])->name('master.shop.store');
    Route::get('shop/api', [ShopController::class, 'shop_api'])->name('shop.api');
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
    Route::get('users/{id}', [UserController::class, 'show'])->name('users.show');
    Route::post('users', [UserController::class, 'store'])->name('users.store');
    Route::post('users/update/{id}', [UserController::class, 'update'])->name('users.update');
    Route::get('seller', [SellerController::class, 'index'])->name('seller.index');
    Route::get('seller/{id}', [SellerController::class, 'show'])->name('seller.show');
    Route::post('seller', [SellerController::class, 'store'])->name('seller.store');
    Route::post('seller/update/{id}', [SellerController::class, 'update'])->name('seller.update');

    Route::get('sales', [SalesController::class, 'index'])->name('sales.index');
    Route::get('sales/{id}', [SalesController::class, 'show'])->name('sales.show'); 
    Route::put('sales/{id}', [SalesController::class, ''])->name('sales.show');
    Route::post('/sales/{id}/update',[SalesController::class,'update_status']);
    Route::get('returnsales', [ControllersReturnSalesController::class, 'index'])->name('returnsales.index');
    Route::get('conversion', [ConversionController::class, 'index'])->name('conversion.index');
    Route::get('conversion/api/{shop_id}', [ConversionController::class, 'api'])->name('conversion.api');
    Route::get('laporan', [ReportController::class, 'index'])->name('laporan.index');
    Route::delete('color/{id}', [ColorController::class, 'destroy']);
    Route::delete('sku/{id}', [SKUController::class, 'destroy']);
    Route::get('sku/edit/{id}', [SKUController::class, 'edit']);
    Route::put('/sku/update', [SKUController::class, 'update'])->name('master.sku.update');
    Route::get('goodsreceive', [GoodsReceiveController::class, 'index'])->name('goodsreceive.index');
    Route::get('goodsreceive/{id}', [GoodsReceiveController::class, 'show'])->name('goodsreceive.show');
    Route::post('goodsreceive/{id}/confirm', [GoodsReceiveController::class, 'confirm'])->name('goodsreceive.confirm');
    Route::get('returnwarehouse', [ReturnWarehouseController::class, 'index'])->name('returnwarehouse.index');
    Route::get('returnwarehouse/{id}', [ReturnWarehouseController::class, 'show'])->name('returnwarehouse.show');
    Route::post('returnwarehouse/{id}/confirm', [ReturnWarehouseController::class, 'confirm'])->name('returnwarehouse.confirm');
    Route::get('stockopname', [StockOpnameController::class, 'index'])->name('stockopname.index');
    Route::get('stockopname/{id}', [StockOpnameController::class, 'show'])->name('stockopname.show');
    Route::post('stockopname/{id}/confirm', [StockOpnameController::class, 'confirm'])->name('stockopname.confirm');
    Route::get('laporan/{date_start}/{date_end}/{shop_id}', [ReportController::class, 'laporan_stock'])->name('laporan.stock');
    Route::get('laporan-excel/{type}/{date_start}/{date_end}/{shop_id}', [ReportController::class, 'download_excel'])->name('laporan.excel');
    Route::get('adjusment/detail/{id}', [AdjusmentController::class, 'detail_adjusment'])->name('adjusment.edit');
    Route::get('adjusment/in', [AdjusmentController::class, 'adjusment_in'])->name('adjusment.in');
    Route::get('adjusment/out', [AdjusmentController::class, 'adjusment_out'])->name('adjusment.out');
    Route::post('adjusment/store', [AdjusmentController::class, 'store'])->name('adjusment.store');
    Route::post('adjusment/update/{id}', [AdjusmentController::class, 'update'])->name('adjusment.update');
    Route::delete('adjusment/delete/{id}', [AdjusmentController::class, 'delete'])->name('adjusment.delete');
    Route::post('adjusment/confirm/{id}', [AdjusmentController::class, 'confirm'])->name('adjusment.confirm');
    Route::get('group', [GroupController::class, 'index']);
    Route::get('group/detail/{id}', [GroupController::class, 'api']);
    Route::post('group', [GroupController::class, 'store']);
    Route::delete('group/{id}', [GroupController::class, 'delete']);
    Route::post('group/update/{id}', [GroupController::class, 'update']);
});