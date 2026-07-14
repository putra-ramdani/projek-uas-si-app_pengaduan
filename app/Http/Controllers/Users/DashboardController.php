<?php

namespace App\Http\Controllers\Users;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\Pengaduan; // DI SINI SUDAH KITA GANTI

class DashboardController extends Controller
{
    public function index()
    {
        // Ambil ID user yang sedang login
        $userId = Auth::id();

        // Hitung statistik berdasarkan model Pengaduan
        $totalPengaduan   = Pengaduan::where('id_pengguna', $userId)->count();
        $pengaduanBaru    = Pengaduan::where('id_pengguna', $userId)->where('status_pengaduan', 'baru')->count();
        $pengaduanSelesai = Pengaduan::where('id_pengguna', $userId)->where('status_pengaduan', 'selesai')->count();

        // Ambil riwayat pengaduan + relasi fasilitasnya
        $daftarPengaduan = Pengaduan::with([
            'fasilitas',
            'kategoriFasilitas'
        ])
        ->where('id_pengguna', $userId)
        ->latest('id_pengaduan')
        ->get();

        return view('user.dashboard', compact(
            'totalPengaduan', 
            'pengaduanBaru', 
            'pengaduanSelesai', 
            'daftarPengaduan'
        ));
    }
}