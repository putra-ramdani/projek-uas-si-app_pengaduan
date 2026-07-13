<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pengaduan;
use Illuminate\Http\Request;

class LaporanController extends Controller
{
    /**
     * Menampilkan daftar laporan pengaduan.
     * Filter: tanggal, status, dan pencarian (nama fasilitas / no laporan).
     */
    public function index(Request $request)
    {
        $query = Pengaduan::with('fasilitas');

        if ($request->filled('tanggal')) {
            $query->whereDate('created_at', $request->tanggal);
        }

        if ($request->filled('status') && $request->status !== 'semua') {
            $query->where('status_pengaduan', $request->status);
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->whereHas('fasilitas', function ($fq) use ($search) {
                    $fq->where('nama_fasilitas', 'like', "%{$search}%");
                })->orWhere('id', 'like', "%{$search}%");
            });
        }

        $laporan = $query->latest()->paginate(4)->withQueryString();

        return view('admin.laporan.index', compact('laporan'));
    }

    /**
     * Aksi cepat: tandai satu pengaduan sebagai selesai
     * tanpa perlu membuka form edit.
     */
    public function selesai(Request $request, $id)
    {
        $pengaduan = Pengaduan::findOrFail($id);
        $pengaduan->update(['status_pengaduan' => 'selesai']);

        return back()->with('success', 'Pengaduan #' . $id . ' berhasil ditandai selesai.');
    }

    /**
     * Export laporan pengaduan ke CSV (streaming, tanpa package tambahan).
     * Menghormati filter tanggal & status yang sedang aktif.
     */
    public function export(Request $request)
    {
        $query = Pengaduan::with('fasilitas');

        if ($request->filled('tanggal')) {
            $query->whereDate('created_at', $request->tanggal);
        }

        if ($request->filled('status') && $request->status !== 'semua') {
            $query->where('status_pengaduan', $request->status);
        }

        $data = $query->latest()->get();

        $filename = 'laporan-pengaduan-' . now()->format('Ymd-His') . '.csv';

        $headers = [
            'Content-Type'        => 'text/csv',
            'Content-Disposition' => "attachment; filename=\"{$filename}\"",
        ];

        $callback = function () use ($data) {
            $file = fopen('php://output', 'w');
            fputcsv($file, ['No Laporan', 'Fasilitas', 'Tanggal', 'Prioritas', 'Status']);

            foreach ($data as $item) {
                fputcsv($file, [
                    sprintf('65%03d', $item->id),
                    $item->fasilitas->nama_fasilitas ?? '-',
                    optional($item->created_at)->format('d M Y'),
                    ucfirst($item->prioritas),
                    ucfirst($item->status_pengaduan),
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}