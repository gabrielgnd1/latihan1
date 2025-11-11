<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DepanController;
use App\Http\Controllers\UtamaController;
use App\Http\Controllers\BarangController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\ReportController;

Route::get('/reports', [ReportController::class, 'index'])->name('reports.index');



Route::get('/', function () {
    //return view('welcome');
    return "Selamat datang di rumah kami";
});

Route::get('/ini-url-daniel/{lastName?}', function($lastName='Soesanto') {
    return "Nah ini baru URL asli milik Daniel ".$lastName;
});

Route::get('/utama', [UtamaController::class, 'index'])->name('utama.index');

Route::get('/ini-lebih-cantik/{lanjutan?}', function($lanjutan = 'daripada pacarmu') {
    return view('cantik', ['data' => $lanjutan]);
});

Route::get('/ini-super-cantik/{lanjutan?}', [DepanController::class, 'superCantik']);

Route::get('/daftar-kategori', [UtamaController::class, 'tampilKategori']);
Route::get('/kategori', [KategoriController::class, 'index']);
Route::get('/hitung-barang/{kategori}', [UtamaController::class, 'hitungBarang']);
Route::get('/kategori-list', [UtamaController::class, 'getKategoriList']);
Route::post('/kategori-store', [UtamaController::class, 'storeKategori']);
Route::post('/kategori-delete/{id}', [UtamaController::class, 'deleteKategori']);
Route::get('/daftar-barang', [BarangController::class, 'index']);

Route::get('/adminlte4', function() {
    return view('adminlte4');
});

Route::get('/report', [ReportController::class, "reports"]);