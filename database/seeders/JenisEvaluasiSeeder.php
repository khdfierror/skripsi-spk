<?php

namespace Database\Seeders;

use App\Models\Data\JenisEvaluasi;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use function Laravel\Prompts\confirm;

class JenisEvaluasiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // $confirm = confirm('Truncate Jenis Evaluasi ?');

        // JenisEvaluasi::truncate($confirm);

        $this->jenis_evaluasi();
    }

    public function jenis_evaluasi()
    {
        $item = [
            [
                'no' => 1,
                'nama_jenis' => 'Evaluasi Administrasi',
            ],
            [
                'no' => 2,
                'nama_jenis' => 'Evaluasi Kualifikasi',
            ],
            [
                'no' => 3,
                'nama_jenis' => 'Evaluasi Teknis',
            ],
            [
                'no' => 4,
                'nama_jenis' => 'Evaluasi Harga',
            ],
        ];

        foreach($item as $value)
        {
            JenisEvaluasi::firstOrCreate($value);
        }
    }
}
