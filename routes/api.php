<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BarangController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\JasaController;
use App\Http\Controllers\PenjualanController;
use App\Http\Controllers\ProdukController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::prefix('barang')->group(function () {
    Route::get('/', [BarangController::class, 'index']); // OK
});

Route::prefix('jasa')->group(function () {
    Route::get('/', [JasaController::class, 'index']); // OK
});

Route::prefix('invoice')->group(function () {
    Route::get('/', [InvoiceController::class, 'index']); // OK
});

Route::prefix('penjualan')->group(function () {
    Route::get('/', [PenjualanController::class, 'index']); // OK
    Route::post('/', [PenjualanController::class, 'store']); // OK
    Route::put('/{idPenjualan}', [PenjualanController::class, 'updateStatus']); // OK
    Route::delete('/{idPenjualan}', [PenjualanController::class, 'destroy']); // OK
});

Route::prefix('produk')->group(function () {
    Route::get('/', [ProdukController::class, 'index']); // OK
    Route::post('/', [ProdukController::class, 'store']); // OK
    Route::put('/{idProduk}', [ProdukController::class, 'update']); // OK
    Route::delete('/{idProduk}', [ProdukController::class, 'destroy']); //OK
});
