<?php

namespace App\Http\Controllers\Teknisi;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\Perbaikan;

class TeknisiDashboardController extends Controller
{

    public function index()
    {

        $user = Auth::user();


        $perbaikan = Perbaikan::with([
            'pengaduan.fasilitas'
        ])
        ->whereHas('teknisi', function($query) use ($user){

            $query->where('email', $user->email);

        })
        ->get();


        return view('teknisi.dashboard', compact('perbaikan'));

    }

}