<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pengaduan;
use Illuminate\Http\Request;

class PengaduanController extends Controller
{
    /**
     * Halaman "Daftar Data Pengaduan".
     * Filter: status, prioritas, dan pencarian bebas (fasilitas/prioritas/tanggal).
     */
    public function index(Request $request)
    {
        $query = Pengaduan::with('fasilitas');

        if ($request->filled('status') && $request->status !== 'semua') {
            $query->where('status_pengaduan', $request->status);
        }

        if ($request->filled('prioritas') && $request->prioritas !== 'semua') {
            $query->where('prioritas', $request->prioritas);
        }

        if ($request->filled('search')) {
            $keyword = $request->search;
            $query->where(function ($q) use ($keyword) {
                $q->where('prioritas', 'like', "%{$keyword}%")
                  ->orWhere('tanggal_pengaduan', 'like', "%{$keyword}%")
                  ->orWhereHas('fasilitas', function ($q2) use ($keyword) {
                      $q2->where('nama_fasilitas', 'like', "%{$keyword}%");
                  });
            });
        }

        $pengaduan = $query->orderByDesc('tanggal_pengaduan')
            ->paginate(4)
            ->withQueryString();

        return view('admin.pengaduan.index', compact('pengaduan'));
    }

    /**
     * Halaman "Detail Pengaduan" — info lengkap + riwayat penanganan/log progres.
     */
    public function show($id)
    {
        $pengaduan = Pengaduan::with(['fasilitas', 'pelapor', 'riwayat'])
            ->findOrFail($id);

        return view('admin.pengaduan.detail', compact('pengaduan'));
    }

    /**
     * Placeholder — halaman Edit Pengaduan akan dikerjakan terpisah.
     * Sudah disiapkan supaya tombol "Edit" di tabel tidak error.
     */
    public function edit($id)
    {
        $pengaduan = Pengaduan::findOrFail($id);

        return view('admin.pengaduan.edit', compact('pengaduan'));
    }

    /**
     * Placeholder aksi tombol "Kirim" di panel Bukti Foto (halaman Detail Pengaduan).
     * Logic-nya belum ditentukan — isi sesuai kebutuhan nanti.
     */
    public function kirimFoto(Request $request, $id)
    {
        // TODO: isi logic aksi "Kirim" di sini.
        return back()->with('success', 'Aksi Kirim berhasil dijalankan (placeholder).');
    }

    /**
     * Placeholder aksi tombol "Batal" di panel Bukti Foto (halaman Detail Pengaduan).
     * Logic-nya belum ditentukan — isi sesuai kebutuhan nanti.
     */
    public function batalFoto(Request $request, $id)
    {
        // TODO: isi logic aksi "Batal" di sini.
        return back()->with('success', 'Aksi Batal berhasil dijalankan (placeholder).');
    }
}