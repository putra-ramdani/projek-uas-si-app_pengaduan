@extends('layouts.app')

@section('content')

<div class="container mt-4">

    <h3 class="mb-4">
        Detail Pengaduan
    </h3>


    <div class="card shadow-sm mb-4">
        <div class="card-body">

            <p>
                <strong>Fasilitas:</strong>
                {{ $pengaduan->fasilitas->nama_fasilitas ?? '-' }}
            </p>


            <p>
                <strong>Lokasi:</strong>
                {{ $pengaduan->fasilitas->lokasi ?? '-' }}
            </p>


            <p>
                <strong>Kategori:</strong>
                {{ $pengaduan->kategoriFasilitas->nama_kategori ?? '-' }}
            </p>


            <p>
                <strong>Keluhan:</strong>
                {{ $pengaduan->deskripsi_kerusakan }}
            </p>


            <p>
                <strong>Prioritas:</strong>
                {{ ucfirst($pengaduan->prioritas) }}
            </p>


            <p>
                <strong>Status:</strong>

                @if($pengaduan->status_pengaduan == 'baru')
                    <span class="badge bg-primary">
                        Baru
                    </span>

                @elseif($pengaduan->status_pengaduan == 'proses')
                    <span class="badge bg-warning">
                        Proses
                    </span>

                @else
                    <span class="badge bg-success">
                        Selesai
                    </span>
                @endif

            </p>

        </div>
    </div>



    <div class="card shadow-sm">

        <div class="card-body">

            <h5>
                Informasi Perbaikan
            </h5>


            @if($pengaduan->perbaikan)

                <p>
                    <strong>Teknisi:</strong>
                    {{ $pengaduan->perbaikan->teknisi->nama_teknisi ?? '-' }}
                </p>


                <p>
                    <strong>Status:</strong>
                    {{ $pengaduan->perbaikan->status_perbaikan }}
                </p>


                <p>
                    <strong>Keterangan:</strong>
                    {{ $pengaduan->perbaikan->deskripsi_perbaikan }}
                </p>


            @else

                <p class="text-muted">
                    Belum ada teknisi yang ditugaskan.
                </p>

            @endif


        </div>

    </div>


</div>


@endsection