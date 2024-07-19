<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use function Laravel\Prompts\confirm;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $confirm = confirm('Truncate User ?');

        User::truncate($confirm);

        User::firstOrCreate([
            'name' => 'Super Admin',
            'username' => 'superadmin',
            'email' => 'superadmin@deka.dev',
            'email_verified_at' => now(),
            'password' => bcrypt('superadmin'),
        ]);
    }
}
