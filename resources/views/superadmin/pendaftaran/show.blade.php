@extends('superadmin.layouts.app')

@section('content')
<div class="container-fluid">
    <h3 class="fw-bold mb-4">📄 Detail Pendaftaran</h3>

    <div class="row g-3">
        <!-- Data Siswa -->
        <div class="col-12 col-md-6 col-lg-6">
            <div class="card shadow-sm border-0 rounded-3 h-100">
                <div class="card-header bg-primary text-white fw-semibold">
                    🧑‍🎓 Data Siswa
                </div>
                <div class="card-body">
                    <p><strong>No Pendaftaran:</strong> {{ $pendaftaran->no_pendaftaran }}</p>
                    <p><strong>Nama Lengkap:</strong> {{ $pendaftaran->nama_lengkap }}</p>
                    <p><strong>User:</strong> {{ $pendaftaran->user->name ?? '-' }} ({{ $pendaftaran->user->email ?? '-' }})</p>
                    <p><strong>Kelas Diinginkan:</strong> {{ $pendaftaran->kelas_diinginkan }}</p>
                    <p><strong>Tanggal Daftar:</strong> {{ \Carbon\Carbon::parse($pendaftaran->daftar)->translatedFormat('d M Y') }}</p>
                    <p><strong>Tempat Lahir:</strong> {{ $pendaftaran->tempat_lahir }}</p>
                    <p><strong>Tanggal Lahir:</strong> {{ \Carbon\Carbon::parse($pendaftaran->tanggal_lahir)->translatedFormat('d M Y') }}</p>
                    <p><strong>Alamat Lengkap:</strong> {{ $pendaftaran->alamat_lengkap }}</p>
                    <p><strong>Sekolah Asal:</strong> {{ $pendaftaran->sekolah_asal }}</p>
                    <p><strong>Alamat Sekolah Asal:</strong> {{ $pendaftaran->alamat_sekolah_asal }}</p>
                    <p><strong>Email Orang Tua:</strong> {{ $pendaftaran->email_ortu }}</p>
                </div>
            </div>
        </div>

        <!-- Data Kontak & Identitas -->
        <div class="col-12 col-md-6 col-lg-6">
            <div class="card shadow-sm border-0 rounded-3 h-100">
                <div class="card-header bg-info text-white fw-semibold">
                    📞 Data Kontak & Identitas
                </div>
                <div class="card-body">
                    <p><strong>Nomor Telepon:</strong> {{ $pendaftaran->nomor_telepon }}</p>
                    <p><strong>Nomor WhatsApp:</strong> {{ $pendaftaran->nomor_whatsapp }}</p>
                    <p><strong>NISN:</strong> {{ $pendaftaran->nisn }}</p>
                    <p><strong>No KIP:</strong> {{ $pendaftaran->kip }}</p>
                    <p><strong>NIK:</strong> {{ $pendaftaran->nik }}</p>
                    <p><strong>No KK:</strong> {{ $pendaftaran->no_kk }}</p>
                </div>
            </div>
        </div>

        <!-- Data Orang Tua -->
        <div class="col-12 col-md-6 col-lg-6">
            <div class="card shadow-sm border-0 rounded-3 h-100">
                <div class="card-header bg-success text-white fw-semibold">
                    👨‍👩‍👧 Data Orang Tua
                </div>
                <div class="card-body">
                    <p><strong>Nama Ayah:</strong> {{ $pendaftaran->nama_ayah }}</p>
                    <p><strong>NIK Ayah:</strong> {{ $pendaftaran->nik_ayah }}</p>
                    <p><strong>Pekerjaan Ayah:</strong> {{ $pendaftaran->pekerjaan_ayah }}</p>
                    <hr>
                    <p><strong>Nama Ibu:</strong> {{ $pendaftaran->nama_ibu }}</p>
                    <p><strong>NIK Ibu:</strong> {{ $pendaftaran->nik_ibu }}</p>
                    <p><strong>Pekerjaan Ibu:</strong> {{ $pendaftaran->pekerjaan_ibu }}</p>
                    <p><strong>Penghasilan Orang Tua:</strong> Rp {{ number_format($pendaftaran->penghasilan_ortu,0,',','.') }}</p>
                </div>
            </div>
        </div>

        <!-- Status Pendaftaran -->
        <div class="col-12 col-md-6 col-lg-6">
            <div class="card shadow-sm border-0 rounded-3 h-100">
                <div class="card-header bg-warning fw-semibold">
                    📑 Status Pendaftaran
                </div>
                <div class="card-body">
                    <p><strong>Status:</strong>
                        <span class="badge bg-{{ $pendaftaran->status_pendaftaran == 'Diterima' ? 'success' : 'secondary' }}">
                            {{ ucfirst($pendaftaran->status_pendaftaran) }}
                        </span>
                    </p>
                    <p><strong>Catatan Revisi:</strong> {{ $pendaftaran->catatan_revisi ?? '-' }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Dokumen Pendaftaran -->
    <div class="card shadow-sm border-0 rounded-3 mt-4">
        <div class="card-header bg-dark text-white fw-semibold">
            📂 Dokumen Pendaftaran
        </div>
        <div class="card-body">
            <form action="{{ route('dokumen.store', $pendaftaran->id) }}" method="POST" enctype="multipart/form-data" class="row g-2 align-items-center mb-3">
                @csrf
                <div class="col-12 col-md-4">
                    <select name="jenis_dokumen" class="form-select" required>
                        <option value="">Pilih Jenis Dokumen</option>
                        <option value="pas_foto">Pas Foto 3x4</option>
                        <option value="kartu_nisn">Kartu NISN</option>
                        <option value="akta_kelahiran">Akta Kelahiran</option>
                        <option value="kartu_keluarga">Kartu Keluarga</option>
                        <option value="kartu_indonesia_pintar">Kartu Indonesia Pintar</option>
                        <option value="bukti_transfer">Bukti Transfer</option>
                    </select>
                </div>
                <div class="col-12 col-md-5">
                    <input type="file" name="file" class="form-control" required>
                </div>
                <div class="col-12 col-md-3">
                    <button type="submit" class="btn btn-success w-100">Upload</button>
                </div>
            </form>

            <!-- Tabel Dokumen -->
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>Jenis Dokumen</th>
                            <th>Nama File</th>
                            <th>Preview</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($pendaftaran->dokumens as $dokumen)
                            <tr>
                                @php
                                    $jenis = Str::title(str_replace('_', ' ', $dokumen->jenis_dokumen));
                                    $mapping = ['Nisn' => 'NISN', 'Ktp' => 'KTP'];
                                    $jenis = str_replace(array_keys($mapping), array_values($mapping), $jenis);
                                @endphp
                                <td>{{ $jenis }}</td>
                                <td>{{ $dokumen->nama_file_asli }}</td>
                                <td>
                                    @if(Str::contains($dokumen->mime_type, 'image'))
                                        <img src="{{ asset('storage/' . $dokumen->path_file) }}" alt="Preview" class="img-thumbnail" width="100">
                                    @else
                                        <a href="{{ asset('storage/' . $dokumen->path_file) }}" target="_blank" class="btn btn-sm btn-outline-primary">Lihat File</a>
                                    @endif
                                </td>
                                <td>
                                    <form action="{{ route('dokumen.destroy', $dokumen->id) }}" method="POST" onsubmit="return confirm('Apakah anda yakin menghapus dokumen ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-danger btn-sm">Hapus</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-center text-muted">Belum ada dokumen</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Tombol Kembali -->
    <a href="{{ route('pendaftaran.index') }}" class="btn btn-secondary mt-3">Kembali ke Data Pendaftaran</a>
</div>
@endsection
