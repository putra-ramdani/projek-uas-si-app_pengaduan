@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-white py-3 border-0">
                    <h4 class="fw-bold mb-0">Buat Pengaduan Fasilitas</h4>
                    <p class="text-muted small mb-0">Pilih fasilitas dan laporkan kerusakan agar segera diperbaiki.</p>
                </div>
                <div class="card-body p-4">
                    
                    <form action="{{ route('user.pengaduan.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <div class="mb-4">
                            <label class="form-label fw-bold mb-2">Pilih Fasilitas yang Rusak</label>
                            <div class="row g-2">
                                @forelse($daftarFasilitas as $fasilitas)
                                    <div class="col-md-6">
                                        <input type="radio" class="btn-check" name="id_fasilitas" 
                                               id="fasilitas_{{ $fasilitas->id_fasilitas }}" 
                                               value="{{ $fasilitas->id_fasilitas }}" required>
                                        
                                        <label class="btn btn-outline-primary text-start w-100 p-3 shadow-sm h-100 border-2" 
                                               for="fasilitas_{{ $fasilitas->id_fasilitas }}">
                                            <div class="fw-bold fs-5 text-dark">{{ $fasilitas->nama_fasilitas }}</div>
                                            <div class="text-muted small mt-1">
                                                <i class="bi bi-geo-alt-fill text-danger"></i> {{ $fasilitas->lokasi }}
                                            </div>
                                        </label>
                                    </div>
                                @empty
                                    <div class="col-12 text-muted small">Tidak ada data fasilitas di database.</div>
                                @endforelse
                            </div>
                            @error('id_fasilitas')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label class="form-label fw-bold mb-2">Kategori Fasilitas</label>
                            <div class="row g-2">
                                @forelse($daftarKategori as $kategori)
                                    <div class="col-md-4">
                                        <input type="radio" class="btn-check" name="id_kategori" 
                                               id="kategori_{{ $kategori->id_kategori }}" 
                                               value="{{ $kategori->id_kategori }}" required>
                                        
                                        <label class="btn btn-outline-secondary text-center w-100 py-3 shadow-sm border-2" 
                                               for="kategori_{{ $kategori->id_kategori }}">
                                            <div class="fw-semibold text-dark">{{ $kategori->nama_kategori }}</div>
                                        </label>
                                    </div>
                                @empty
                                    <div class="col-12 text-muted small">Tidak ada data kategori di database.</div>
                                @endforelse
                            </div>
                            @error('id_kategori')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label class="form-label fw-bold mb-2">Tingkat Urgensi / Prioritas</label>
                            <div class="d-flex gap-3">
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="prioritas" id="rendah" value="rendah">
                                    <label class="form-check-label text-muted" for="rendah">Rendah</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="prioritas" id="sedang" value="sedang" checked>
                                    <label class="form-check-label fw-semibold text-warning" for="sedang">Sedang</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="prioritas" id="tinggi" value="tinggi">
                                    <label class="form-check-label fw-bold text-danger" for="tinggi">Tinggi *</label>
                                </div>
                            </div>
                        </div>

                        <div class="mb-4">
                            <label for="deskripsi_kerusakan" class="form-label fw-bold">Detail Kerusakan (Tulis Deskripsi)</label>
                            <textarea class="form-control @error('deskripsi_kerusakan') is-invalid @enderror" 
                                      name="deskripsi_kerusakan" id="deskripsi_kerusakan" rows="4" 
                                      placeholder="Contoh: AC mengeluarkan suara bising dan air menetes deras sejak pagi ini..." required>{{ old('deskripsi_kerusakan') }}</textarea>
                            @error('deskripsi_kerusakan')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="foto_kerusakan" class="form-label fw-bold">Foto Bukti Kerusakan <span class="text-muted small fw-normal">(Opsional)</span></label>
                            <input class="form-control @error('foto_kerusakan') is-invalid @enderror" type="file" name="foto_kerusakan" id="foto_kerusakan" accept="image/*">
                            <div class="form-text">Format: JPG, JPEG, PNG (Maks. 2MB)</div>
                            @error('foto_kerusakan')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="d-flex justify-content-end gap-2">
                            <a href="{{ route('user.dashboard') }}" class="btn btn-light px-4">Batal</a>
                            <button type="submit" class="btn btn-primary px-4 fw-semibold">Kirim Laporan</button>
                        </div>

                    </form>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection