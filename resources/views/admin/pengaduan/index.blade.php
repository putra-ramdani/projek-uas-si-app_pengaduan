@extends('admin.layouts.app')

@section('title', 'Data Pengaduan')
@section('page-title', 'Data Pengaduan')
@section('page-subtitle', 'Sistem Informasi Fasilitas — Alfamart')

@section('content')
    <div class="mb-6">
        <h2 class="text-xl font-bold tracking-tight">Daftar Data Pengaduan</h2>
        <p class="text-sm text-gray-400">Lihat dan kelola semua data pengaduan fasilitas</p>
    </div>

    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm shadow-gray-100/50">
        <div class="p-6">
            {{-- ===== Filter & Search ===== --}}
            <form method="GET" class="flex flex-wrap items-center gap-3 mb-6">
                <select name="status" onchange="this.form.submit()"
                        class="border border-gray-200 rounded-xl pl-4 pr-9 py-2.5 text-sm text-gray-600 bg-white
                               bg-no-repeat bg-[right_0.75rem_center] bg-[length:14px]
                               bg-[url('data:image/svg+xml;utf8,%3Csvg%20xmlns=%22http://www.w3.org/2000/svg%22%20viewBox=%220%200%2020%2020%22%20fill=%22%239CA3AF%22%3E%3Cpath%20fill-rule=%22evenodd%22%20d=%22M5.23%207.21a.75.75%200%20011.06.02L10%2010.939l3.71-3.71a.75.75%200%20111.06%201.061l-4.24%204.24a.75.75%200%2001-1.06%200l-4.24-4.24a.75.75%200%2001.02-1.06z%22%20clip-rule=%22evenodd%22/%3E%3C/svg%3E')]
                               focus:outline-none focus:ring-2 focus:ring-red-100 focus:border-red-300 transition appearance-none">
                    <option value="semua" {{ request('status', 'semua') === 'semua' ? 'selected' : '' }}>Semua Status</option>
                    <option value="baru" {{ request('status') === 'baru' ? 'selected' : '' }}>Baru</option>
                    <option value="proses" {{ request('status') === 'proses' ? 'selected' : '' }}>Proses</option>
                    <option value="selesai" {{ request('status') === 'selesai' ? 'selected' : '' }}>Selesai</option>
                </select>

                <select name="prioritas" onchange="this.form.submit()"
                        class="border border-gray-200 rounded-xl pl-4 pr-9 py-2.5 text-sm text-gray-600 bg-white
                               bg-no-repeat bg-[right_0.75rem_center] bg-[length:14px]
                               bg-[url('data:image/svg+xml;utf8,%3Csvg%20xmlns=%22http://www.w3.org/2000/svg%22%20viewBox=%220%200%2020%2020%22%20fill=%22%239CA3AF%22%3E%3Cpath%20fill-rule=%22evenodd%22%20d=%22M5.23%207.21a.75.75%200%20011.06.02L10%2010.939l3.71-3.71a.75.75%200%20111.06%201.061l-4.24%204.24a.75.75%200%2001-1.06%200l-4.24-4.24a.75.75%200%2001.02-1.06z%22%20clip-rule=%22evenodd%22/%3E%3C/svg%3E')]
                               focus:outline-none focus:ring-2 focus:ring-red-100 focus:border-red-300 transition appearance-none">
                    <option value="semua" {{ request('prioritas', 'semua') === 'semua' ? 'selected' : '' }}>Semua Prioritas</option>
                    <option value="rendah" {{ request('prioritas') === 'rendah' ? 'selected' : '' }}>Rendah</option>
                    <option value="sedang" {{ request('prioritas') === 'sedang' ? 'selected' : '' }}>Sedang</option>
                    <option value="tinggi" {{ request('prioritas') === 'tinggi' ? 'selected' : '' }}>Tinggi</option>
                </select>

                <input type="text" name="search" value="{{ request('search') }}"
                       placeholder="Cari fasilitas, prioritas, atau tanggal..."
                       class="flex-1 min-w-[260px] ml-auto border border-gray-200 rounded-xl px-4 py-2.5 text-sm
                              focus:outline-none focus:ring-2 focus:ring-red-100 focus:border-red-300 transition">
            </form>

            {{-- ===== Tabel ===== --}}
            <div class="overflow-x-auto rounded-xl border border-gray-100">
                <table class="w-full text-sm">
                    <thead>
                        <tr class="text-left text-gray-400 bg-gray-50 border-b border-gray-100">
                            <th class="py-3.5 px-4 font-semibold text-xs tracking-wide uppercase">No</th>
                            <th class="px-4 font-semibold text-xs tracking-wide uppercase">ID Tiket</th>
                            <th class="px-4 font-semibold text-xs tracking-wide uppercase">Fasilitas</th>
                            <th class="px-4 font-semibold text-xs tracking-wide uppercase">Tanggal</th>
                            <th class="px-4 font-semibold text-xs tracking-wide uppercase">Prioritas</th>
                            <th class="px-4 font-semibold text-xs tracking-wide uppercase">Status</th>
                            <th class="px-4 font-semibold text-xs tracking-wide uppercase">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse ($pengaduan as $index => $item)
                            <tr class="hover:bg-gray-50/60 transition-colors duration-100">
                                <td class="py-4 px-4 text-gray-500">{{ $pengaduan->firstItem() + $index }}</td>
                                <td class="px-4 font-semibold text-gray-800">{{ $item->id_pengaduan }}</td>
                                <td class="px-4">{{ $item->fasilitas->nama_fasilitas ?? '-' }}</td>
                                <td class="px-4 text-gray-400">{{ optional($item->tanggal_pengaduan)->format('d M Y') }}</td>
                                <td class="px-4">
                                    @php
                                        $prioritasColor = [
                                            'tinggi' => 'bg-red-50 text-red-600 ring-1 ring-red-100',
                                            'sedang' => 'bg-amber-50 text-amber-600 ring-1 ring-amber-100',
                                            'rendah' => 'bg-emerald-50 text-emerald-600 ring-1 ring-emerald-100',
                                        ][$item->prioritas] ?? 'bg-gray-50 text-gray-600 ring-1 ring-gray-100';
                                    @endphp
                                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold {{ $prioritasColor }}">
                                        {{ ucfirst($item->prioritas) }}
                                    </span>
                                </td>
                                <td class="px-4">
                                    @php
                                        $statusColor = [
                                            'baru' => 'bg-blue-50 text-blue-600 ring-1 ring-blue-100',
                                            'proses' => 'bg-amber-50 text-amber-600 ring-1 ring-amber-100',
                                            'selesai' => 'bg-emerald-50 text-emerald-600 ring-1 ring-emerald-100',
                                        ][$item->status_pengaduan] ?? 'bg-gray-50 text-gray-600 ring-1 ring-gray-100';
                                    @endphp
                                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold {{ $statusColor }}">
                                        {{ ucfirst($item->status_pengaduan) }}
                                    </span>
                                </td>
                                <td class="px-4">
                                    <div class="flex gap-2">
                                        <a href="{{ route('admin.pengaduan.show', $item->id_pengaduan) }}"
                                           class="px-3 py-1.5 rounded-lg border border-blue-200 text-blue-600 text-xs font-semibold
                                                  hover:bg-blue-50 transition-colors duration-150">Detail</a>
                                        <a href="{{ route('admin.pengaduan.edit', $item->id_pengaduan) }}"
                                           class="px-3 py-1.5 rounded-lg border border-amber-200 text-amber-600 text-xs font-semibold
                                                  hover:bg-amber-50 transition-colors duration-150">Edit</a>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="py-10 text-center text-gray-400">Belum ada data pengaduan.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- ===== Footer: info + pagination ===== --}}
            <div class="flex items-center justify-between mt-5 text-sm text-gray-400">
                <p>Menampilkan <span class="font-semibold text-gray-600">{{ $pengaduan->count() }}</span> dari
                   <span class="font-semibold text-gray-600">{{ $pengaduan->total() }}</span> data</p>

                @if ($pengaduan->lastPage() > 1)
                    <div class="flex items-center gap-2">
                        <a href="{{ $pengaduan->onFirstPage() ? '#' : $pengaduan->previousPageUrl() }}"
                           class="px-4 py-2 rounded-lg border border-gray-200 text-sm font-medium transition-colors duration-150
                                  {{ $pengaduan->onFirstPage() ? 'text-gray-300 pointer-events-none' : 'text-gray-600 hover:bg-gray-50' }}">
                            &lsaquo; Previous
                        </a>

                        @for ($i = 1; $i <= $pengaduan->lastPage(); $i++)
                            <a href="{{ $pengaduan->url($i) }}"
                               class="w-9 h-9 flex items-center justify-center rounded-lg text-sm font-semibold transition-colors duration-150
                                      {{ $i == $pengaduan->currentPage() ? 'bg-red-600 text-white shadow-sm shadow-red-200' : 'text-gray-500 hover:bg-gray-50' }}">
                                {{ $i }}
                            </a>
                        @endfor

                        <a href="{{ $pengaduan->hasMorePages() ? $pengaduan->nextPageUrl() : '#' }}"
                           class="px-4 py-2 rounded-lg border border-gray-200 text-sm font-medium transition-colors duration-150
                                  {{ $pengaduan->hasMorePages() ? 'text-gray-600 hover:bg-gray-50' : 'text-gray-300 pointer-events-none' }}">
                            Next &rsaquo;
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection