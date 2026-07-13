<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Complaint extends Model
{
    // Mengarahkan model ini ke tabel 'pengaduan' asli di database
    protected $table = 'pengaduan';

    // Menggunakan primary key asli tabelmu
    protected $primaryKey = 'id_pengaduan';

    protected $fillable = [
        'id_pengguna', 'id_fasilitas', 'id_kategori', 
        'tanggal_pengaduan', 'deskripsi_kerusakan', 
        'foto_kerusakan', 'prioritas', 'status_pengaduan'
    ];

    // Relasi ke model Fasilitas
    public function fasilitas()
    {
        return $this->belongsTo(Fasilitas::class, 'id_fasilitas', 'id_fasilitas');
    }
}