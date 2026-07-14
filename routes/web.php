<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Users\DashboardController;
use App\Http\Controllers\Teknisi\TeknisiController;
use App\Http\Controllers\Admin\LaporanController;
use App\Http\Controllers\Users\ProfileController;
use App\Http\Controllers\Users\ComplaintController;
use App\Http\Controllers\Admin\PengaduanController;
use App\Http\Controllers\Teknisi\TeknisiDashboardController;
use App\Http\Controllers\Admin\UserController;

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

// Trik Jitu: Mengalihkan rute /home bawaan Laravel langsung ke /dashboard
// Sekarang, tombol navigasi "Home" atau setelah login akan otomatis membuka halaman dashboard yang sama!
Route::get('/home', function () {
    return redirect()->route('user.dashboard');
})->name('home');

// Semua route di dalam group ini otomatis berawalan "user."
// Grup Rute User
Route::middleware('auth')->name('user.')->group(function () {

    Route::get('/dashboard', [DashboardController::class, 'index'])
        ->name('dashboard');

    Route::get('/profile', [ProfileController::class, 'edit'])
        ->name('profile.edit');

    Route::patch('/profile', [ProfileController::class, 'update'])
        ->name('profile.update');

    Route::get('/pengaduan/create', [ComplaintController::class, 'create'])
        ->name('pengaduan.create');

    Route::post('/pengaduan', [ComplaintController::class, 'store'])
        ->name('pengaduan.store');

    Route::get('/pengaduan/{id}', [ComplaintController::class, 'show'])
        ->name('pengaduan.show');

    Route::get('/pengaduan', [ComplaintController::class, 'index'])
        ->name('pengaduan.index');
    });

// ================= TEKNISI =================

Route::middleware('auth')
    ->name('teknisi.')
    ->group(function () {

        Route::get('/teknisi/dashboard',
            [TeknisiDashboardController::class,'index']
        )->name('dashboard');

    });

// ================= ADMIN =================
// Catatan: sengaja TIDAK dibungkus middleware sesuai ketentuan project ini.
// Semua route di dalam group ini otomatis berawalan "admin."
Route::name('admin.')->group(function () {

    // ===== Daftar Data Pengaduan =====
    Route::get('/data-pengaduan', [PengaduanController::class, 'index'])->name('pengaduan.index');
    Route::get('/data-pengaduan/{id}', [PengaduanController::class, 'show'])->name('pengaduan.show');
    Route::get('/data-pengaduan/{id}/edit', [PengaduanController::class, 'edit'])->name('pengaduan.edit');
    Route::post('/pengaduan/{id}/kirim', [PengaduanController::class, 'kirimFoto'])->name('pengaduan.kirim');
    Route::post('/pengaduan/{id}/batal', [PengaduanController::class, 'batalFoto'])->name('pengaduan.batal');
    Route::get('/laporan-pengaduan', [LaporanController::class, 'index'])->name('laporan.index');
    Route::resource('users', UserController::class);
    
Route::get('/laporan-pengaduan/export', [LaporanController::class, 'export'])->name('laporan.export');
Route::patch('/laporan-pengaduan/{id}/selesai', [LaporanController::class, 'selesai'])->name('laporan.selesai');
});