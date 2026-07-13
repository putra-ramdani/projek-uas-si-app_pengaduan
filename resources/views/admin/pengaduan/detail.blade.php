@extends('admin.layouts.app')

@section('title', 'Detail Pengaduan')
@section('page-title', 'Detail Pengaduan')
@section('page-subtitle', 'Selamat datang, ' . (auth()->user()->name ?? 'Admin') . '!')

@section('content')

@php
    $tingkatLabel = match ($pengaduan->prioritas) {
        'tinggi' => 'Tinggi / Berat',
        'sedang' => 'Sedang / Menengah',
        'rendah' => 'Rendah / Ringan',
        default  => ucfirst($pengaduan->prioritas),
    };

    $tingkatStyle = match ($pengaduan->prioritas) {
        'tinggi' => 'bg-red-50 text-red-600',
        'sedang' => 'bg-yellow-50 text-yellow-700',
        'rendah' => 'bg-green-50 text-green-700',
        default  => 'bg-gray-50 text-gray-600',
    };

    // Warna ikon jam pada riwayat — sekadar visual mengikuti urutan (biru → oranye → hijau).
    $logColors = ['text-blue-500', 'text-orange-500', 'text-green-500'];
    $logBadge  = ['bg-blue-50 text-blue-600', 'bg-yellow-50 text-yellow-700', 'bg-green-50 text-green-700'];
