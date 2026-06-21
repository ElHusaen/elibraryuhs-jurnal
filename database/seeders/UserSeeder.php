<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'nama' => 'Administrator',
            'email' => 'admin@elibrary.com',
            'password' => Hash::make('admin123'),
            'role' => 'admin',
        ]);

        // Tambahkan user mahasiswa contoh (opsional)
        User::create([
            'nama' => 'Mahasiswa Contoh',
            'email' => 'mahasiswa@elibrary.com',
            'password' => Hash::make('mahasiswa123'),
            'role' => 'mahasiswa',
        ]);

        $this->command->info('✅ User Admin dan Mahasiswa berhasil dibuat!');
    }
}