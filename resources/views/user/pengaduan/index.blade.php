@extends('layouts.app')

@section('page-title', 'Riwayat Pengaduan')

@section('content')
<div class="max-w-6xl mx-auto">
    <h3 class="text-xl font-bold mb-6">Riwayat Pengaduan Saya</h3>

    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left">
                <thead class="text-xs text-gray-500 uppercase bg-gray-50">
                    <tr>
                        <th class="px-6 py-4">No</th>
                        <th class="px-6 py-4">Fasilitas</th>
                        <th class="px-6 py-4">Keluhan</th>
                        <th class="px-6 py-4">Status</th>
                        <th class="px-6 py-4">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @foreach($daftarPengaduan as $item)
                    <tr class="hover:bg-gray-50 transition-colors">
                        <td class="px-6 py-4 font-medium">{{ $loop->iteration }}</td>
                        <td class="px-6 py-4">{{ $item->fasilitas->nama_fasilitas ?? '-' }}</td>
                        <td class="px-6 py-4 text-gray-600">{{ Str::limit($item->deskripsi_kerusakan, 40) }}</td>
                        <td class="px-6 py-4">
                            {{-- Badge Status --}}
                            <span class="px-3 py-1 rounded-full text-xs font-medium 
                                {{ $item->status_pengaduan == 'selesai' ? 'bg-green-100 text-green-700' : 
                                   ($item->status_pengaduan == 'proses' ? 'bg-yellow-100 text-yellow-700' : 'bg-gray-100 text-gray-700') }}">
                                {{ ucfirst($item->status_pengaduan) }}
                            </span>
                        </td>
                        <td class="px-6 py-4">
                            <a href="{{ route('user.pengaduan.show', $item->id_pengaduan) }}" 
                               class="text-red-600 hover:text-red-800 font-semibold text-xs hover:underline">
                                Detail
                            </a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        
        @if($daftarPengaduan->isEmpty())
            <div class="p-8 text-center text-gray-500 text-sm">
                Belum ada data pengaduan.
            </div>
        @endif
    </div>
</div>
@endsection