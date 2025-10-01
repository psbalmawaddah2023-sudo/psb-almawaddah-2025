<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Step 5 - Konfirmasi Pendaftaran</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f4f6f9;
        }

        .card {
            border: none;
            border-radius: 15px;
        }

        .card-header {
            border-radius: 15px 15px 0 0 !important;
        }

        .btn-primary,
        .btn-success,
        .btn-secondary {
            border-radius: 8px;
            font-weight: 500;
        }

        .form-label {
            font-weight: 500;
        }

        /* styling tabel seragam */
        .table th,
        .table td {
            vertical-align: middle;
            text-align: left;
            padding: 10px 15px;
        }

        .table th {
            background-color: #f8f9fa;
            font-weight: 600;
            width: 30%;
        }

        .table td {
            width: 70%;
        }
    </style>
</head>

<body>

    <!-- NAVBAR -->
    <nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm">
        <div class="container">
            <a class="navbar-brand fw-bold text-primary" href="{{ route('capel.dashboard') }}">
                {{ $pengaturan['site_title'] ?? 'Portal Pendaftaran' }}
            </a>
            <div class="collapse navbar-collapse justify-content-center"></div>
            <div class="d-flex">
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="btn btn-primary btn-sm">Logout</button>
                </form>
            </div>
        </div>
    </nav>

    <!-- CONTENT -->
    <div class="container my-5">
        <div class="card shadow-sm">
            <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                <h5 class="mb-0">Step 5 - Konfirmasi Pendaftaran</h5>
                <a href="{{ route('capel.pendaftaran.step5.export', $pendaftaran->id) }}" 
                   class="btn btn-warning btn-sm">Export PDF</a>
            </div>
            <div class="card-body">

                {{-- Catatan revisi dari admin --}}
                <div class="alert alert-warning">
                    <strong>Catatan dari admin:</strong>
                    @if($catatanRevisi)
                        {{ $catatanRevisi }}
                    @else
                        Catatan dari admin akan muncul di sini jika ada yang perlu diubah.
                    @endif
                </div>

                {{-- Status pendaftaran --}}
                <div class="mb-4">
                    <strong>Status Pendaftaran:</strong>
                    <span class="badge bg-info text-dark">{{ ucfirst($pendaftaran->status_pendaftaran) }}</span>
                </div>

                {{-- Tabel data pendaftaran --}}
                <h5>Data Calon Peserta</h5>
                <table class="table table-bordered table-striped mb-4">
                    <tbody>
                        <tr><th>No Pendaftaran</th><td>{{ $pendaftaran->no_pendaftaran }}</td></tr>
                        <tr><th>Tanggal Daftar</th><td>{{ $pendaftaran->tanggal_daftar }}</td></tr>
                        <tr><th>Nama Lengkap</th><td>{{ $pendaftaran->nama_lengkap }}</td></tr>
                        <tr><th>Tempat, Tanggal Lahir</th><td>{{ $pendaftaran->tempat_lahir }}, {{ $pendaftaran->tanggal_lahir }}</td></tr>
                        <tr><th>Alamat Lengkap</th><td>{{ $pendaftaran->alamat_lengkap }}</td></tr>
                        <tr><th>Kelas Diinginkan</th><td>{{ $pendaftaran->kelas_diinginkan }}</td></tr>
                    </tbody>
                </table>

                {{-- Tabel data kontak & identitas --}}
                <h5>Kontak & Identitas</h5>
                <table class="table table-bordered table-striped mb-4">
                    <tbody>
                        <tr><th>Email Orang Tua</th><td>{{ $pendaftaran->email_ortu }}</td></tr>
                        <tr><th>Nomor Telepon</th><td>{{ $pendaftaran->nomor_telepon }}</td></tr>
                        <tr><th>Nomor Whatsapp</th><td>{{ $pendaftaran->nomor_whatsapp }}</td></tr>
                        <tr><th>NIK</th><td>{{ $pendaftaran->nik }}</td></tr>
                        <tr><th>No KK</th><td>{{ $pendaftaran->no_kk }}</td></tr>
                    </tbody>
                </table>

                {{-- Tabel data orang tua --}}
                <h5>Data Orang Tua</h5>
                <table class="table table-bordered table-striped mb-4">
                    <tbody>
                        <tr><th>Nama Ayah</th><td>{{ $pendaftaran->nama_ayah }}</td></tr>
                        <tr><th>NIK Ayah</th><td>{{ $pendaftaran->nik_ayah }}</td></tr>
                        <tr><th>Pekerjaan Ayah</th><td>{{ $pendaftaran->pekerjaan_ayah }}</td></tr>
                        <tr><th>Nama Ibu</th><td>{{ $pendaftaran->nama_ibu }}</td></tr>
                        <tr><th>NIK Ibu</th><td>{{ $pendaftaran->nik_ibu }}</td></tr>
                        <tr><th>Pekerjaan Ibu</th><td>{{ $pendaftaran->pekerjaan_ibu }}</td></tr>
                        <tr><th>Penghasilan Orang Tua</th><td>{{ $pendaftaran->penghasilan_ortu }}</td></tr>
                    </tbody>
                </table>

                {{-- Tabel dokumen --}}
                <h5>Dokumen yang sudah diunggah</h5>
                <table class="table table-bordered table-striped mb-4">
                    <thead class="table-light">
                        <tr>
                            <th style="width: 40%">Jenis Dokumen</th>
                            <th style="width: 40%">Nama File</th>
                            <th style="width: 20%">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if($dokumen && $dokumen->count() > 0)
                            @foreach($dokumen as $dok)
                                <tr>
                                    <td>{{ str_replace('_', ' ', ucfirst($dok->jenis_dokumen)) }}</td>
                                    <td>{{ $dok->nama_file_asli }}</td>
                                    <td>
                                        <a href="{{ asset('storage/' . $dok->path_file) }}" target="_blank" 
                                           class="btn btn-sm btn-primary">Lihat</a>
                                    </td>
                                </tr>
                            @endforeach
                        @else
                            <tr>
                                <td colspan="3" class="text-center">Belum ada dokumen diunggah.</td>
                            </tr>
                        @endif
                    </tbody>
                </table>

                <!-- Tombol navigasi -->
                <div class="d-flex justify-content-between">
                    <!-- Tombol kembali ke Step 4 -->
                    <a href="{{ route('capel.pendaftaran.step4', $pendaftaran->id) }}" 
                       class="btn btn-secondary px-4">Kembali</a>
                    
                    <!-- Tombol konfirmasi -->
                    <form action="{{ route('capel.pendaftaran.konfirmasi', $pendaftaran->id) }}" method="POST">
                        @csrf
                        <button type="submit" class="btn btn-success px-4">Konfirmasi</button>
                    </form>
                </div>

            </div>
        </div>
    </div>
</body>
</html>
