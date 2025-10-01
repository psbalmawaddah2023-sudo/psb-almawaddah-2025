@extends('superadmin.layouts.app')

@section('title', 'Data Admin & Superadmin')

@section('content')
<div class="container">
    <h1>Data User</h1>
    <a href="{{ route('admin.create') }}" class="btn btn-primary mb-3">+ Tambah User</a>

    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>No</th>
                <th>Nama</th>
                <th>Email</th>
                <th>Role</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($users as $user)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ ucwords($user->name) }}</td>
                <td>{{ $user->email }}</td>
                <td>
                    @if ($user->role_id == 1)
                        Capel
                    @elseif ($user->role_id == 2)
                        Admin
                    @else
                    @endif
                </td>
              <td>
    <div class="d-flex flex-wrap gap-1">
        <a href="{{ route('admin.edit', $user->id) }}" class="btn btn-warning btn-sm">Edit</a>

        <form action="{{ route('admin.destroy', $user->id) }}" method="POST" onsubmit="return confirm('Hapus data ini?')">
            @csrf
            @method('DELETE')
            <button class="btn btn-danger btn-sm">Hapus</button>
        </form>

        @if (is_null($user->email_verified_at))
            <form action="{{ route('admin.verify', $user->id) }}" method="POST">
                @csrf
                <button class="btn btn-success btn-sm">Verifikasi</button>
            </form>
        @else
            <span class="badge bg-success align-self-center">Terverifikasi</span>
        @endif
    </div>
</td>


            @empty
            <tr>
                <td colspan="5" class="text-center">Belum terdapat User</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
