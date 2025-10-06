<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use Illuminate\Http\Request;

class BarangController extends Controller
{
    public function tampilBarang() {
        //Barang ini adalah model Barang
        //meskipun di dalam model Barang tidak ada isi & function sama sekali, tapi karena dia extends Model maka tetap bisa dipanggil
        //limit(50) berarti cuman ambil 50 data teratas 
        //with('kategori') supaya include juga relationshipnya sama kategori
        $barang = Barang::with('kategori')->limit(50)->get();

        //kirim isi barang ke view
        //'daftar' adalah nama variabel untuk menampung isi kategori di daftarBarang.blade.php
        return view('daftarBarang', ['daftar' => $barang]);
    }
}