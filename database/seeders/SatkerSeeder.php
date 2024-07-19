<?php

namespace Database\Seeders;

use App\Models\Data\Satker;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use function Laravel\Prompts\confirm;

class SatkerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $confirm = confirm('Truncate Satker ?', true);

        Satker::truncate($confirm);

        $this->satker();
    }

    public function satker()
    {
        $data = [
            [
                'kode_satker' => '1',
                'nama_satker' => 'Dinas Kesehatan',
            ],
            [
                'kode_satker' => '2',
                'nama_satker' => 'Dinas Komunikasi dan Informatika',
            ],
            [
                'kode_satker' => '3',
                'nama_satker' => 'Dinas Peternakan dan Kesehatan Hewan',
            ],

            [
                'kode_satker' => '4',
                'nama_satker' => 'Dinas Pendidikan',
            ],
            [
                'kode_satker' => '5',
                'nama_satker' => 'Satker 5',
            ],
        ];

        foreach($data as $item)
        {
            Satker::firstOrCreate($item);
        }
    }
}
