<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use Illuminate\Support\Facades\DB;

class KaryawanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $sex = ['pria','wanita'];
        $jabatan = ['manager','kasir','waiters'];
        $dataku = array();
        for($i=1;$i<=50;$i++){
            $dataku = [
               'nama' =>fake()->name(),
               'sex' => $sex[rand(0,1)],
               'jabatan' => $jabatan[rand(0,2)],

            ];
            DB::table('karyawans')->insert($dataku);
        }
    }
}
