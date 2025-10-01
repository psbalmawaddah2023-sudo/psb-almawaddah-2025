@extends('superadmin.layouts.app')

@section('content')
    <div class="container">
        <h1>Data Pendaftaran</h1>
        <a href="{{ route('pendaftaran.create') }}" class="btn btn-primary mb-3">+ Tambah Pendaftaran</a>

        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>No Pendaftaran</th>
                    <th>Nama Lengkap</th>
                    <th>Kelas</th>
                    <th>Tanggal Daftar</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($pendaftarans as $p)
                    <tr>
                        <td>{{ $p->no_pendaftaran }}</td>
                        <td>{{ ucwords($p->nama_lengkap) }}</td>
                        <td>{{ $p->kelas_diinginkan }}</td>
                        <td>{{ \Carbon\Carbon::parse($p->tanggal_daftar)->format('d M Y') }}</td>
                        <td>{{ ucwords($p->status_pendaftaran) }}</td>
                        <td>
                            <div class="d-flex flex-wrap gap-1">
                                <a href="{{ route('pendaftaran.show', $p->id) }}" class="btn btn-info btn-sm">Detail</a>
                                <a href="{{ route('pendaftaran.edit', $p->id) }}" class="btn btn-warning btn-sm">Edit</a>
                                <form action="{{ route('pendaftaran.destroy', $p->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button onclick="return confirm('Hapus data ini?')"
                                        class="btn btn-danger btn-sm">Hapus</button>
                                </form>
                            </div>

                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="9" class="text-center">Belum ada data pendaftaran</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
@endsection
