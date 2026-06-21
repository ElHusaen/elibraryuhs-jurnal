<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::create([
            'nama' => 'Adi Fahrulloh',
            'email' => 'adi@gmail.com',
            'role' => 'admin',
            'password' => Hash::make('123'),
        ]);

        User::create([
            'nama' => 'Rival',
            'email' => 'rival@gmail.com',
            'role' => 'mahasiswa',
            'password' => Hash::make('123'),
        ]);

        User::create([
            'nama' => 'Rendi',
            'email' => 'rendi@gmail.com',
            'role' => 'mahasiswa',
            'password' => Hash::make('123'),
        ]);
    }
}
