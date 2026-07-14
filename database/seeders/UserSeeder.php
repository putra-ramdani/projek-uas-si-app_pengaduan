<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Akun Admin
        User::create([
            'name' => 'Administrator Sistem',
            'username' => 'admin123',
            'email' => 'admin@mail.com',
            'password' => Hash::make('password123'),
            'no_telepon' => '081234567890',
            'role' => 'admin',
            'status' => 'aktif',
        ]);

        // 2. Akun Karyawan Gudang (Pelapor)
        User::create([
            'name' => 'Rudi Hartono',
            'username' => 'rudi_gudang',
            'email' => 'rudi@mail.com',
            'password' => Hash::make('password123'),
            'no_telepon' => '082345678901',
            'role' => 'karyawan_gudang',
            'status' => 'aktif',
        ]);

        // 3. Akun GA (General Affairs)
        User::create([
            'name' => 'Siti Aminah',
            'username' => 'siti_ga',
            'email' => 'siti@mail.com',
            'password' => Hash::make('password123'),
            'no_telepon' => '083456789012',
            'role' => 'ga',
            'status' => 'aktif',
        ]);

        User::create([
            'name' => 'Budi Teknisi',
            'username' => 'budi_teknisi',
            'email' => 'budi@teknisi.com',
            'password' => Hash::make('password123'),
            'no_telepon' => '081234567890',
            'role' => 'teknisi',
            'status' => 'aktif',
        ]);


        User::create([
            'name' => 'Andi Teknisi',
            'username' => 'andi_teknisi',
            'email' => 'andi@teknisi.com',
            'password' => Hash::make('password123'),
            'no_telepon' => '081298765432',
            'role' => 'teknisi',
            'status' => 'aktif',
        ]);
    }
}