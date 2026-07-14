<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Teknisi;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class TeknisiSeeder extends Seeder
{
    public function run(): void
    {
        $user = User::firstOrCreate(
            [
                'username' => 'budi_teknisi'
            ],
            [
                'name' => 'Budi Teknisi',
                'email' => 'budi@teknisi.com',
                'password' => Hash::make('password123'),
                'no_telepon' => '081234567890',
                'role' => 'teknisi',
                'status' => 'aktif',
            ]
        );


        Teknisi::firstOrCreate(
            [
                'email' => 'budi@teknisi.com'
            ],
            [
                'id_user' => $user->id,
                'nama_teknisi' => 'Budi Teknisi',
                'no_telepon' => '081234567890',
            ]
        );
    }
}