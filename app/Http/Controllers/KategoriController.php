<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Kategori;

class KategoriController extends Controller
{
    public function index()
    {
        return view('kategori.index');
    }

    public function tampilKategori() {
        //Kategori ini adalah model Kategori
        //meskipun di dalam model Kategori tidak ada isi & function sama sekali, tapi karena dia extends Model maka tetap bisa dipanggil
        //limit untuk hanya mengambil 2 kategori teratas
        $kategori = Kategori::limit(2)->get();

        //kirim isi kategori ke view
        //'daftar' adalah nama variabel untuk menampung isi kategori di daftarKategori.blade.php
        return view('daftarKategori', ['daftar' => $kategori]);
    }
}
