<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\KategoriFasilitas;

class KategoriFasilitasSeeder extends Seeder
{
    public function run(): void
    {
        KategoriFasilitas::insert([
            [
                'nama_kategori' => 'Kelistrikan',
                'deskripsi' => 'Kerusakan yang berhubungan dengan listrik'
            ],
            [
                'nama_kategori' => 'Pendingin',
                'deskripsi' => 'Kerusakan AC atau alat pendingin'
            ],
            [
                'nama_kategori' => 'Peralatan Gudang',
                'deskripsi' => 'Kerusakan alat dan fasilitas gudang'
            ],
        ]);
    }
}