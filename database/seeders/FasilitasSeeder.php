<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Fasilitas;

class FasilitasSeeder extends Seeder
{
    public function run(): void
    {
        Fasilitas::insert([
            [
                'nama_fasilitas' => 'AC Gudang',
                'lokasi' => 'Gudang Utama',
                'deskripsi' => 'AC untuk menjaga suhu gudang',
                'status_fasilitas' => 'baik',
            ],
            [
                'nama_fasilitas' => 'Komputer Admin',
                'lokasi' => 'Ruang Admin',
                'deskripsi' => 'Komputer untuk operasional administrasi',
                'status_fasilitas' => 'baik',
            ],
            [
                'nama_fasilitas' => 'Rak Penyimpanan',
                'lokasi' => 'Area Gudang',
                'deskripsi' => 'Rak penyimpanan barang gudang',
                'status_fasilitas' => 'baik',
            ],
        ]);
    }
}