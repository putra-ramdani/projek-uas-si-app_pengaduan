<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Teknisi;

class TeknisiSeeder extends Seeder
{
    public function run(): void
    {
        Teknisi::insert([
            [
                'nama_teknisi' => 'Budi Teknisi',
                'no_telepon' => '081234567890',
                'email' => 'budi@teknisi.com'
            ],
            [
                'nama_teknisi' => 'Andi Teknisi',
                'no_telepon' => '081298765432',
                'email' => 'andi@teknisi.com'
            ],
        ]);
    }
}