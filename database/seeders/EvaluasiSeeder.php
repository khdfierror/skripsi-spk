<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Data\Evaluasi;
use App\Models\Data\JenisEvaluasi;

class EvaluasiSeeder extends Seeder
{
    public function run()
    {
        // Bersihkan tabel evaluasi
        Evaluasi::truncate();

        $data = [
            'Evaluasi Administrasi' => [
                'Surat Penawaran',
                'Jaminan Penawaran',
                'Surat Perjanjian Kerjasama Operasi (KSO)',
                'Dokumen Penawaran Teknis',
                'Dokumen Penawaran Harga',
            ],
            'Evaluasi Kualifikasi' => [
                'IUJK',
                'NIB',
                'SBU',
                'NPWP',
                'KSWP',
                'Akta Perusahaan',
                '1 (Satu) Pengalaman dalam 4 Tahun terakhir',
                'Memenuhi SKP',
            ],
            'Evaluasi Teknis' => [
                'Daftar Peralatan Utama',
                'Daftar Personil Manajerial',
                'Rencana Keselamatan Konstruksi',
                'Metode Pelaksanaan',
            ],
            'Evaluasi Harga' => [
                'Harga dibawah 80% dari HPS',
                'Harga koreksi Artimatik'
            ],
        ];

        foreach ($data as $jenisNama => $evaluasiItems) {
            $jenisEvaluasi = JenisEvaluasi::where('nama_jenis', $jenisNama)->first();

            if ($jenisEvaluasi) {
                foreach ($evaluasiItems as $index => $uraian) {
                    Evaluasi::create([
                        'jenis_evaluasi_id' => $jenisEvaluasi->id,
                        'uraian' => $uraian,
                        'no' => $index + 1,
                    ]);
                }
            }
        }
    }
}
