<?php

use App\Http\Controllers\BarangController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\PenjualanController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\InfoUserController;
use App\Http\Controllers\JasaController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\SessionsController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


Route::group(['middleware' => 'auth'], function () {

	Route::get('/', [HomeController::class, 'home']);
	Route::get('dashboard', function () {
		return view('dashboard');
	})->name('dashboard');

	Route::get('billing', function () {
		return view('billing');
	})->name('billing');

	Route::get('profile', function () {
		return view('profile');
	})->name('profile');

	Route::get('rtl', function () {
		return view('rtl');
	})->name('rtl');

	Route::get('user-management', function () {
		return view('laravel-examples/user-management');
	})->name('user-management');




	Route::get('tables', function () {
		return view('tables');
	})->name('tables');

	Route::get('virtual-reality', function () {
		return view('virtual-reality');
	})->name('virtual-reality');

	Route::get('static-sign-in', function () {
		return view('static-sign-in');
	})->name('sign-in');

	Route::get('static-sign-up', function () {
		return view('static-sign-up');
	})->name('sign-up');

	Route::get('/logout', [SessionsController::class, 'destroy']);
	Route::get('/login', function () {
		return view('dashboard');
	})->name('sign-up');


	// New Route
	Route::get('barang', [BarangController::class, 'indexWeb'])->name('barang.indexWeb');
	Route::get('jasa', [JasaController::class, 'indexWeb'])->name('jasa.indexWeb');

	Route::prefix('penjualan')->group(function () {
		Route::get('/', [PenjualanController::class, 'index'])->name('penjualan.index');
		Route::post('/store', [PenjualanController::class, 'store'])->name('penjualan.store');
		Route::put('/{idPenjualan}/update-status', [PenjualanController::class, 'updateStatus'])->name('penjualan.updateStatus');
		Route::delete('/{idPenjualan}', [PenjualanController::class, 'destroy'])->name('penjualan.destroy');
	});

	Route::get('invoice', [InvoiceController::class, 'index'])->name('invoice');
	Route::get('riwayat', [InvoiceController::class, 'indexRiwayat'])->name('riwayat');
});

Route::group(['middleware' => 'guest'], function () {
	Route::get('/register', [RegisterController::class, 'create']);
	Route::post('/register', [RegisterController::class, 'store']);
	Route::get('/login', [SessionsController::class, 'create']);
	Route::post('/session', [SessionsController::class, 'store']);
});

Route::get('/login', function () {
	return view('session/login-session');
})->name('login');


// Barang Route
Route::post('/barang/store', [BarangController::class, 'store'])->name('barang.store');
Route::delete('/barang/{idBarang}', [BarangController::class, 'destroy'])->name('barang.delete');
Route::put('/barang/{idBarang}/update', [BarangController::class, 'update'])->name('barang.update');

// Jasa Route
Route::post('/jasa/store', [JasaController::class, 'store'])->name('jasa.store');
Route::delete('/jasa/{idJasa}', [JasaController::class, 'destroy'])->name('jasa.delete');
Route::put('/jasa/{idJasa}/update', [JasaController::class, 'update'])->name('jasa.update');


Route::get('/laporan/pendapatan/cetak', [\App\Http\Controllers\LaporanController::class, 'cetakPendapatan'])
    ->name('laporan.pendapatan.cetak');
