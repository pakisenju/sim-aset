<?php

use App\Http\Controllers\AssetController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PagesController;
use App\Http\Controllers\RestockRequestController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::middleware('guest')->group(function () {
    Route::get('/login', [PagesController::class, 'loginPage'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('doLogin');
});

Route::middleware('auth')->group(function () {
    // pages
    Route::get('/', [PagesController::class, 'dashboardPage'])->name('dashboard');
    Route::get('/report', [PagesController::class, 'reportPage'])->name('report');
    Route::get('/request', [PagesController::class, 'requestPage'])->name('request');
    Route::get('/asset', [PagesController::class, 'assetPage'])->name('asset');
    Route::get('/detail-asset/{id}', [PagesController::class, 'detailAssetPage'])->name('detail.asset');
    Route::get('/supplier', [PagesController::class, 'supplierPage'])->name('supplier');

    // data
    Route::get('/show-asset/{id}', [AssetController::class, 'show'])->name('asset.show');
    Route::get('/show-supplier/{id}', [UserController::class, 'show'])->name('supplier.show');

    // actions
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    Route::post('/create-asset', [AssetController::class, 'store'])->name('asset.store');
    Route::put('/update-asset/{id}', [AssetController::class, 'update'])->name('asset.update');
    Route::put('/restock-asset/{id}', [AssetController::class, 'restock'])->name('asset.restock');
    Route::put('/deplete-asset/{id}', [AssetController::class, 'deplete'])->name('asset.deplete');
    Route::post('/destroy-asset/{id}', [AssetController::class, 'destroy'])->name('asset.destroy');
    Route::post('/create-supplier', [UserController::class, 'supplierStore'])->name('supplier.store');
    Route::put('/update-supplier/{id}', [UserController::class, 'supplierUpdate'])->name('supplier.update');
    Route::post('/destroy-supplier/{id}', [UserController::class, 'supplierDestroy'])->name('supplier.destroy');
    Route::post('/request-restock/{id}', [RestockRequestController::class, 'store'])->name('request.store');
    Route::post('/request-accept/{id}', [RestockRequestController::class, 'accept'])->name('request.accept');
    Route::post('/request-reject/{id}', [RestockRequestController::class, 'reject'])->name('request.reject');
});
