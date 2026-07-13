@extends('layouts.app')

@section('content')
<div class="container mt-4">
    
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm mb-4" role="alert">
            <strong>Berhasil!</strong> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="fw-bold mb-1">Dashboard User</h2>
            <p class="text-muted mb-0">Selamat datang, {{ Auth::user()->name }}!</p>
        </div>
        <div>
            <a href="{{ route('user.pengaduan.create') }}" class="btn btn-primary shadow-sm fw-semibold px-4">
                + Buat Pengaduan
            </a>
        </div>
    </div>

    <div class="row mb-4">
        <div class="col-md-4 mb-3">
            <div class="card shadow-sm border-0">
                <div class="card-body p-4 text-center">
                    <p class="text-muted mb-1">Total Pengaduan</p>
                    <h2 class="fw-bold text-primary mb-0">{{ $totalPengaduan }}</h2>
                </div>
            </div>
        </div>
        <div class="col-md-4 mb-3">
            <div class="card shadow-sm border-0">
                <div class="card-body p-4 text-center">
                    <p class="text-muted mb-1">Pengaduan Baru</p>
                    <h2 class="fw-bold text-warning mb-0">{{ $pengaduanBaru }}</h2>
                </div>
            </div>
        </div>
        <div class="col-md-4 mb-3">
            <div class="card shadow-sm border-0">
                <div class="card-body p-4 text-center">
                    <p class="text-muted mb-1">Selesai</p>
                    <h2 class="fw-bold text-success mb-0">{{ $pengaduanSelesai }}</h2>
                </div>
            </div>
        </div>
    </div>

    <div class="card shadow-sm border-0">
        <div class="card-body p-4">
            <h5 class="fw-bold mb-4">Riwayat Pengaduan Saya</h5>
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th width="5%">No</th>
                            <th width="25%">Fasilitas</th>
                            <th width="40%">Detail Kerusakan</th>
                            <th width="15%">Tanggal</th>
                            <th width="15%">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($daftarPengaduan as $key => $pengaduan)
                            <tr>
                                <td>{{ $key + 1 }}</td>
                                <td>
                                    <span class="fw-semibold">
                                        {{ $pengaduan->fasilitas->nama_fasilitas ?? 'Fasilitas Tidak Diketahui' }}
                                    </span>
                                </td>
                                <td>{{ Str::limit($pengaduan->deskripsi_kerusakan, 60) }}</td>
                                <td>{{ \Carbon\Carbon::parse($pengaduan->tanggal_pengaduan)->format('d M Y') }}</td>
                                <td>
                                    @if($pengaduan->status_pengaduan == 'baru')
                                        <span class="badge bg-primary rounded-pill px-3 py-2">Baru</span>
                                    @elseif($pengaduan->status_pengaduan == 'proses')
                                        <span class="badge bg-warning text-dark rounded-pill px-3 py-2">Proses</span>
                                    @elseif($pengaduan->status_pengaduan == 'selesai')
                                        <span class="badge bg-success rounded-pill px-3 py-2">Selesai</span>
                                    @else
                                        <span class="badge bg-secondary rounded-pill px-3 py-2">{{ $pengaduan->status_pengaduan }}</span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center text-muted py-5">
                                    <p class="mb-0">Belum ada riwayat pengaduan yang dibuat.</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection