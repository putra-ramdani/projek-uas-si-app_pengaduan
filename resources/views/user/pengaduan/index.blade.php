@extends('layouts.app')

@section('content')

<div class="container mt-4">

<h3 class="mb-4">
Riwayat Pengaduan Saya
</h3>


<div class="card shadow-sm">

<div class="card-body">


<table class="table">

<thead>
<tr>
<th>No</th>
<th>Fasilitas</th>
<th>Keluhan</th>
<th>Status</th>
<th>Aksi</th>
</tr>
</thead>


<tbody>

@foreach($daftarPengaduan as $item)

<tr>

<td>{{ $loop->iteration }}</td>

<td>
{{ $item->fasilitas->nama_fasilitas ?? '-' }}
</td>


<td>
{{ Str::limit($item->deskripsi_kerusakan,40) }}
</td>


<td>
{{ ucfirst($item->status_pengaduan) }}
</td>


<td>

<a href="{{ route('user.pengaduan.show',$item->id_pengaduan) }}"
class="btn btn-sm btn-primary">
Detail
</a>

</td>


</tr>

@endforeach


</tbody>


</table>


</div>

</div>


</div>


@endsection