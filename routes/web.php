<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DepanController;
use App\Http\Controllers\UtamaController;
use App\Http\Controllers\BarangController;



Route::get('/',)

Route::get('/', function () {
    //return view('welcome');
    return "Selamat datang di rumah kami";
});

Route::get('/ini-url-daniel/{lastName?}', function($lastName='Soesanto') {
    return "Nah ini baru URL asli milik Daniel ".$lastName;
});

Route::get('/ini-lebih-cantik/{lanjutan?}', function($lanjutan = 'daripada pacarmu') {
    return view('cantik', ['data' => $lanjutan]);
});

Route::get('/ini-super-cantik/{lanjutan?}', [DepanController::class, 'superCantik']);

Route::get('/daftar-kategori', [UtamaController::class, 'tampilKategori']);

Route::get('/daftar-barang', [BarangController::class, 'index']);