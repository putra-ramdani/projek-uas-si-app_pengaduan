<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Perbaikan;

class PerbaikanSeeder extends Seeder
{
    public function run(): void
    {
        Perbaikan::insert([
            [
                'id_pengaduan' => 1,
                'id_teknisi' => 1,
                'tanggal_mulai' => now(),
                'tanggal_selesai' => null,
                'deskripsi_perbaikan' => 'Menunggu pengecekan AC',
                'status_perbaikan' => 'proses',
            ],
        ]);
    }
}