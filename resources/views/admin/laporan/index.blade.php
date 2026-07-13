@extends('admin.layouts.app')

@section('title', 'Laporan Pengaduan')
@section('page-title', 'Daftar Laporan Pengaduan')
@section('page-subtitle', 'Selamat datang, ' . (auth()->user()->name ?? 'Admin'))

@section('content')
<div class="bg-white rounded-2xl shadow-sm">

    {{-- ============ FILTER BAR ============ --}}
    <form method="GET" action="{{ route('admin.laporan.index') }}"
          class="flex flex-wrap items-center gap-3 p-6">

        {{-- Search --}}
        <div class="relative flex-1 min-w-[220px]">
            <i class="fa-solid fa-magnifying-glass absolute left-4 top-1/2 -translate-y-1/2 text-gray-400"></i>
            <input type="text" name="search" value="{{ request('search') }}"
                   placeholder="Cari berdasarkan tanggal, fasilitas..."
                   class="w-full pl-11 pr-4 py-2.5 rounded-xl border border-gray-200 text-sm
                          focus:outline-none focus:ring-2 focus:ring-red-100 focus:border-red-300">
        </div>

        {{-- Pilih Tanggal --}}
        <div class="relative">
            <i class="fa-regular fa-calendar absolute left-4 top-1/2 -translate-y-1/2 text-gray-400 pointer-events-none"></i>
            <input type="date" name="tanggal" value="{{ request('tanggal') }}"
                   class="pl-11 pr-4 py-2.5 rounded-xl border border-gray-200 text-sm text-gray-600
                          focus:outline-none focus:ring-2 focus:ring-red-100 focus:border-red-300">
        </div>

        {{-- Semua Status --}}
        <div class="relative">
            <select name="status" onchange="this.form.submit()"
                    class="appearance-none pl-4 pr-9 py-2.5 rounded-xl border border-gray-200 text-sm text-gray-600
                           focus:outline-none focus:ring-2 focus:ring-red-100 focus:border-red-300">
                <option value="semua" {{ request('status', 'semua') === 'semua' ? 'selected' : '' }}>Semua Status</option>
                <option value="baru" {{ request('status') === 'baru' ? 'selected' : '' }}>Baru</option>
                <option value="proses" {{ request('status') === 'proses' ? 'selected' : '' }}>Proses</option>
                <option value="selesai" {{ request('status') === 'selesai' ? 'selected' : '' }}>Selesai</option>
            </select>
            <i class="fa-solid fa-chevron-down absolute right-3.5 top-1/2 -translate-y-1/2 text-gray-400 text-xs pointer-events-none"></i>
        </div>

        {{-- Export --}}
        <a href="{{ route('admin.laporan.export', request()->query()) }}"
           class="ml-auto inline-flex items-center gap-2 bg-red-600 hover:bg-red-700 text-white text-sm font-semibold
                  px-5 py-2.5 rounded-xl shadow-sm shadow-red-200 transition-colors duration-150">
            <i class="fa-solid fa-download"></i>
            Export
        </a>
    </form>

    {{-- ============ TABLE ============ --}}
    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead>
                <tr class="text-left text-xs font-semibold text-gray-400 border-y border-gray-100 tracking-wide">
                    <th class="px-6 py-3">NO LAPORAN</th>
                    <th class="px-6 py-3">FASILITAS</th>
                    <th class="px-6 py-3">TANGGAL</th>
                    <th class="px-6 py-3">PRIORITAS</th>
                    <th class="px-6 py-3">STATUS</th>
                    <th class="px-6 py-3">AKSI</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($laporan as $item)
                    @php
                        $prioritasStyle = match ($item->prioritas) {
                            'tinggi' => 'bg-red-50 text-red-600',
                            'sedang' => 'bg-yellow-50 text-yellow-700',
                            'rendah' => 'bg-green-50 text-green-700',
                            default  => 'bg-gray-50 text-gray-600',
                        };

                        $statusStyle = match ($item->status_pengaduan) {
                            'baru'    => 'bg-blue-50 text-blue-600',
                            'proses'  => 'bg-yellow-50 text-yellow-700',
                            'selesai' => 'bg-green-50 text-green-700',
                            default   => 'bg-gray-50 text-gray-600',
                        };
                    @endphp
                    <tr class="border-b border-gray-50 hover:bg-gray-50/60 transition-colors duration-150">
                        <td class="px-6 py-4 font-semibold text-gray-700">{{ sprintf('65%03d', $item->id) }}</td>
                        <td class="px-6 py-4 text-gray-600">{{ $item->fasilitas->nama_fasilitas ?? '-' }}</td>
                        <td class="px-6 py-4 text-gray-500">{{ optional($item->created_at)->translatedFormat('d M Y') }}</td>
                        <td class="px-6 py-4">
                            <span class="px-3 py-1 rounded-full text-xs font-semibold {{ $prioritasStyle }}">
                                {{ ucfirst($item->prioritas) }}
                            </span>
                        </td>
                        <td class="px-6 py-4">
                            <span class="px-3 py-1 rounded-full text-xs font-semibold {{ $statusStyle }}">
                                {{ ucfirst($item->status_pengaduan) }}
                            </span>
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-2">
                                <a href="{{ route('admin.laporan.index') }}"
                                   class="inline-flex items-center gap-1 bg-yellow-50 hover:bg-yellow-100 text-yellow-700
                                          text-xs font-semibold px-3 py-1.5 rounded-lg transition-colors duration-150">
                                    <i class="fa-solid fa-pen text-[11px]"></i> Edit
                                </a>

                                @if ($item->status_pengaduan !== 'selesai')
                                    <form method="POST" action="{{ route('admin.laporan.selesai', $item->id) }}">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit"
                                                class="inline-flex items-center gap-1 bg-green-50 hover:bg-green-100 text-green-700
                                                       text-xs font-semibold px-3 py-1.5 rounded-lg transition-colors duration-150">
                                            <i class="fa-solid fa-circle-check text-[11px]"></i> Selesai
                                        </button>
                                    </form>
                                @else
                                    <span class="inline-flex items-center gap-1 bg-green-50 text-green-700
                                                 text-xs font-semibold px-3 py-1.5 rounded-lg opacity-60 cursor-not-allowed">
                                        <i class="fa-solid fa-circle-check text-[11px]"></i> Selesai
                                    </span>
                                @endif
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="px-6 py-10 text-center text-gray-400">
                            Belum ada data laporan pengaduan.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- ============ FOOTER: INFO + CUSTOM PAGINATION ============ --}}
    <div class="flex items-center justify-between px-6 py-5">
        <p class="text-sm text-gray-400">
            Menampilkan {{ $laporan->firstItem() ?? 0 }} - {{ $laporan->lastItem() ?? 0 }} data
        </p>

        <div class="flex items-center gap-2">
            {{-- Previous --}}
            @if ($laporan->onFirstPage())
                <span class="inline-flex items-center gap-1 px-3 py-1.5 rounded-lg border border-gray-200 text-gray-300 text-sm cursor-not-allowed">
                    <i class="fa-solid fa-chevron-left text-xs"></i> Previous
                </span>
            @else
                <a href="{{ $laporan->previousPageUrl() }}"
                   class="inline-flex items-center gap-1 px-3 py-1.5 rounded-lg border border-gray-200 text-gray-500 text-sm hover:bg-gray-50">
                    <i class="fa-solid fa-chevron-left text-xs"></i> Previous
                </a>
            @endif

            {{-- Page numbers --}}
            @for ($page = 1; $page <= $laporan->lastPage(); $page++)
                @if ($page === $laporan->currentPage())
                    <span class="w-8 h-8 flex items-center justify-center rounded-full bg-red-600 text-white text-sm font-semibold">
                        {{ $page }}
                    </span>
                @else
                    <a href="{{ $laporan->url($page) }}"
                       class="w-8 h-8 flex items-center justify-center rounded-full text-gray-500 text-sm hover:bg-gray-50">
                        {{ $page }}
                    </a>
                @endif
            @endfor

            {{-- Next --}}
            @if ($laporan->hasMorePages())
                <a href="{{ $laporan->nextPageUrl() }}"
                   class="inline-flex items-center gap-1 px-3 py-1.5 rounded-lg border border-gray-200 text-gray-500 text-sm hover:bg-gray-50">
                    Next <i class="fa-solid fa-chevron-right text-xs"></i>
                </a>
            @else
                <span class="inline-flex items-center gap-1 px-3 py-1.5 rounded-lg border border-gray-200 text-gray-300 text-sm cursor-not-allowed">
                    Next <i class="fa-solid fa-chevron-right text-xs"></i>
                </span>
            @endif
        </div>
    </div>
</div>
@endsection