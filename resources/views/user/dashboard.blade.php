@extends('layouts.app')

@section('title', 'Dashboard User')

@section('page-title', 'Dashboard User')
@section('page-subtitle', 'Selamat datang, ' . Auth::user()->name . '!')

@section('content')
<div class="space-y-6">

    <div class="flex justify-end">
        <a href="{{ route('user.pengaduan.create') }}"
           class="inline-flex items-center gap-2 bg-red-600 hover:bg-red-700 text-white text-sm font-semibold px-5 py-2.5 rounded-lg shadow-sm shadow-red-200 transition-colors duration-150">
            <i class="fa-solid fa-plus"></i>
            Buat Pengaduan
        </a>
    </div>

    {{-- ============ STAT CARDS ============ --}}
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6 text-center">
            <p class="text-sm text-gray-400 mb-1">Total Pengaduan</p>
            <h2 class="text-3xl font-bold text-gray-800">{{ $totalPengaduan }}</h2>
        </div>
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6 text-center">
            <p class="text-sm text-gray-400 mb-1">Pengaduan Baru</p>
            <h2 class="text-3xl font-bold text-amber-500">{{ $pengaduanBaru }}</h2>
        </div>
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6 text-center">
            <p class="text-sm text-gray-400 mb-1">Selesai</p>
            <h2 class="text-3xl font-bold text-green-600">{{ $pengaduanSelesai }}</h2>
        </div>
    </div>

    {{-- ============ RIWAYAT PENGADUAN ============ --}}
    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6">
        <h5 class="font-bold text-gray-800 mb-4">Riwayat Pengaduan Saya</h5>
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="bg-gray-50 text-gray-500 text-left">
                        <th class="px-4 py-3 rounded-l-lg w-[5%]">No</th>
                        <th class="px-4 py-3 w-[22%]">Fasilitas</th>
                        <th class="px-4 py-3 w-[33%]">Detail Kerusakan</th>
                        <th class="px-4 py-3 w-[15%]">Tanggal</th>
                        <th class="px-4 py-3 w-[13%] text-center">Status</th>
                        <th class="px-4 py-3 rounded-r-lg w-[12%] text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    @forelse($daftarPengaduan as $key => $pengaduan)
                        <tr class="hover:bg-gray-50/60 transition-colors duration-150">
                            <td class="px-4 py-3 text-gray-500">{{ $key + 1 }}</td>
                            <td class="px-4 py-3 font-semibold text-gray-700">
                                {{ $pengaduan->fasilitas->nama_fasilitas ?? 'Fasilitas Tidak Diketahui' }}
                            </td>
                            <td class="px-4 py-3 text-gray-500">{{ Str::limit($pengaduan->deskripsi_kerusakan, 60) }}</td>
                            <td class="px-4 py-3 text-gray-500">{{ \Carbon\Carbon::parse($pengaduan->tanggal_pengaduan)->format('d M Y') }}</td>
                            <td class="px-4 py-3 text-center">
                                @if($pengaduan->status_pengaduan == 'baru')
                                    <span class="inline-block bg-blue-50 text-blue-600 text-xs font-medium px-3 py-1 rounded-full">Baru</span>
                                @elseif($pengaduan->status_pengaduan == 'proses')
                                    <span class="inline-block bg-amber-50 text-amber-600 text-xs font-medium px-3 py-1 rounded-full">Proses</span>
                                @elseif($pengaduan->status_pengaduan == 'selesai')
                                    <span class="inline-block bg-green-50 text-green-600 text-xs font-medium px-3 py-1 rounded-full">Selesai</span>
                                @else
                                    <span class="inline-block bg-gray-100 text-gray-500 text-xs font-medium px-3 py-1 rounded-full">{{ $pengaduan->status_pengaduan }}</span>
                                @endif
                            </td>
                            <td class="px-4 py-3 text-center">
                                <a href="{{ route('user.pengaduan.show', $pengaduan->id_pengaduan) }}"
                                   class="inline-block border border-red-200 text-red-600 hover:bg-red-50 text-xs font-semibold px-3 py-1.5 rounded-lg transition-colors duration-150">
                                    Detail
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center text-gray-400 py-10">
                                Belum ada riwayat pengaduan yang dibuat.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>
@endsection