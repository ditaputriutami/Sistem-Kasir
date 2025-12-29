<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\BarangController;
use App\Http\Controllers\PemasokController;
use App\Http\Controllers\BeliController;
use App\Http\Controllers\LaporanController;

// Authentication Routes
Route::get('/login', [AuthController::class, 'showLogin'])->name('login')->middleware('guest');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Protected Routes
Route::middleware(['auth'])->group(function () {
    // Dashboard
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

    // Barang (CRUD)
    Route::resource('barang', BarangController::class);

    // Pemasok (CRUD)
    Route::resource('pemasok', PemasokController::class);

    // Transaksi Pembelian (CRUD)
    Route::resource('beli', BeliController::class);

    // Laporan
    Route::get('laporan/pembelian', [LaporanController::class, 'pembelian'])->name('laporan.pembelian');
    Route::get('laporan/cetak-pembelian', [LaporanController::class, 'cetakPembelian'])->name('laporan.cetak-pembelian');
});
