<?php

namespace Database\Seeders\Matriks;

use App\Models\Data;
use App\Models\Data\JenisEvaluasi;
use App\Models\Matriks\AlternatifKualifikasi;
use Illuminate\Database\Seeder;

class AlternatifKualifikasiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $perusahaanList = Data\Perusahaan::all();
        $jenisEvaluasi = Data\JenisEvaluasi::where('nama_jenis', 'Evaluasi Kualifikasi')->first();

        foreach ($perusahaanList as $PerusahaanKiri) {
            foreach ($perusahaanList as $PerusahaanAtas) {
                AlternatifKualifikasi::create([
                    'jenis_evaluasi_id' => $jenisEvaluasi->id,
                    'kiri_perusahaan_id' => $PerusahaanKiri->id,
                    'atas_perusahaan_id' => $PerusahaanAtas->id,
                ]);
            }
        }
    }
}
