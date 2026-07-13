<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Users\UserController;
use App\Http\Controllers\Users\DashboardController;
use App\Http\Controllers\Admin\LaporanController;
use App\Http\Controllers\Users\ProfileController;
use App\Http\Controllers\Users\ComplaintController;
use App\Http\Controllers\Admin\PengaduanController;

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

// Trik Jitu: Mengalihkan rute /home bawaan Laravel langsung ke /dashboard
// Sekarang, tombol navigasi "Home" atau setelah login akan otomatis membuka halaman dashboard yang sama!
Route::get('/home', function () {
    return redirect()->route('user.dashboard');
})->name('home');

// Grup Rute User & Pengaduan Fasilitas
// Semua route di dalam group ini otomatis berawalan "user."
Route::name('user.')->group(function () {

    // Hasil name route: "user.dashboard"
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Hasil name route: "user.profile.edit" & "user.profile.update"
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');

    // Pengaduan (Sesuai Sidebar)
    // Awalan 'user.' dihapus karena sudah di-handle oleh group di atas
    Route::get('/pengaduan', [ComplaintController::class, 'index'])->name('pengaduan.index');       // Hasil: user.pengaduan.index
    Route::get('/pengaduan/create', [ComplaintController::class, 'create'])->name('pengaduan.create'); // Hasil: user.pengaduan.create
    Route::post('/pengaduan', [ComplaintController::class, 'store'])->name('pengaduan.store');       // Hasil: user.pengaduan.store
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
Route::get('/laporan-pengaduan/export', [LaporanController::class, 'export'])->name('laporan.export');
Route::patch('/laporan-pengaduan/{id}/selesai', [LaporanController::class, 'selesai'])->name('laporan.selesai');
});