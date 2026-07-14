@extends('layouts.app')

@section('page-title', 'Detail Pengaduan')

@section('content')
<div class="max-w-4xl mx-auto space-y-6">
    {{-- Info Utama --}}
    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-8">
        <div class="flex justify-between items-start mb-6">
            <h2 class="text-xl font-bold text-gray-800">Detail Pengaduan #{{ $pengaduan->id_pengaduan }}</h2>
            @php
                $statusColor = [
                    'baru' => 'bg-blue-100 text-blue-700',
                    'proses' => 'bg-yellow-100 text-yellow-700',
                    'selesai' => 'bg-green-100 text-green-700'
                ][$pengaduan->status_pengaduan] ?? 'bg-gray-100 text-gray-700';
            @endphp
            <span class="px-4 py-1.5 rounded-full text-xs font-bold uppercase tracking-wider {{ $statusColor }}">
                {{ ucfirst($pengaduan->status_pengaduan) }}
            </span>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <p class="text-xs text-gray-400 font-bold uppercase tracking-widest mb-1">Fasilitas</p>
                <p class="font-semibold text-gray-800">{{ $pengaduan->fasilitas->nama_fasilitas ?? '-' }}</p>
            </div>
            <div>
                <p class="text-xs text-gray-400 font-bold uppercase tracking-widest mb-1">Lokasi</p>
                <p class="font-semibold text-gray-800">{{ $pengaduan->fasilitas->lokasi ?? '-' }}</p>
            </div>
            <div>
                <p class="text-xs text-gray-400 font-bold uppercase tracking-widest mb-1">Kategori</p>
                <p class="font-semibold text-gray-800">{{ $pengaduan->kategoriFasilitas->nama_kategori ?? '-' }}</p>
            </div>
            <div>
                <p class="text-xs text-gray-400 font-bold uppercase tracking-widest mb-1">Prioritas</p>
                <p class="font-semibold text-red-600">{{ ucfirst($pengaduan->prioritas) }}</p>
            </div>
        </div>

        <div class="mt-6 pt-6 border-t border-gray-100">
            <p class="text-xs text-gray-400 font-bold uppercase tracking-widest mb-2">Keluhan</p>
            <p class="text-gray-700 bg-gray-50 p-4 rounded-xl">{{ $pengaduan->deskripsi_kerusakan }}</p>
        </div>
    </div>

    {{-- Info Perbaikan --}}
    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-8">
        <h3 class="text-lg font-bold text-gray-800 mb-6 flex items-center gap-2">
            <i class="fa-solid fa-screwdriver-wrench text-red-600"></i> Informasi Perbaikan
        </h3>
        
        @if($pengaduan->perbaikan)
            <div class="space-y-4">
                <div class="flex justify-between border-b pb-2">
                    <span class="text-gray-500 text-sm">Teknisi:</span>
                    <span class="font-semibold">{{ $pengaduan->perbaikan->teknisi->nama_teknisi ?? '-' }}</span>
                </div>
                <div class="flex justify-between border-b pb-2">
                    <span class="text-gray-500 text-sm">Status Perbaikan:</span>
                    <span class="font-semibold text-blue-600">{{ $pengaduan->perbaikan->status_perbaikan }}</span>
                </div>
                <div>
                    <span class="text-gray-500 text-sm block mb-1">Keterangan:</span>
                    <p class="bg-gray-50 p-4 rounded-xl text-sm italic text-gray-700">"{{ $pengaduan->perbaikan->deskripsi_perbaikan }}"</p>
                </div>
            </div>
        @else
            <div class="text-center py-6 border-2 border-dashed border-gray-100 rounded-xl text-gray-400">
                <i class="fa-solid fa-clock mb-2"></i>
                <p class="text-sm">Belum ada teknisi yang ditugaskan.</p>
            </div>
        @endif
    </div>
</div>
@endsection