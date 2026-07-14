@extends('layouts.app') {{-- Sesuaikan dengan nama layout indukmu --}}

@section('page-title', 'Buat Pengaduan')
@section('page-subtitle', 'Laporkan kerusakan fasilitas untuk tindak lanjut')

@section('content')
<div class="max-w-3xl">
    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
        <div class="px-8 py-6 border-b border-gray-100">
            <h2 class="text-lg font-bold">Formulir Pengaduan</h2>
            <p class="text-sm text-gray-500">Silakan isi detail kerusakan fasilitas di bawah ini dengan lengkap.</p>
        </div>

        <form action="{{ route('user.pengaduan.store') }}" method="POST" enctype="multipart/form-data" class="p-8 space-y-6">
            @csrf

            {{-- Fasilitas --}}
            <div>
                <label class="block text-sm font-semibold mb-3">Pilih Fasilitas</label>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                    @foreach($daftarFasilitas as $fasilitas)
                        <label class="relative flex items-center p-4 border rounded-xl cursor-pointer hover:bg-gray-50 transition-all border-gray-200">
                            <input type="radio" name="id_fasilitas" value="{{ $fasilitas->id_fasilitas }}" class="peer sr-only" required>
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 rounded-lg bg-gray-100 flex items-center justify-center text-gray-500 peer-checked:bg-red-600 peer-checked:text-white transition-colors">
                                    <i class="fa-solid fa-building"></i>
                                </div>
                                <div>
                                    <p class="font-medium text-sm">{{ $fasilitas->nama_fasilitas }}</p>
                                    <p class="text-xs text-gray-400">{{ $fasilitas->lokasi }}</p>
                                </div>
                            </div>
                            <div class="absolute right-4 hidden peer-checked:block text-red-600">
                                <i class="fa-solid fa-check-circle"></i>
                            </div>
                        </label>
                    @endforeach
                </div>
            </div>

            {{-- Kategori & Urgensi --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-semibold mb-2">Kategori</label>
                    <select name="id_kategori" class="w-full rounded-lg border-gray-200 text-sm focus:border-red-500 focus:ring-red-500" required>
                        <option value="">Pilih Kategori...</option>
                        @foreach($daftarKategori as $kategori)
                            <option value="{{ $kategori->id_kategori }}">{{ $kategori->nama_kategori }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-semibold mb-2">Tingkat Urgensi</label>
                    <div class="flex gap-2">
                        <input type="radio" name="prioritas" value="rendah" id="p_rendah" class="peer sr-only">
                        <label for="p_rendah" class="flex-1 text-center py-2 text-xs font-medium border rounded-lg cursor-pointer peer-checked:bg-green-600 peer-checked:text-white transition-all">
                            Rendah
                        </label>

                        <input type="radio" name="prioritas" value="sedang" id="p_sedang" class="peer sr-only">
                        <label for="p_sedang" class="flex-1 text-center py-2 text-xs font-medium border rounded-lg cursor-pointer peer-checked:bg-yellow-500 peer-checked:text-white transition-all">
                            Sedang
                        </label>

                        <input type="radio" name="prioritas" value="tinggi" id="p_tinggi" class="peer sr-only">
                        <label for="p_tinggi" class="flex-1 text-center py-2 text-xs font-medium border rounded-lg cursor-pointer peer-checked:bg-red-600 peer-checked:text-white transition-all">
                            Tinggi
                        </label>
                    </div>
                </div>
            </div>

            {{-- Deskripsi --}}
            <div>
                <label class="block text-sm font-semibold mb-2">Detail Kerusakan</label>
                <textarea name="deskripsi_kerusakan" rows="4" class="w-full rounded-lg border-gray-200 text-sm focus:border-red-500 focus:ring-red-500" placeholder="Jelaskan kondisi kerusakan..." required></textarea>
            </div>

            {{-- Upload --}}
            <div>
                <label class="block text-sm font-semibold mb-2">Foto Bukti <span class="text-gray-400 font-normal">(Opsional)</span></label>
                <input type="file" name="foto_kerusakan" class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-red-50 file:text-red-700 hover:file:bg-red-100">
            </div>

            {{-- Action --}}
            <div class="pt-4 flex gap-3">
                <a href="{{ route('user.dashboard') }}" class="px-6 py-2.5 rounded-lg border border-gray-200 text-sm font-medium hover:bg-gray-50">Batal</a>
                <button type="submit" class="px-6 py-2.5 rounded-lg bg-red-600 text-white text-sm font-medium hover:bg-red-700 shadow-sm shadow-red-200">Kirim Laporan</button>
            </div>
        </form>
    </div>
</div>
@endsection