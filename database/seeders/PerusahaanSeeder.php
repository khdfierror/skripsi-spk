<?php

namespace Database\Seeders;

use App\Models\Data\Perusahaan;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use function Laravel\Prompts\confirm;

class PerusahaanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // $confirm = confirm('Truncate Perusahaan ? ');
        // Perusahaan::truncate($confirm);

        $this->data();
    }

    public function data()
    {
        $perusahaan = [
            [
                'npwp' => '86.839.413.1-722.000',
                'nama_perusahaan' => 'CV. Sumber Lumintu',
                'nama_pimpinan' => 'Arif Setiawan',
                'jabatan' => 'Direktur',
                'alamat' => 'Jalan PM. Noor Perum Griya Mukti Blok, R No. 30 Samarinda',
            ],
            [
                'npwp' => '02.673.739.5-727.000',
                'nama_perusahaan' => 'CV. Lestari Batu Putih',
                'nama_pimpinan' => 'Rositah',
                'jabatan' => 'Direktur',
                'alamat' => 'Tanjung Redep Berau',
            ],
            [
                'npwp' => '03.039.545.3-727.000',
                'nama_perusahaan' => 'CV. Taufik Karya Mandiri',
                'nama_pimpinan' => 'Rusiansyah',
                'jabatan' => 'Direktur',
                'alamat' => 'Tanjung Redep Berau',
            ],
            [
                'npwp' => '72.599.783.7-722.000',
                'nama_perusahaan' => 'CV. Aroz Borneo Persadah',
                'nama_pimpinan' => 'Fahrurozi',
                'jabatan' => 'Direktur',
                'alamat' => 'Samarinda',
            ],
        ];

        foreach($perusahaan as $item)
        {
            Perusahaan::firstOrCreate($item);
        }
    }
}
