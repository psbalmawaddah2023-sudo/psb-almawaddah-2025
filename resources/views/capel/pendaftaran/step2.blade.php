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
                <h5 class="mb-0">Step 2 - Kontak & Identitas</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('capel.pendaftaran.storeStep2') }}" method="POST">
                    @csrf

                    <div class="mb-3">
                        <label for="nomor_telepon" class="form-label">Nomor Telepon</label>
                        <input type="text" name="nomor_telepon" class="form-control" required
                            value="{{ old('nomor_telepon', $pendaftaran->nomor_telepon ?? '') }}">
                    </div>

                    <div class="mb-3">
                        <label for="nomor_whatsapp" class="form-label">Nomor WhatsApp</label>
                        <input type="text" name="nomor_whatsapp" class="form-control" required
                            value="{{ old('nomor_whatsapp', $pendaftaran->nomor_whatsapp ?? '') }}">
                    </div>

                    <div class="mb-3">
                        <label for="nisn" class="form-label">NISN</label>
                        <input type="text" name="nisn" class="form-control" required
                            value="{{ old('nisn', $pendaftaran->nisn ?? '') }}">
                    </div>

                    <div class="mb-3">
                        <label for="nik" class="form-label">NIK</label>
                        <input type="text" name="nik" class="form-control" required
                            value="{{ old('nik', $pendaftaran->nik ?? '') }}">
                    </div>

                    <div class="mb-3">
                        <label for="no_kk" class="form-label">No KK</label>
                        <input type="text" name="no_kk" class="form-control" required
                            value="{{ old('no_kk', $pendaftaran->no_kk ?? '') }}">
                    </div>

                    {{-- <div class="mb-3">
                        <label for="kip" class="form-label">No KIP</label>
                        <input type="text" name="kip" class="form-control" 
                            value="{{ old('kip', $pendaftaran->kip ?? '') }}">
                    </div> --}}

                    <div class="d-flex justify-content-between">
                        <a href="{{ route('capel.pendaftaran.step1') }}" class="btn btn-secondary px-4">Kembali</a>
                        <button type="submit" class="btn btn-primary px-4">Lanjutkan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>

</html>
