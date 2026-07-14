<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Pengaduan extends Model
{
    protected $table = 'pengaduan';

    protected $primaryKey = 'id_pengaduan';

    protected $fillable = [
        'id_pengguna',
        'id_fasilitas',
        'id_kategori',
        'tanggal_pengaduan',
        'deskripsi_kerusakan',
        'foto_kerusakan',
        'prioritas',
        'status_pengaduan'
    ];


    // User yang membuat pengaduan
    public function pengguna(): BelongsTo
    {
        return $this->belongsTo(User::class, 'id_pengguna', 'id');
    }


    // Fasilitas yang dilaporkan
    public function fasilitas(): BelongsTo
    {
        return $this->belongsTo(
            Fasilitas::class,
            'id_fasilitas',
            'id_fasilitas'
        );
    }


    // Kategori fasilitas
    public function kategoriFasilitas(): BelongsTo
    {
        return $this->belongsTo(
            KategoriFasilitas::class,
            'id_kategori',
            'id_kategori'
        );
    }


    // Data perbaikan
    public function perbaikan()
    {
        return $this->hasOne(
            Perbaikan::class,
            'id_pengaduan',
            'id_pengaduan'
        );
    }
    
}