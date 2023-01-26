<?php

use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\ConversionController;
use App\Http\Controllers\API\DetailGoodsReceiveController;
use App\Http\Controllers\API\DetailSalesController;
use App\Http\Controllers\API\GoodsReceiveController;
use App\Http\Controllers\API\ProductMasterController;
use App\Http\Controllers\API\ReturnSalesController;
use App\Http\Controllers\API\SalesController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::get('/sync-product-master', [ProductMasterController::class, 'syncProductMaster']);


Route::group(['middleware' => ['auth:sanctum']], function(){
    Route::get('/profile', [AuthController::class, 'profile']);
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/get-product-master', [ProductMasterController::class, 'index']);
    
    Route::apiResource('conversion', ConversionController::class);
    
    Route::post('goods-receive/{id}/update', [GoodsReceiveController::class, 'update_status']);
    Route::apiResource('goods-receive', GoodsReceiveController::class);
    Route::apiResource('detail-goods-receive', DetailGoodsReceiveController::class);
    
    Route::post('sales/{id}/update', [SalesController::class, 'update_status']);
    Route::apiResource('sales', SalesController::class);
    Route::apiResource('detail-sales', DetailSalesController::class);
    
    Route::apiResource('return-sales', ReturnSalesController::class);
});
