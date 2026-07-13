<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Pengaduan;

class PengaduanSeeder extends Seeder
{
    public function run(): void
    {
        Pengaduan::insert([
            [
                'id_pengguna' => \App\Models\User::where('role', 'karyawan_gudang')->first()->id,
                'id_fasilitas' => 1,
                'id_kategori' => 2,
                'tanggal_pengaduan' => now(),
                'deskripsi_kerusakan' => 'AC tidak menyala dan ruangan panas',
                'foto_kerusakan' => null,
                'prioritas' => 'tinggi',
                'status_pengaduan' => 'baru'
            ]
        ]);
    }
}