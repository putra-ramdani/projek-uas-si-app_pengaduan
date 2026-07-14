<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Sistem Informasi Fasilitas') — Alfamart</title>
    <link rel="icon" href="data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 100 100'%3E%3Crect width='100' height='100' rx='22' fill='%23DC2626'/%3E%3Ctext x='50' y='68' font-size='58' font-family='Arial, sans-serif' font-weight='bold' fill='white' text-anchor='middle'%3EA%3C/text%3E%3C/svg%3E">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"
          integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA=="
          crossorigin="anonymous" referrerpolicy="no-referrer">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-50 text-gray-800 antialiased">
    <div class="flex min-h-screen">

        {{-- ============ SIDEBAR ============ --}}
        <aside class="w-72 bg-white border-r border-gray-100 flex flex-col justify-between shadow-[1px_0_0_0_rgba(0,0,0,0.02)]">
            <div>
                {{-- Logo --}}
                <div class="flex items-center gap-3 px-6 py-6 border-b border-gray-100">
                    <div class="w-10 h-10 rounded-xl bg-red-600 text-white flex items-center justify-center font-bold text-lg shadow-sm shadow-red-200">A</div>
                    <div>
                        <p class="font-semibold leading-tight tracking-tight">Alfamart</p>
                        <p class="text-xs text-gray-400 leading-tight">Pengaduan Fasilitas Gudang</p>
                    </div>
                </div>

                {{-- Menu --}}
                <nav class="mt-4 flex flex-col gap-0.5 px-3">
                    @php
                        $user = auth()->user();
                    @endphp

                    @if($user && $user->role === 'admin')
                        {{-- ================= MENU KHUSUS ADMIN ================= --}}
                        <a href="{{ route('admin.pengaduan.index') }}" 
                           class="relative flex items-center gap-3 px-4 py-2.5 rounded-lg text-sm font-medium transition-colors duration-150 {{ request()->routeIs('admin.pengaduan.index') ? 'bg-red-50 text-red-600' : 'text-gray-500 hover:bg-gray-50 hover:text-gray-700' }}">
                            @if(request()->routeIs('admin.pengaduan.index'))
                                <span class="absolute left-0 top-1/2 -translate-y-1/2 h-5 w-1 rounded-r-full bg-red-600"></span>
                            @endif
                            <i class="fa-solid fa-list-check w-5 text-center"></i>
                            <span class="flex-1">Data Pengaduan</span>
                        </a>

                        {{-- PERBAIKAN: DETAIL PENGADUAN ADMIN --}}
                        @if(request()->routeIs('admin.pengaduan.show') && request()->route('id'))
                            <a href="{{ route('admin.pengaduan.show', request()->route('id')) }}" 
                               class="relative flex items-center gap-3 px-4 py-2.5 rounded-lg text-sm font-medium bg-red-50 text-red-600 transition-colors duration-150">
                                <span class="absolute left-0 top-1/2 -translate-y-1/2 h-5 w-1 rounded-r-full bg-red-600"></span>
                                <i class="fa-solid fa-eye w-5 text-center"></i>
                                <span class="flex-1">Detail Pengaduan</span>
                            </a>
                        @else
                            <div class="flex items-center gap-3 px-4 py-2.5 rounded-lg text-sm font-medium text-gray-300 cursor-not-allowed opacity-60">
                                <i class="fa-solid fa-eye w-5 text-center"></i>
                                <span class="flex-1">Detail Pengaduan</span>
                            </div>
                        @endif

                        <a href="{{ route('admin.laporan.index') }}" 
                           class="relative flex items-center gap-3 px-4 py-2.5 rounded-lg text-sm font-medium transition-colors duration-150 {{ request()->routeIs('admin.laporan.*') ? 'bg-red-50 text-red-600' : 'text-gray-500 hover:bg-gray-50 hover:text-gray-700' }}">
                            @if(request()->routeIs('admin.laporan.*'))
                                <span class="absolute left-0 top-1/2 -translate-y-1/2 h-5 w-1 rounded-r-full bg-red-600"></span>
                            @endif
                            <i class="fa-solid fa-chart-column w-5 text-center"></i>
                            <span class="flex-1">Laporan Pengaduan</span>
                        </a>

                    @else
                        {{-- ================= MENU KHUSUS USER ================= --}}
                        <a href="{{ route('user.dashboard') }}" 
                           class="relative flex items-center gap-3 px-4 py-2.5 rounded-lg text-sm font-medium transition-colors duration-150 {{ request()->routeIs('user.dashboard') ? 'bg-red-50 text-red-600' : 'text-gray-500 hover:bg-gray-50 hover:text-gray-700' }}">
                            @if(request()->routeIs('user.dashboard'))
                                <span class="absolute left-0 top-1/2 -translate-y-1/2 h-5 w-1 rounded-r-full bg-red-600"></span>
                            @endif
                            <i class="fa-solid fa-house w-5 text-center"></i>
                            <span class="flex-1">Dashboard</span>
                        </a>

                        <a href="{{ route('user.pengaduan.create') }}" 
                           class="relative flex items-center gap-3 px-4 py-2.5 rounded-lg text-sm font-medium transition-colors duration-150 {{ request()->routeIs('user.pengaduan.create') ? 'bg-red-50 text-red-600' : 'text-gray-500 hover:bg-gray-50 hover:text-gray-700' }}">
                            @if(request()->routeIs('user.pengaduan.create'))
                                <span class="absolute left-0 top-1/2 -translate-y-1/2 h-5 w-1 rounded-r-full bg-red-600"></span>
                            @endif
                            <i class="fa-solid fa-flag w-5 text-center"></i>
                            <span class="flex-1">Ajukan Pengaduan</span>
                        </a>

                        <a href="{{ route('user.sw.index') }}" 
                           class="relative flex items-center gap-3 px-4 py-2.5 rounded-lg text-sm font-medium transition-colors duration-150 {{ request()->routeIs('user.pengaduan.index') ? 'bg-red-50 text-red-600' : 'text-gray-500 hover:bg-gray-50 hover:text-gray-700' }}">
                            @if(request()->routeIs('user.pengaduan.index'))
                                <span class="absolute left-0 top-1/2 -translate-y-1/2 h-5 w-1 rounded-r-full bg-red-600"></span>
                            @endif
                            <i class="fa-solid fa-file-lines w-5 text-center"></i>
                            <span class="flex-1">Riwayat Pengaduan</span>
                        </a>
                        
                        {{-- ================= DETAIL PENGADUAN ================= --}}
                        @if(request()->routeIs('user.pengaduan.show'))
                            <a href="{{ route('user.pengaduan.show', request()->route('id')) }}"
                            class="relative flex items-center gap-3 px-4 py-2.5 rounded-lg text-sm font-medium bg-red-50 text-red-600">
                                <span class="absolute left-0 top-1/2 -translate-y-1/2 h-5 w-1 rounded-r-full bg-red-600"></span>
                                <i class="fa-solid fa-eye w-5 text-center"></i>
                                <span class="flex-1">Detail Pengaduan</span>
                            </a>
                        @endif

                        {{-- ================= PROFIL SAYA ================= --}}
                        <a href="{{ route('user.profil.edit') }}"
                        class="relative flex items-center gap-3 px-4 py-2.5 rounded-lg text-sm font-medium transition-colors duration-150 {{ request()->routeIs('user.profil.*') ? 'bg-red-50 text-red-600' : 'text-gray-500 hover:bg-gray-50 hover:text-gray-700' }}">
                            @if(request()->routeIs('user.profil.*'))
                                <span class="absolute left-0 top-1/2 -translate-y-1/2 h-5 w-1 rounded-r-full bg-red-600"></span>
                            @endif
                            <i class="fa-solid fa-user w-5 text-center"></i>
                            <span class="flex-1">Profil Saya</span>
                        </a>
                    @endif
                </nav>
            </div>

            {{-- Logout --}}
            <div class="px-3 py-6 border-t border-gray-100">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit"
                            class="w-full flex items-center gap-3 text-left px-4 py-2.5 rounded-lg text-sm font-medium text-gray-500 hover:bg-red-50 hover:text-red-600 transition-colors duration-150">
                        <i class="fa-solid fa-right-from-bracket w-5 text-center"></i>
                        Keluar
                    </button>
                </form>
            </div>
        </aside>

        {{-- ============ MAIN ============ --}}
        <div class="flex-1 flex flex-col">

            {{-- Header --}}
            <header class="flex items-center justify-between bg-white border-b border-gray-100 px-8 py-5">
                <div>
                    <h1 class="text-xl font-bold tracking-tight">@yield('page-title')</h1>
                    <p class="text-sm text-gray-400">@yield('page-subtitle', 'Sistem Informasi Fasilitas — Alfamart')</p>
                </div>

                <div class="flex items-center gap-5">
                    <button type="button" class="relative w-10 h-10 rounded-full bg-gray-50 hover:bg-gray-100 flex items-center justify-center transition-colors duration-150">
                        <i class="fa-solid fa-bell text-gray-500"></i>
                        <span class="absolute top-1.5 right-2 w-2 h-2 rounded-full bg-red-500 ring-2 ring-white"></span>
                    </button>

                    <div class="flex items-center gap-3 pl-5 border-l border-gray-100">
                        <div class="w-10 h-10 rounded-full bg-red-100 flex items-center justify-center text-red-600 font-semibold">
                            {{ substr(auth()->user()->name ?? 'A', 0, 1) }}
                        </div>
                        <div class="text-sm">
                            <p class="font-semibold leading-tight">{{ auth()->user()->name ?? 'User' }}</p>
                            <p class="text-gray-400 leading-tight">
                                {{ $user && $user->role === 'admin' ? 'Administrator' : 'Karyawan Gudang' }}
                            </p>
                        </div>
                    </div>
                </div>
            </header>

            {{-- Content --}}
            <main class="p-8">
                @if (session('success'))
                    <div class="mb-4 rounded-xl bg-green-50 border border-green-100 text-green-700 text-sm px-4 py-3">
                        {{ session('success') }}
                    </div>
                @endif

                @yield('content')
            </main>
        </div>
    </div>
</body>
</html>