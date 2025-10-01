@extends('superadmin.layouts.app')

@section('title', 'Laporan Pendaftar Capel')

@section('content')
<div class="container">
    <h1 class="mb-4">Laporan Pendaftar Capel</h1>

    <div class="mb-3">
        <a href="{{ route('laporan.capel.excel') }}" class="btn btn-success">Export Excel</a>
        <a href="{{ route('laporan.capel.pdf') }}" class="btn btn-danger">Export PDF</a>
    </div>

    <div class="card mb-4">
        <div class="card-body">
            <h5>Total Pendaftar: <strong>{{ $total }}</strong></h5>

            <h6 class="mt-3">Rekap Per Kelas:</h6>
            <ul>
                @foreach($perKelas as $kelas)
                    <li>{{ $kelas->kelas_diinginkan }} : <strong>{{ $kelas->jumlah }}</strong></li>
                @endforeach
            </ul>
        </div>
    </div>

    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>No</th>
                <th>No Pendaftaran</th>
                <th>Nama Lengkap</th>
                <th>Kelas</th>
                <th>Tanggal Daftar</th>
            </tr>
        </thead>
        <tbody>
            @forelse($pendaftarans as $p)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $p->no_pendaftaran }}</td>
                <td>{{ ucwords($p->nama_lengkap) }}</td>
                <td>{{ $p->kelas_diinginkan }}</td>
                <td>{{ \Carbon\Carbon::parse($p->tanggal_daftar)->format('d M Y') }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="6" class="text-center">Belum ada data</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
