<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulir Pendaftaran</title>
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

        .btn-primary {
            border-radius: 8px;
            font-weight: 500;
        }

        .form-label {
            font-weight: 500;
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
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0">Formulir Pendaftaran</h5>
            </div>
            <div class="card-body">

                <form action="{{ route('capel.pendaftaran.storeStep1') }}" method="POST">
                    @csrf

                    {{-- Nomor Pendaftaran --}}
                    <div class="mb-3">
                        <label for="no_pendaftaran" class="form-label">Nomor Pendaftaran</label>
                        <input type="text" class="form-control" id="no_pendaftaran" name="no_pendaftaran"
                            value="{{ $noPendaftaran ?? old('no_pendaftaran') }}" readonly>
                        <div class="form-text">
                            Nomor pendaftaran dibuat otomatis setiap tahun ajaran baru.
                        </div>
                    </div>

                    {{-- Tanggal Daftar --}}
                    <div class="mb-3">
                        <label for="tanggal_daftar" class="form-label">Tanggal Daftar</label>
                        <input type="date" class="form-control" id="tanggal_daftar" name="tanggal_daftar"
                            value="{{ $tanggalDaftar ?? now()->format('Y-m-d') }}" required>
                    </div>

                    {{-- Kelas Diinginkan --}}
                    <div class="mb-3">
                        <label for="kelas_diinginkan" class="form-label">Kelas Diinginkan</label>
                        <select class="form-select" id="kelas_diinginkan" name="kelas_diinginkan" required>
                            <option value="">Pilih Kelas</option>
                            <option value="Kelas 1 Biasa"
                                {{ old('kelas_diinginkan') == 'Kelas 1 Biasa' ? 'selected' : '' }}>
                                Kelas 1 Biasa
                            </option>
                            <option value="Kelas 1 Pintas"
                                {{ old('kelas_diinginkan') == 'Kelas 1 Pintas' ? 'selected' : '' }}>
                                Kelas 1 Pintas
                            </option>
                        </select>
                    </div>
                    {{-- Nama Lengkap --}}
                    <div class="mb-3">
                        <label for="nama_lengkap" class="form-label">Nama Lengkap</label>
                        <input type="text" class="form-control" id="nama_lengkap" name="nama_lengkap"
                            value="{{ old('nama_lengkap') }}" required>
                    </div>

                    {{-- Tempat Lahir --}}
                    <div class="mb-3">
                        <label for="tempat_lahir" class="form-label">Tempat Lahir</label>
                        <input type="text" class="form-control" id="tempat_lahir" name="tempat_lahir"
                            value="{{ old('tempat_lahir') }}" required>
                    </div>

                    {{-- Tanggal Lahir --}}
                    <div class="mb-3">
                        <label for="tanggal_lahir" class="form-label">Tanggal Lahir</label>
                        <input type="date" class="form-control" id="tanggal_lahir" name="tanggal_lahir"
                            value="{{ old('tanggal_lahir') }}" required>
                    </div>

                    {{-- Alamat Lengkap --}}
                    <div class="mb-3">
                        <label for="alamat_lengkap" class="form-label">Alamat Lengkap</label>
                        <textarea class="form-control" id="alamat_lengkap" name="alamat_lengkap" required>{{ old('alamat_lengkap') }}</textarea>
                    </div>

                    {{-- Sekolah Asal --}}
                    <div class="mb-3">
                        <label for="sekolah_asal" class="form-label">Sekolah Asal</label>
                        <input type="text" class="form-control" id="sekolah_asal" name="sekolah_asal"
                            value="{{ old('sekolah_asal') }}" required>
                    </div>

                    {{-- Alamat Sekolah Asal --}}
                    <div class="mb-3">
                        <label for="alamat_sekolah_asal" class="form-label">Alamat Sekolah Asal</label>
                        <textarea class="form-control" id="alamat_sekolah_asal" name="alamat_sekolah_asal" required>{{ old('alamat_sekolah_asal') }}</textarea>
                    </div>

                    {{-- Submit --}}
                    <div class="text-end">
                        <button type="submit" class="btn btn-primary px-4">
                            Lanjutkan
                        </button>
                    </div>
                </form>

            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
