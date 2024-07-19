<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Ahp;
use App\Models\Data\JenisEvaluasi;

class AhpSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $jenisEvaluasiList = JenisEvaluasi::all();

        foreach ($jenisEvaluasiList as $jenisEvaluasiKiri) {
            foreach ($jenisEvaluasiList as $jenisEvaluasiAtas) {
                Ahp::create([
                    'kiri_jenis_evaluasi_id' => $jenisEvaluasiKiri->id,
                    'atas_jenis_evaluasi_id' => $jenisEvaluasiAtas->id,
                ]);
            }
        }
    }
}