@endphp

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

    {{-- ============ DETAIL INFO (kiri, 2 kolom) ============ --}}
    <div class="lg:col-span-2 bg-white rounded-2xl shadow-sm p-6 space-y-5">

        <div class="flex items-start gap-4 pb-4 border-b border-gray-50">
            <div class="w-10 h-10 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center shrink-0">
                <i class="fa-solid fa-address-card"></i>
            </div>
            <div>
                <p class="text-sm text-gray-400">ID Pengaduan</p>
                <p class="font-semibold text-gray-700">{{ sprintf('#TK-%04d', $pengaduan->id) }}</p>
            </div>
        </div>

        <div class="flex items-start gap-4 pb-4 border-b border-gray-50">
            <div class="w-10 h-10 rounded-xl bg-green-50 text-green-600 flex items-center justify-center shrink-0">
                <i class="fa-solid fa-user"></i>
            </div>
            <div>
                <p class="text-sm text-gray-400">Nama Pelapor</p>
                <p class="font-semibold text-gray-700">
                    {{ $pengaduan->pelapor->name ?? '-' }}
                    @if (!empty($pengaduan->pelapor->jabatan))
                        <span class="font-normal text-gray-500">({{ $pengaduan->pelapor->jabatan }})</span>
                    @endif
                </p>
            </div>
        </div>

        <div class="flex items-start gap-4 pb-4 border-b border-gray-50">
            <div class="w-10 h-10 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center shrink-0">
                <i class="fa-solid fa-building"></i>
            </div>
            <div>
                <p class="text-sm text-gray-400">Fasilitas Rusak</p>
                <p class="font-semibold text-gray-700">
                    {{ $pengaduan->fasilitas->nama_fasilitas ?? '-' }}
                    @if (!empty($pengaduan->fasilitas->lokasi))
                        <span class="font-normal text-gray-500">({{ $pengaduan->fasilitas->lokasi }})</span>
                    @endif
                </p>
            </div>
        </div>

        <div class="flex items-start gap-4 pb-4 border-b border-gray-50">
            <div class="w-10 h-10 rounded-xl bg-yellow-50 text-yellow-600 flex items-center justify-center shrink-0">
                <i class="fa-solid fa-triangle-exclamation"></i>
            </div>
            <div>
                <p class="text-sm text-gray-400 mb-1">Tingkat Kerusakan</p>
                <span class="inline-block px-3 py-1 rounded-full text-xs font-semibold {{ $tingkatStyle }}">
                    {{ $tingkatLabel }}
                </span>
            </div>
        </div>

        <div class="flex items-start gap-4 pb-4 border-b border-gray-50">
            <div class="w-10 h-10 rounded-xl bg-purple-50 text-purple-600 flex items-center justify-center shrink-0">
                <i class="fa-solid fa-file-lines"></i>
            </div>
            <div class="flex-1">
                <p class="text-sm text-gray-400 mb-1">Deskripsi Kerusakan</p>
                <div class="bg-gray-50 rounded-xl px-4 py-3 text-sm text-gray-600 leading-relaxed">
                    {{ $pengaduan->deskripsi }}
                </div>
            </div>
        </div>

        <div class="flex items-start gap-4">
            <div class="w-10 h-10 rounded-xl bg-red-50 text-red-500 flex items-center justify-center shrink-0">
                <i class="fa-solid fa-calendar-days"></i>
            </div>
            <div>
                <p class="text-sm text-gray-400">Tanggal Lapor</p>
                <p class="font-semibold text-gray-700">
                    {{ \Illuminate\Support\Carbon::parse($pengaduan->tanggal_pengaduan)->translatedFormat('d/m/Y - H.i') }} WIB
                </p>
            </div>
        </div>
    </div>

    {{-- ============ BUKTI FOTO (kanan) ============ --}}
    <div class="bg-white rounded-2xl shadow-sm p-6 h-fit">
        <h3 class="font-bold text-gray-800 mb-4">Bukti Foto</h3>

        <div class="rounded-xl overflow-hidden border border-gray-100 mb-3">
            @if (!empty($pengaduan->foto))
                <img src="{{ asset('storage/' . $pengaduan->foto) }}" alt="Bukti foto pengaduan" class="w-full h-56 object-cover">
            @else
                <div class="w-full h-56 bg-gray-50 flex items-center justify-center text-gray-300 text-sm">
                    Tidak ada foto
                </div>
            @endif
        </div>

        <div class="flex items-center gap-2 text-sm text-gray-500 mb-5">
            <i class="fa-regular fa-file-lines text-purple-400"></i>
            {{ $pengaduan->nama_file_foto ?? basename($pengaduan->foto ?? '-') }}
        </div>

        {{--
            Placeholder — logic tombol Kirim & Batal belum ditentukan,
            route sudah disiapkan (admin.pengaduan.kirim / admin.pengaduan.batal)
            supaya tinggal diisi actionnya di controller.
        --}}
        <div class="flex items-center gap-3">
            <form method="POST" action="{{ route('admin.pengaduan.kirim', $pengaduan->id) }}" class="flex-1">
                @csrf
                <button type="submit"
                        class="w-full inline-flex items-center justify-center gap-2 bg-blue-600 hover:bg-blue-700
                               text-white text-sm font-semibold px-4 py-2.5 rounded-xl transition-colors duration-150">
                    <i class="fa-solid fa-paper-plane"></i> Kirim
                </button>
            </form>

            <form method="POST" action="{{ route('admin.pengaduan.batal', $pengaduan->id) }}" class="flex-1">
                @csrf
                <button type="submit"
                        class="w-full inline-flex items-center justify-center gap-2 bg-white hover:bg-red-50
                               border border-red-200 text-red-600 text-sm font-semibold px-4 py-2.5 rounded-xl transition-colors duration-150">
                    <i class="fa-solid fa-trash"></i> Batal
                </button>
            </form>
        </div>
    </div>

    {{-- ============ RIWAYAT PENANGANAN / LOG PROGRES (bawah, full width) ============ --}}
    <div class="lg:col-span-3 bg-white rounded-2xl shadow-sm p-6">
        <h3 class="font-bold text-gray-800 mb-4">Riwayat Penanganan / Log Progres</h3>

        <table class="w-full text-sm">
            <thead>
                <tr class="text-left text-xs font-semibold text-gray-400 border-b border-gray-100">
                    <th class="py-3 pr-4">Waktu / Tanggal</th>
                    <th class="py-3 pr-4">Aktivitas Penanganan</th>
                    <th class="py-3">Oleh</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($pengaduan->riwayat as $index => $log)
                    @php
                        $colorText  = $logColors[$index % 3];
                        $colorBadge = $logBadge[$index % 3];
                    @endphp
                    <tr class="border-b border-gray-50 last:border-0">
                        <td class="py-3 pr-4">
                            <span class="inline-flex items-center gap-2 font-medium {{ $colorText }}">
                                <i class="fa-regular fa-clock"></i>
                                {{ optional($log->created_at)->format('d/m/Y H:i') }}
                            </span>
                        </td>
                        <td class="py-3 pr-4 text-gray-600">{{ $log->aktivitas }}</td>
                        <td class="py-3">
                            <span class="px-3 py-1 rounded-full text-xs font-semibold {{ $colorBadge }}">
                                {{ $log->oleh }}
                            </span>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="3" class="py-6 text-center text-gray-400">Belum ada riwayat penanganan.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection