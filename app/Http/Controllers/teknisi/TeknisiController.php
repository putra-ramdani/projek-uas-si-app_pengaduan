<?php

namespace App\Http\Controllers\Teknisi;

use App\Http\Controllers\Controller;
use App\Models\Perbaikan;

class TeknisiController extends Controller
{

    public function index()
    {
        // sementara teknisi login ID 1
        $idTeknisi = 1;


        $perbaikan = Perbaikan::with([
            'pengaduan.fasilitas',
            'pengaduan'
        ])
        ->where('id_teknisi', $idTeknisi)
        ->get();


        return view('teknisi.dashboard', compact('perbaikan'));
    }

}