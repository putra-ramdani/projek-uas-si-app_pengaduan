@extends('layouts.app')


@section('content')

<div class="container mt-4">

<h3>
Dashboard Teknisi
</h3>

<p>
Selamat datang {{ Auth::user()->name }}
</p>


<table class="table table-bordered">

<thead>

<tr>
<th>No</th>
<th>Fasilitas</th>
<th>Kerusakan</th>
<th>Status</th>
</tr>

</thead>


<tbody>

@foreach($perbaikan as $item)

<tr>

<td>{{ $loop->iteration }}</td>

<td>
{{ $item->pengaduan->fasilitas->nama_fasilitas ?? '-' }}
</td>

<td>
{{ $item->pengaduan->deskripsi_kerusakan ?? '-' }}
</td>

<td>
{{ $item->status_perbaikan }}
</td>

</tr>

@endforeach


</tbody>

</table>


</div>

@endsection