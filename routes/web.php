<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\ObatController;
use App\Http\Controllers\PenjualanController;
use App\Http\Controllers\PrediksiController;
use App\Http\Controllers\LaporanController;
use Illuminate\Support\Facades\Route;

// Route untuk Authentication
Route::get('/', [LoginController::class, 'index'])->name('home');
Route::post('authentication', [LoginController::class, 'auth'])->name('auth');
Route::get('logout', [LoginController::class, 'logout'])->name('logout');

// Routes yang perlu authentication
Route::middleware(['auth'])->group(function () {
    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    
    // Data Obat 
    Route::resource('medicine', ObatController::class);
    Route::post('/medicine/import', [ObatController::class, 'import'])->name('import-medicine');
    
    // Data Penjualan
    Route::resource('sales', PenjualanController::class); // Route untuk penjualan (sales.index)
    Route::post('/sales/import', [PenjualanController::class, 'import'])->name('sales.import'); // Tambahkan route ini
    
    // Prediksi
    Route::get('/train-data', [PrediksiController::class, 'index'])->name('train.index');
    Route::get('/predict', [PrediksiController::class, 'showPrediction'])->name('predict.index');
    Route::post('/predict', [PrediksiController::class, 'predict'])->name('predict.store');
    Route::get('/prediksi/download/{type}', [PrediksiController::class, 'downloadPDF'])->name('prediksi.download');
    // Laporan
    // Route::get('/laporan/stok', [LaporanController::class, 'stokObat'])->name('laporan.stok');
    Route::get('/laporan/penjualan', [LaporanController::class, 'penjualanPermintaan'])->name('laporan.penjualan');
});
