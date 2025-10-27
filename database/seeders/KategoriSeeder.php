<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class KategoriSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'nama' => 'Snack',
                'deskripsi' => 'Makanan ringan dan camilan'
            ],
            [
                'nama' => 'Penyetan',
                'deskripsi' => 'Aneka lauk dengan sambal'
            ],
            [
                'nama' => 'Jus',
                'deskripsi' => 'Minuman segar dari buah-buahan'
            ],
            [
                'nama' => 'Minuman',
                'deskripsi' => 'Aneka minuman non-jus'
            ],
        ];

        DB::table('kategoris')->insert($data);
    }
}
