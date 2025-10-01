<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Pendaftaran</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f4f6f9;
        }

        .card {
            border-radius: 15px;
        }

        .card-header {
            border-radius: 15px 15px 0 0 !important;
        }

        .label-col {
            font-weight: 600;
        }

        .row-detail {
            margin-bottom: 10px;
        }

        .btn-group-bottom {
            margin-top: 20px;
        }

        .table-responsive {
            margin-top: 10px;
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
        <div class="card shadow-sm p-4">
            <div class="card-header bg-primary text-white mb-3">
                <h5 class="mb-0">Detail Pendaftaran</h5>
            </div>
       
            <div class="mb-3">
    <span class="fw-bold">Catatan dari Admin:</span>
    <p>{{ $catatanRevisi }}</p>
</div>

            <!-- Status -->
            <div class="mb-4">
                <span class="fw-bold">Status Pendaftaran:</span>
                <span class="badge bg-{{ $pendaftaran->status_pendaftaran == 'selesai' ? 'success' : 'secondary' }}">
                    {{ ucfirst($pendaftaran->status_pendaftaran) }}
                </span>
            </div>

            @php
                $fields = [
                    'no_pendaftaran' => 'No Pendaftaran',
                    'tanggal_daftar' => 'Tanggal Daftar',
                    'nama_lengkap' => 'Nama Lengkap',
                    'tempat_lahir' => 'Tempat Lahir',
                    'tanggal_lahir' => 'Tanggal Lahir',
                    'alamat_lengkap' => 'Alamat Lengkap',
                    'kelas_diinginkan' => 'Kelas Diinginkan',
                    'email_ortu' => 'Email Orang Tua',
                    'nomor_telepon' => 'Nomor Telepon',
                    'nomor_whatsapp' => 'Nomor Whatsapp',
                    'nik' => 'NIK',
                    'no_kk' => 'No KK',
                    'nama_ayah' => 'Nama Ayah',
                    'nik_ayah' => 'NIK Ayah',
                    'pekerjaan_ayah' => 'Pekerjaan Ayah',
                    'nama_ibu' => 'Nama Ibu',
                    'nik_ibu' => 'NIK Ibu',
                    'pekerjaan_ibu' => 'Pekerjaan Ibu',
                    'penghasilan_ortu' => 'Penghasilan Orang Tua',
                ];

                $readOnlyFields = ['no_pendaftaran', 'tanggal_daftar'];
            @endphp

            <!-- Loop field per field -->
            @foreach ($fields as $key => $label)
                <div class="row row-detail align-items-center">
                    <div class="col-md-3 label-col">{{ $label }}</div>
                    <div class="col-md-7" id="{{ $key }}_display">
                        {{ $pendaftaran->$key }}
                    </div>
                    <div class="col-md-2">
                        @if (!in_array($key, $readOnlyFields))
                            <button class="btn btn-sm btn-warning"
                                onclick="toggleEdit('{{ $key }}')">Edit</button>
                        @endif
                    </div>
                </div>

                @if (!in_array($key, $readOnlyFields))
                    <form id="{{ $key }}_form"
                        action="{{ route('capel.pendaftaran.update', [$pendaftaran->id]) }}" method="POST"
                        class="d-none row mb-2 align-items-center">
                        @csrf
                        @method('PUT')
                        <input type="hidden" name="field" value="{{ $key }}">
                        <div class="col-md-7">
                            <input type="text" name="value" class="form-control" value="{{ $pendaftaran->$key }}">
                        </div>
                        <div class="col-md-5">
                            <button type="submit" class="btn btn-sm btn-success">Save</button>
                            <button type="button" class="btn btn-sm btn-secondary"
                                onclick="toggleEdit('{{ $key }}')">Cancel</button>
                        </div>
                    </form>
                @endif
            @endforeach

            <!-- Dokumen -->
            <h6 class="mt-4 mb-3">Dokumen yang sudah diunggah</h6>
            <div class="table-responsive">
                <table class="table table-bordered table-striped align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>Jenis Dokumen</th>
                            <th>Nama File</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($dokumen as $doc)
                            <tr>
                                <td>{{ ucwords(str_replace('_', ' ', $doc->jenis_dokumen)) }}</td>
                                <td>{{ $doc->nama_file_asli }}</td>
                                <td class="text-center">
                                    <!-- Tombol Upload Ulang -->
                                    <button type="button" class="btn btn-sm btn-primary" data-bs-toggle="modal"
                                        data-bs-target="#uploadModal{{ $doc->id }}">
                                        Upload Ulang
                                    </button>

                                    <!-- Modal Upload -->
                                    <div class="modal fade" id="uploadModal{{ $doc->id }}" tabindex="-1"
                                        aria-hidden="true">
                                        <div class="modal-dialog">
                                            <form
                                                action="{{ route('capel.pendaftaran.updateDokumen', [$pendaftaran->id, $doc->id]) }}"
                                                method="POST" enctype="multipart/form-data" class="modal-content">
                                                @csrf
                                                @method('PUT')
                                                <div class="modal-header">
                                                    <h5 class="modal-title">
                                                        Upload Ulang
                                                        {{ ucwords(str_replace('_', ' ', $doc->jenis_dokumen)) }}
                                                    </h5>
                                                    <button type="button" class="btn-close"
                                                        data-bs-dismiss="modal"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <input type="file" name="file" class="form-control" required>
                                                </div>

                                                <div class="modal-footer">
                                                    <button type="submit" class="btn btn-success">Simpan</button>
                                                    <button type="button" class="btn btn-secondary"
                                                        data-bs-dismiss="modal">Batal</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>

                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="text-center text-muted">Belum ada dokumen diunggah.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- BUTTONS -->
            <div class="btn-group-bottom d-flex gap-2">
                <a href="{{ route('capel.pendaftaran.step5.export', $pendaftaran->id) }}"
                    class="btn btn-success">Export PDF</a>
                <a href="{{ route('capel.dashboard') }}" class="btn btn-secondary">Kembali ke Dashboard</a>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function toggleEdit(field) {
            const display = document.getElementById(field + '_display');
            const form = document.getElementById(field + '_form');
            display.classList.toggle('d-none');
            form.classList.toggle('d-none');
        }
    </script>
</body>

</html>
