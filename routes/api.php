<?php

use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\ConversionController;
use App\Http\Controllers\API\DetailGoodsReceiveController;
use App\Http\Controllers\API\DetailReturnWarehouseController;
use App\Http\Controllers\API\DetailSalesController;
use App\Http\Controllers\API\DetailStockOpnameController;
use App\Http\Controllers\API\GoodsReceiveController;
use App\Http\Controllers\API\PresenceController;
use App\Http\Controllers\API\ProductMasterController;
use App\Http\Controllers\API\ReturnSalesController;
use App\Http\Controllers\API\ReturnWarehouseController;
use App\Http\Controllers\API\SalesController;
use App\Http\Controllers\API\StockOpnameController;
use App\Http\Controllers\ReportController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::get('/sync-product-master', [ProductMasterController::class, 'syncProductMaster']);


Route::group(['middleware' => ['auth:sanctum']], function(){
    Route::get('laporan-excel/{type}', [ReportController::class, 'download_excel'])->name('laporan.excel');

    Route::get('/profile', [AuthController::class, 'profile']);
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/get-product-master', [ProductMasterController::class, 'index']);
    Route::get('/get-color', [ProductMasterController::class, 'get_color']);
    Route::get('/get-sizes', [ProductMasterController::class, 'get_sizes']);
    
    Route::apiResource('conversion', ConversionController::class);
    
    Route::post('goods-receive/{id}/update', [GoodsReceiveController::class, 'update_status']);
    Route::post('goods-receive/upload-attachment', [GoodsReceiveController::class, 'upload_attachment']);
    Route::delete('goods-receive/delete-file/{id}', [GoodsReceiveController::class, 'delete_file']);
    Route::apiResource('goods-receive', GoodsReceiveController::class);
    Route::apiResource('detail-goods-receive', DetailGoodsReceiveController::class);
    
    Route::post('sales/{id}/update', [SalesController::class, 'update_status']);
    Route::apiResource('sales', SalesController::class);
    Route::apiResource('detail-sales', DetailSalesController::class);
    
    Route::apiResource('return-sales', ReturnSalesController::class);
    
    Route::post('return-warehouse/{id}/update', [ReturnWarehouseController::class, 'update_status']);
    Route::apiResource('return-warehouse', ReturnWarehouseController::class);
    Route::apiResource('detail-return-warehouse', DetailReturnWarehouseController::class);
    
    Route::post('stock-opname/{id}/update', [StockOpnameController::class, 'update_status']);
    Route::apiResource('stock-opname', StockOpnameController::class);
    Route::apiResource('detail-stock-opname', DetailStockOpnameController::class);
    
    Route::apiResource('presence', PresenceController::class);
});
