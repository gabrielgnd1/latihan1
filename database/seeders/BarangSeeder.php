<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use Illuminate\Support\Facades\DB;

class BarangSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();

        for ($i = 1; $i <= 1234; $i++) {
            DB::table('barangs')->insert([
                'nama' => $faker->word(),
                'harga' => $faker->numberBetween(10000, 100000),
                'stok' => $faker->numberBetween(1, 50),
                'deskripsi' => $faker->sentence(10),
                'kategori_id' => $faker->numberBetween(1, 4),
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            
        }
    }
}
