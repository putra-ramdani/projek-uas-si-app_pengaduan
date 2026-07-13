<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Pengaduan extends Model
{
    protected $table = 'pengaduan';
    protected $primaryKey = 'id_pengaduan';

    protected $fillable = [
        'id_pengguna', 'id_fasilitas', 'id_kategori', 
        'tanggal_pengaduan', 'deskripsi_kerusakan', 
        'foto_kerusakan', 'prioritas', 'status_pengaduan'
    ];

    // Relasi balik ke Fasilitas
    public function fasilitas(): BelongsTo
    {
        return $this->belongsTo(Fasilitas::class, 'id_fasilitas', 'id_fasilitas');
    }
}