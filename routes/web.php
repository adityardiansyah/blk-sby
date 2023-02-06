<?php

use App\Http\Controllers\ColorController;
use App\Http\Controllers\SellerController;
use App\Http\Controllers\SizeController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;


Route::get('/', function () {
    return view('home');
});

Auth::routes();

Route::get('size', [SizeController::class, 'index'])->name('master.size');
Route::get('color', [ColorController::class, 'index'])->name('master.color');
Route::get('users', [UserController::class, 'index'])->name('users.index');
Route::get('seller', [SellerController::class, 'index'])->name('seller.index');