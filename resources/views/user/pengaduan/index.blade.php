@extends('layouts.app')

@section('content')
<div class="container-fluid p-0">
    <h2 class="fw-bold mb-4">Daftar Riwayat Pengaduan</h2>

    <div class="card border-0 shadow-sm rounded-4 p-4 bg-white">
        <div class="d-flex justify-content-between mb-4 gap-3">
            <div class="input-group style="max-width: 300px;">
                <span class="input-group-text bg-light border-0"><i class="bi bi-search"></i></span>
                <input type="text" class="form-control bg-light border-0" placeholder="Cari...">
            </div>
            <select class="form-select bg-light border-0" style="width: 160px;">
                <option>Semua Status</option>
            </select>
        </div>

        <div class="table-responsive">
            <table class="table align-middle table-hover">
                <thead class="table-light text-secondary">
                    <tr>
                        <th>NO</th>
                        <th>ID TIKET</th>
                        <th>FASILITAS</th>
                        <th>DETAIL KERUSAKAN</th>
                        <th>TANGGAL LAPOR</th>
                        <th>STATUS</th>
                        <th width="100">AKSI</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($complaints as $index => $item)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td class="fw-bold text-dark">{{ $item['tiket'] }}</td>
                        <td class="fw-bold text-dark">{{ $item['fasilitas'] }}</td>
                        <td class="text-muted">{{ $item['deskripsi'] }}</td>
                        <td>{{ $item['tanggal'] }}</td>
                        <td>
                            <span class="badge px-3 py-2 rounded-pill 
                                {{ $item['status'] == 'Baru' ? 'badge-baru' : ($item['status'] == 'Proses' ? 'badge-proses' : 'badge-selesai') }}">
                                {{ $item['status'] }}
                            </span>
                        </td>
                        <td>
                            <a href="#" class="btn btn-sm btn-outline-primary px-3 rounded-3">Detail</a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="d-flex justify-content-end gap-2 mt-4">
            <button class="btn btn-sm btn-light border px-3" disabled><i class="bi bi-chevron-left"></i> Previous</button>
            <button class="btn btn-sm btn-light border px-3">Next <i class="bi bi-chevron-right"></i></button>
        </div>
    </div>
</div>
@endsection