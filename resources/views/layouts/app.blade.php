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
                        $menu = [
                            [
                                'label' => 'Dashboard',
                                'icon' => 'fa-solid fa-house',
                                'url' => \Illuminate\Support\Facades\Route::has('user.dashboard') ? route('user.dashboard') : '#',
                                'active' => request()->routeIs('user.dashboard'),
                            ],
                            [
                                'label' => 'Ajukan Pengaduan',
                                'icon' => 'fa-solid fa-circle-plus',
                                'url' => \Illuminate\Support\Facades\Route::has('user.pengaduan.create') ? route('user.pengaduan.create') : '#',
                                'active' => request()->routeIs('user.pengaduan.create'),
                            ],
                            [
                                'label' => 'Riwayat Pengaduan',
                                'icon' => 'fa-solid fa-clock-rotate-left',
                                'url' => \Illuminate\Support\Facades\Route::has('user.pengaduan.index') ? route('user.pengaduan.index') : '#',
                                'active' => request()->routeIs('user.pengaduan.index'),
                            ],
                            [
                                'label' => 'Detail Pengaduan',
                                'icon' => 'fa-solid fa-eye',
                                'url' => '#',
                                'active' => request()->routeIs('user.pengaduan.show'),
                            ],
                            [
                                'label' => 'Profil Saya',
                                'icon' => 'fa-solid fa-user',
                                'url' => \Illuminate\Support\Facades\Route::has('user.profile') ? route('user.profile') : '#',
                                'active' => request()->routeIs('user.profile'),
                            ],
                        ];
                    @endphp

                    @foreach ($menu as $item)
                        <a href="{{ $item['url'] }}"
                           class="relative flex items-center gap-3 px-4 py-2.5 rounded-lg text-sm font-medium transition-colors duration-150
                                  {{ $item['active']
                                        ? 'bg-red-50 text-red-600'
                                        : 'text-gray-500 hover:bg-gray-50 hover:text-gray-700' }}">
                            @if ($item['active'])
                                <span class="absolute left-0 top-1/2 -translate-y-1/2 h-5 w-1 rounded-r-full bg-red-600"></span>
                            @endif
                            <i class="{{ $item['icon'] }} w-5 text-center"></i>
                            <span class="flex-1">{{ $item['label'] }}</span>
                        </a>
                    @endforeach
                </nav>
            </div>

            {{-- Logout --}}
            <div class="px-3 py-6 border-t border-gray-100">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit"
                            class="w-full flex items-center gap-3 text-left px-4 py-2.5 rounded-lg text-sm font-medium text-gray-500
                                   hover:bg-red-50 hover:text-red-600 transition-colors duration-150">
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
                    <button type="button"
                            class="relative w-10 h-10 rounded-full bg-gray-50 hover:bg-gray-100 flex items-center justify-center transition-colors duration-150">
                        <i class="fa-solid fa-bell text-gray-500"></i>
                        <span class="absolute top-1.5 right-2 w-2 h-2 rounded-full bg-red-500 ring-2 ring-white"></span>
                    </button>

                    <div class="flex items-center gap-3 pl-5 border-l border-gray-100">
                        <div class="w-10 h-10 rounded-full bg-red-100 flex items-center justify-center text-red-600 font-semibold">
                            {{ substr(auth()->user()->name ?? 'U', 0, 1) }}
                        </div>
                        <div class="text-sm">
                            <p class="font-semibold leading-tight">{{ auth()->user()->name ?? 'Pengguna' }}</p>
                            <p class="text-gray-400 leading-tight">Karyawan Gudang</p>
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