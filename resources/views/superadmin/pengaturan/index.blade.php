@extends('superadmin.layouts.app')

@section('title', 'Daftar Pengaturan')

@section('content')
    <div class="container">
        <h1 class="mb-4">Daftar Pengaturan</h1>

        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th style="width: 5%">No</th>
                    <th style="width: 25%">Nama Pengaturan</th>
                    <th style="width: 45%">Isi (Value)</th>
                    <th style="width: 15%" class="text-center">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($pengaturans as $id => $pengaturan)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ ucwords(str_replace('_', ' ', $pengaturan['key'])) }}</td>
                        <td>
                            @php
                                $value = $pengaturan['value'];
                            @endphp

                            @if (is_string($value) && strlen($value) > 50)
                                {{ \Illuminate\Support\Str::limit($value, 50) }}
                            @else
                                {{ $value ?? '-' }}
                            @endif
                        </td>
                        <td class="text-center">
                            <a href="{{ route('pengaturan.edit', $id) }}" class="btn btn-warning btn-sm">
                                <i class="bi bi-pencil-square"></i> Edit
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4">Tidak ada data</td>
                    </tr>
                @endforelse


            </tbody>
        </table>
    </div>
@endsection
