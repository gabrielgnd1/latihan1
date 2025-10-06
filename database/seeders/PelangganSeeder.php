<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use Illuminate\Support\Facades\DB;

class PelangganSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $sex = ['pria','wanita'];
        $dataku = array();  
        for($i=1;$i<=50000;$i++){
            $dataku[]=[
                'nama' => fake()->name(),
                'kota' => fake()->city(),
                'sex' => $sex[rand(0,1)],
                'no_telp' => '08'.rand(1,5).rand(1,5).rand(1000000,9999999),

                
            ];
             DB::table('pelanggans')->insert($dataku);
        }

       

        
    }
}
