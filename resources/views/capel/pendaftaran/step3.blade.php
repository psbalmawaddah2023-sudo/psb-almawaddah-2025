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

        .btn-primary,
        .btn-secondary {
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
                <h5 class="mb-0">Step 3 - Data Orang Tua</h5>
            </div>
            <div class="card-body">
                {{-- Notifikasi sukses/error --}}
                @if (session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            @foreach ($errors->all() as $err)
                                <li>{{ $err }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('capel.pendaftaran.storeStep3', $pendaftaran->id) }}" method="POST">
                    @csrf

                    <div class="mb-3">
                        <label for="email_ortu" class="form-label">Email Orang Tua <span
                                class="text-danger">*</span></label>
                        <input type="email" name="email_ortu" id="email_ortu" class="form-control" required
                            value="{{ old('email_ortu', $pendaftaran->email_ortu ?? '') }}">
                    </div>

                    <div class="row">
                        <!-- Data Ayah -->
                        <div class="col-md-6">
                            <h5 class="mb-3">Data Ayah</h5>
                            <div class="mb-3">
                                <label class="form-label">Nama Ayah</label>
                                <input type="text" name="nama_ayah" class="form-control" required
                                    value="{{ old('nama_ayah', $pendaftaran->nama_ayah ?? '') }}">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">NIK Ayah</label>
                                <input type="text" name="nik_ayah" class="form-control" required
                                    value="{{ old('nik_ayah', $pendaftaran->nik_ayah ?? '') }}">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Pekerjaan Ayah</label>
                                <input type="text" name="pekerjaan_ayah" class="form-control" required
                                    value="{{ old('pekerjaan_ayah', $pendaftaran->pekerjaan_ayah ?? '') }}">
                            </div>
                        </div>

                        <!-- Data Ibu -->
                        <div class="col-md-6">
                            <h5 class="mb-3">Data Ibu</h5>
                            <div class="mb-3">
                                <label class="form-label">Nama Ibu</label>
                                <input type="text" name="nama_ibu" class="form-control" required
                                    value="{{ old('nama_ibu', $pendaftaran->nama_ibu ?? '') }}">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">NIK Ibu</label>
                                <input type="text" name="nik_ibu" class="form-control" required
                                    value="{{ old('nik_ibu', $pendaftaran->nik_ibu ?? '') }}">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Pekerjaan Ibu</label>
                                <input type="text" name="pekerjaan_ibu" class="form-control" required
                                    value="{{ old('pekerjaan_ibu', $pendaftaran->pekerjaan_ibu ?? '') }}">
                            </div>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Penghasilan Orang Tua</label>
                        <input type="text" name="penghasilan_ortu" class="form-control" required
                            value="{{ old('penghasilan_ortu', $pendaftaran->penghasilan_ortu ?? '') }}">
                    </div>

                    <div class="d-flex justify-content-between">
                        <a href="{{ route('capel.pendaftaran.createStep2') }}"
                            class="btn btn-secondary px-4">Kembali</a>
                        <button type="submit" class="btn btn-primary px-4">Lanjutkan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>

</html>
