<?php

namespace App\Http\Controllers\Users;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Pengaduan;
use App\Models\Fasilitas;
use App\Models\KategoriFasilitas;

class ComplaintController extends Controller
{
    // Menampilkan halaman riwayat pengaduan (jika diperlukan rute khusus)
// Menampilkan halaman riwayat pengaduan / dashboard user
    public function index()
    {
        $daftarPengaduan = Pengaduan::with([
            'fasilitas',
            'kategoriFasilitas'
        ])
        ->where('id_pengguna', Auth::id())
        ->latest('id_pengaduan')
        ->get();


        return view('user.pengaduan.index', compact(
            'daftarPengaduan'
        ));
    }
    // Menampilkan FORM pengaduan baru
    public function create()
    {
        // Ambil data fasilitas & kategori dari database untuk pilihan dropdown di form
        $daftarFasilitas = Fasilitas::all();
        $daftarKategori  = KategoriFasilitas::all();

        return view('user.pengaduan.create', compact('daftarFasilitas', 'daftarKategori'));
    }

    // MENYIMPAN data pengaduan ke database
    public function store(Request $request)
    {
        // 1. Validasi Input Form
        $request->validate([
            'id_fasilitas'        => 'nullable|exists:fasilitas,id_fasilitas', // Ganti required jadi nullable
            'id_kategori'         => 'nullable|exists:kategori_fasilitas,id_kategori', // Ganti required jadi nullable
            'deskripsi_kerusakan' => 'required|string|min:5',
            'prioritas'           => 'required|in:rendah,sedang,tinggi',
            'foto_kerusakan'      => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        // 2. Proses Upload Foto (Jika ada file yang diunggah)
        $namaFoto = null;
        if ($request->hasFile('foto_kerusakan')) {
            // Simpan di folder public/storage/pengaduan
            $namaFoto = $request->file('foto_kerusakan')->store('pengaduan', 'public');
        }

        // 3. Simpan ke Database menggunakan Model Pengaduan
        Pengaduan::create([
            'id_pengguna'         => Auth::id(), // ID User yang sedang login
            'id_fasilitas'        => $request->id_fasilitas,
            'id_kategori'         => $request->id_kategori,
            'tanggal_pengaduan'   => now()->format('Y-m-d'), // Otomatis tanggal hari ini
            'deskripsi_kerusakan' => $request->deskripsi_kerusakan,
            'foto_kerusakan'      => $namaFoto,
            'prioritas'           => $request->prioritas,
            'status_pengaduan'    => 'baru', // Default berstatus baru
        ]);

        // 4. Redirect kembali ke Dashboard dengan pesan sukses
        return redirect()->route('user.dashboard')->with('success', 'Pengaduan berhasil dikirim dan akan segera diproses!');
    }
    public function show($id)
    {
        $pengaduan = Pengaduan::with([
            'fasilitas',
            'kategoriFasilitas',
            'perbaikan.teknisi'
        ])
        ->where('id_pengguna', Auth::id())
        ->findOrFail($id);

        return view('user.pengaduan.show', compact('pengaduan'));
    }
}