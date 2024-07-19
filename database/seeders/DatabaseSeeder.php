<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call(UsersTableSeeder::class);
        $this->call(JenisEvaluasiSeeder::class);
        $this->call(AhpSeeder::class);
        $this->call(EvaluasiSeeder::class);
        $this->call(PerusahaanSeeder::class);
        $this->call(SatkerSeeder::class);
        $this->call(Matriks\AlternatifAdministrasiSeeder::class);
        $this->call(Matriks\AlternatifKualifikasiSeeder::class);
        $this->call(Matriks\AlternatifTeknisSeeder::class);
        $this->call(Matriks\AlternatifHargaSeeder::class);
    }
}
