<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class NotaSeeder extends Seeder
{
    public function run(): void
    {
        // safe to pluck: karyawans likely small, barangs ~2000 (OK)
        $karyawanIds = DB::table('karyawans')->pluck('id')->toArray();

        if (empty($karyawanIds)) {
            $this->command->error('karyawans table is empty. Seed them first.');
            return;
        }

        // build a map of barang_id => harga so we can set harga_jual on each line
        $hargaMap = DB::table('barangs')->pluck('harga', 'id')->toArray(); // [id => harga]

        if (empty($hargaMap)) {
            $this->command->error('barangs table is empty. Seed barangs first.');
            return;
        }

        $barangIds = array_keys($hargaMap); // safe small array of ids
        $status = [1, 2, 3, 4, 5];

        // how many notas to create
        $notaCount = 5;

        for ($i = 1; $i <= $notaCount; $i++) {
            // build nota data
            $dataku = [
                'tanggal'     => now()->format('Y-m-d'),
                'status'      => $status[array_rand($status)],
                'karyawan_id' => $karyawanIds[array_rand($karyawanIds)],
                // pick a random pelanggan id directly from DB (memory-safe)
                'pelanggan_id'=> DB::table('pelanggans')->inRandomOrder()->value('id'),
                'created_at'  => now(),
                'updated_at'  => now(),
            ];

            if (!$dataku['pelanggan_id']) {
                $this->command->error('No pelanggan found. Seed pelanggans first.');
                return;
            }

            // insert nota and get id
            $notaId = DB::table('notas')->insertGetId($dataku);

            // build barang_nota lines (1..10)
            $barangNota = [];
            $lines = rand(1, 10);
            for ($j = 1; $j <= $lines; $j++) {
                $barangId = $barangIds[array_rand($barangIds)];
                $harga_jual = $hargaMap[$barangId] ?? 0;

                $barangNota[] = [
                    'barang_id'  => $barangId,
                    'nota_id'    => $notaId,
                    'qty'        => rand(1, 50),
                    'harga_jual' => $harga_jual,           // << required field included
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }

            // insert lines
            DB::table('barang_nota')->insert($barangNota);

            $this->command->info("Created nota {$notaId} with {$lines} items.");
        }

        $this->command->info('NotaSeeder finished.');
    }
}
