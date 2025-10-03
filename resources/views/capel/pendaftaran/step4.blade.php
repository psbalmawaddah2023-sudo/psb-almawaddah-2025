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
                <h5 class="mb-0">Step 4 - Upload Dokumen</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('capel.pendaftaran.storeStep4', $pendaftaran->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <!-- Pas Foto -->
                    <div class="mb-3">
                        <label for="pas_foto" class="form-label">Pas Foto 3 X 4</label>
                        <input type="file" name="pas_foto" class="form-control" {{ optional($dokumen)->pas_foto ? '' : 'required' }}>
                        @if(optional($dokumen)->pas_foto)
                            <small class="text-success">Sudah diupload:
                                <a href="{{ asset('storage/app/public'.optional($dokumen)->pas_foto) }}" target="_blank">Lihat</a>
                            </small>
                        @endif
                        @error('pas_foto')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    {{-- <!-- Kartu NISN -->
                    <div class="mb-3">
                        <label for="kartu_nisn" class="form-label">Kartu NISN</label>
                        <input type="file" name="kartu_nisn" class="form-control" {{ optional($dokumen)->kartu_nisn ? '' : 'required' }}>
                        @if(optional($dokumen)->kartu_nisn)
                            <small class="text-success">Sudah diupload:
                                <a href="{{ asset('storage/'.optional($dokumen)->kartu_nisn) }}" target="_blank">Lihat</a>
                            </small>
                        @endif
                        @error('kartu_nisn')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <!-- Akta Kelahiran -->
                    <div class="mb-3">
                        <label for="akta_kelahiran" class="form-label">Akta Kelahiran</label>
                        <input type="file" name="akta_kelahiran" class="form-control" {{ optional($dokumen)->akta_kelahiran ? '' : 'required' }}>
                        @if(optional($dokumen)->akta_kelahiran)
                            <small class="text-success">Sudah diupload:
                                <a href="{{ asset('storage/'.optional($dokumen)->akta_kelahiran) }}" target="_blank">Lihat</a>
                            </small>
                        @endif
                        @error('akta_kelahiran')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <!-- Kartu Keluarga -->
                    <div class="mb-3">
                        <label for="kartu_keluarga" class="form-label">Kartu Keluarga</label>
                        <input type="file" name="kartu_keluarga" class="form-control" {{ optional($dokumen)->kartu_keluarga ? '' : 'required' }}>
                        @if(optional($dokumen)->kartu_keluarga)
                            <small class="text-success">Sudah diupload:
                                <a href="{{ asset('storage/'.optional($dokumen)->kartu_keluarga) }}" target="_blank">Lihat</a>
                            </small>
                        @endif
                        @error('kartu_keluarga')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <!-- Kartu Indonesia Pintar -->
                    <div class="mb-3">
                        <label for="kartu_indonesia_pintar" class="form-label">Kartu Indonesia Pintar</label>
                        <input type="file" name="kartu_indonesia_pintar" class="form-control" {{ optional($dokumen)->kartu_indonesia_pintar ? '' : 'required' }}>
                        @if(optional($dokumen)->kartu_indonesia_pintar)
                            <small class="text-success">Sudah diupload:
                                <a href="{{ asset('storage/'.optional($dokumen)->kartu_indonesia_pintar) }}" target="_blank">Lihat</a>
                            </small>
                        @endif
                        @error('kartu_indonesia_pintar')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <!-- Bukti Transfer -->
                    <div class="mb-3">
                        <label for="bukti_transfer" class="form-label">Bukti Transfer</label>
                        <input type="file" name="bukti_transfer" class="form-control" {{ optional($dokumen)->bukti_transfer ? '' : 'required' }}>
                        @if(optional($dokumen)->bukti_transfer)
                            <small class="text-success">Sudah diupload:
                                <a href="{{ asset('storage/'.optional($dokumen)->bukti_transfer) }}" target="_blank">Lihat</a>
                            </small>
                        @endif
                        @error('bukti_transfer')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div> --}}

                    <!-- Tombol Navigasi -->
                    <div class="d-flex justify-content-between">
                        <a href="{{ route('capel.pendaftaran.step3', $pendaftaran->id) }}" class="btn btn-secondary px-4">Kembali</a>
                        <button type="submit" class="btn btn-primary px-4">Lanjutkan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>

</html>
