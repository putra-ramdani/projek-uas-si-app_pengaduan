<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Pengaduan extends Model
{
    use HasFactory;

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
        'status_pengaduan',
    ];

    protected function casts(): array
    {
        return [
            'tanggal_pengaduan' => 'date',
        ];
    }

    // pelapor
    public function pengguna(): BelongsTo
    {
        return $this->belongsTo(User::class, 'id_pengguna', 'id');
    }

    public function fasilitas(): BelongsTo
    {
        return $this->belongsTo(Fasilitas::class, 'id_fasilitas', 'id_fasilitas');
    }

    public function kategoriFasilitas(): BelongsTo
    {
        return $this->belongsTo(KategoriFasilitas::class, 'id_kategori', 'id_kategori');
    }

    // riwayat/log progres perbaikan untuk pengaduan ini
    public function perbaikan(): HasMany
    {
        return $this->hasMany(Perbaikan::class, 'id_pengaduan', 'id_pengaduan');
    }
}