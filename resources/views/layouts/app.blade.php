<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Alfamart - Pengaduan Fasilitas Gudang</title>

    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">

    @vite(['resources/sass/app.scss', 'resources/js/app.js'])

    <style>
        body { background-color: #f8f9fa; font-family: 'Nunito', sans-serif; }
        .sidebar { height: 100vh; background: #fff; border-right: 1px solid #dee2e6; position: fixed; width: 260px; display: flex; flex-direction: column; justify-content: space-between; padding-bottom: 20px; z-index: 1000;}
        .main-content { margin-left: 260px; padding: 30px; width: calc(100% - 260px); min-height: 100vh;}
        .logo-box { background: #e41c24; color: white; width: 40px; height: 40px; border-radius: 8px; display: flex; align-items: center; justify-content: center; font-weight: bold; font-size: 20px; }
        .nav-link-custom { color: #6c757d; font-weight: 500; padding: 12px 20px; border-radius: 8px; margin: 4px 15px; display: flex; align-items: center; gap: 10px; text-decoration: none;}
        .nav-link-custom:hover, .nav-link-custom.active { background: #fff5f5; color: #e41c24; }
        .badge-baru { background-color: #e3effd; color: #176cc6; border: none; }
        .badge-proses { background-color: #fff3cd; color: #856404; border: none; }
        .badge-selesai { background-color: #d4edda; color: #155724; border: none; }
        
        /* Penyesuaian form input agar rapi seperti desain */
        .style-file::file-selector-button { background-color: #f8f9fa; border: 1px solid #dee2e6; border-radius: 4px; padding: 5px 10px; color: #e41c24; font-weight: 500;}
    </style>
</head>
<body>
    <div id="app">

        @guest
            <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
                <div class="container">
                    <a class="navbar-brand text-danger fw-bold" href="{{ url('/') }}">
                        Alfamart
                    </a>
                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                        <span class="navbar-toggler-icon"></span>
                    </button>

                    <div class="collapse navbar-collapse" id="navbarSupportedContent">
                        <ul class="navbar-nav me-auto"></ul>
                        <ul class="navbar-nav ms-auto">
                            @if (Route::has('login'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                                </li>
                            @endif
                            @if (Route::has('register'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                                </li>
                            @endif
                        </ul>
                    </div>
                </div>
            </nav>

            <main class="py-4">
                @yield('content')
            </main>
        @endguest


        @auth
            <div class="d-flex">
                <div class="sidebar shadow-sm">
                    <div>
                        <div class="d-flex align-items-center gap-3 p-4 border-bottom mb-3">
                            <div class="logo-box">A</div>
                            <div>
                                <h6 class="mb-0 fw-bold text-dark">Alfamart</h6>
                                <small class="text-muted" style="font-size: 11px;">Pengaduan Fasilitas Gudang</small>
                            </div>
                        </div>
                        <div class="nav flex-column">
                            <a class="nav-link-custom {{ Route::is('user.dashboard') ? 'active' : '' }}" href="{{ route('user.dashboard') }}">
                                <i class="bi bi-house-door-fill"></i> Dashboard
                            </a>
                            <a class="nav-link-custom {{ Route::is('user.pengaduan.create') ? 'active' : '' }}" href="{{ route('user.pengaduan.create') }}">
                                <i class="bi bi-file-earmark-plus-fill"></i> Buat Pengaduan
                            </a>
                            <a class="nav-link-custom {{ Route::is('user.pengaduan.index') ? 'active' : '' }}" href="{{ route('user.pengaduan.index') }}">
                                <i class="bi bi-archive-fill"></i> Riwayat Pengaduan
                            </a>
                        </div>
                    </div>
                    
                    <div class="px-3">
                        <a class="nav-link-custom text-danger border-top pt-3" href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                            <i class="bi bi-box-arrow-left"></i> Keluar
                        </a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                            @csrf
                        </form>
                    </div>
                </div>

                <div class="main-content bg-light">
                    <div class="d-flex justify-content-between align-items-center mb-4 bg-white p-3 rounded-4 shadow-sm border">
                        <h5 class="mb-0 fw-bold text-secondary fs-6">Sistem Informasi Fasilitas &mdash; Alfamart</h5>
                        <div class="d-flex align-items-center gap-3">
                            <i class="bi bi-bell text-secondary fs-5"></i>
                            <div class="d-flex align-items-center gap-2">
                                <i class="bi bi-person-circle fs-4 text-danger"></i>
                                <span class="fw-semibold text-dark">{{ Auth::user()->name ?? 'Pengguna' }}</span>
                            </div>
                        </div>
                    </div>

                    @yield('content')
                </div>
            </div>
        @endauth
        
    </div>
</body>
</html>