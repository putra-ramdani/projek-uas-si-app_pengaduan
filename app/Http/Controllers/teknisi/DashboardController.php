<?php

namespace App\Http\Controllers\Teknisi;

use App\Http\Controllers\Controller;
use App\Models\Perbaikan;
use Illuminate\Database\Eloquent\Relations\HasOne;

class DashboardController extends Controller
{
    public function index()
    {
        // sementara ambil teknisi pertama
        // nanti bisa diganti berdasarkan login teknisi
        $idTeknisi = 1;

        $daftarPerbaikan = Perbaikan::with([
            'pengaduan.fasilitas',
            'pengaduan'
        ])
        ->where('id_teknisi', $idTeknisi)
        ->latest('id_perbaikan')
        ->get();


        return view('teknisi.dashboard', compact(
            'daftarPerbaikan'
        ));
    }
}