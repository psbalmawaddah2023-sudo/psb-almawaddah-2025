@extends('superadmin.layouts.app')

@section('content')
    <div class="container">
        <h1>Tambah Pendaftaran</h1>
        <form action="{{ route('pendaftaran.store') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label for="user_id">Pilih User (Capel)</label>
                <select name="user_id" id="user_id" class="form-control" required>
                    <option value="">Pilih User</option>
                    @foreach ($users as $user)
                        <option value="{{ $user->id }}" {{ old('user_id') == $user->id ? 'selected' : '' }}>
                            {{ $user->name }} ({{ $user->email }})
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="mb-3">
                <label for="no_pendaftaran" class="form-label">Nomor Pendaftaran</label>
                <input type="text" class="form-control" id="no_pendaftaran" value="{{ $noPendaftaran }}" readonly>
                <input type="hidden" name="no_pendaftaran" value="{{ $noPendaftaran }}">
                <div class="form-text">
                    Nomor pendaftaran dibuat otomatis setiap tahun ajaran baru.
                </div>
            </div>

            <div class="mb-3">
                <label>Nama Lengkap</label>
                <input type="text" name="nama_lengkap" value="{{ old('nama_lengkap') }}" class="form-control" required>
            </div>

            <div class="mb-3">
                <label>Kelas Diinginkan</label>
                <select name="kelas_diinginkan" class="form-control" required>
                    <option value="">-- Pilih Kelas --</option>
                    <option value="Kelas 1 Biasa" {{ old('kelas_diinginkan') == 'Kelas 1 Biasa' ? 'selected' : '' }}>Kelas 1
                        Biasa</option>
                    <option value="Kelas 1 Pintas" {{ old('kelas_diinginkan') == 'Kelas 1 Pintas' ? 'selected' : '' }}>Kelas
                        1 Pintas</option>
                </select>
            </div>
        <div class="mb-3">
    <label for="tanggal_daftar" class="form-label">Tanggal Daftar</label>
    <input type="date" name="tanggal_daftar" id="tanggal_daftar" class="form-control"
        value="{{ old('tanggal_daftar', $tanggalDaftar ?? now()->format('Y-m-d')) }}">
</div>


            <div class="mb-3">
                <label>Tempat Lahir</label>
                <input type="text" name="tempat_lahir" value="{{ old('tempat_lahir') }}" class="form-control">
            </div>

            <div class="mb-3">
                <label>Tanggal Lahir</label>
                <input type="date" name="tanggal_lahir" value="{{ old('tanggal_lahir') }}" class="form-control">
            </div>

            <div class="mb-3">
                <label>Alamat Lengkap</label>
                <textarea name="alamat_lengkap" class="form-control">{{ old('alamat_lengkap') }}</textarea>
            </div>

            <div class="mb-3">
                <label>Sekolah Asal</label>
                <input type="text" name="sekolah_asal" value="{{ old('sekolah_asal') }}" class="form-control">
            </div>

            <div class="mb-3">
                <label>Alamat Sekolah Asal</label>
                <input type="text" name="alamat_sekolah_asal" value="{{ old('alamat_sekolah_asal') }}"
                    class="form-control">
            </div>

            <div class="mb-3">
                <label>Email Orang Tua</label>
                <input type="email" name="email_ortu" value="{{ old('email_ortu') }}" class="form-control">
            </div>

            <div class="mb-3">
                <label>Nomor Telepon</label>
                <input type="text" name="nomor_telepon" value="{{ old('nomor_telepon') }}" class="form-control">
            </div>

            <div class="mb-3">
                <label>Nomor WhatsApp</label>
                <input type="text" name="nomor_whatsapp" value="{{ old('nomor_whatsapp') }}" class="form-control">
            </div>

            <div class="mb-3">
                <label>NISN</label>
                <input type="text" name="nisn" value="{{ old('nisn') }}" class="form-control">
            </div>

            <div class="mb-3">
                <label>KIP</label>
                <input type="text" name="kip" value="{{ old('kip') }}" class="form-control">
            </div>

            <div class="mb-3">
                <label>NIK</label>
                <input type="text" name="nik" value="{{ old('nik') }}" class="form-control">
            </div>

            <div class="mb-3">
                <label>No KK</label>
                <input type="text" name="no_kk" value="{{ old('no_kk') }}" class="form-control">
            </div>

            <div class="mb-3">
                <label>Nama Ayah</label>
                <input type="text" name="nama_ayah" value="{{ old('nama_ayah') }}" class="form-control">
            </div>

            <div class="mb-3">
                <label>NIK Ayah</label>
                <input type="text" name="nik_ayah" value="{{ old('nik_ayah') }}" class="form-control">
            </div>

            <div class="mb-3">
                <label>Pekerjaan Ayah</label>
                <input type="text" name="pekerjaan_ayah" value="{{ old('pekerjaan_ayah') }}" class="form-control">
            </div>

            <div class="mb-3">
                <label>Nama Ibu</label>
                <input type="text" name="nama_ibu" value="{{ old('nama_ibu') }}" class="form-control">
            </div>

            <div class="mb-3">
                <label>NIK Ibu</label>
                <input type="text" name="nik_ibu" value="{{ old('nik_ibu') }}" class="form-control">
            </div>

            <div class="mb-3">
                <label>Pekerjaan Ibu</label>
                <input type="text" name="pekerjaan_ibu" value="{{ old('pekerjaan_ibu') }}" class="form-control">
            </div>

            <div class="mb-3">
                <label>Penghasilan Orang Tua</label>
                <input type="text" name="penghasilan_ortu" value="{{ old('penghasilan_ortu') }}"
                    class="form-control">
            </div>

            <div class="mb-3">
                <label>Status Pendaftaran</label>
                <select name="status_pendaftaran" class="form-control" required>
                    <option value="pending" {{ old('status_pendaftaran', 'pending') == 'pending' ? 'selected' : '' }}>
                        Pending</option>
                    <option value="revisi" {{ old('status_pendaftaran') == 'revisi' ? 'selected' : '' }}>Revisi</option>
                    <option value="diterima" {{ old('status_pendaftaran') == 'diterima' ? 'selected' : '' }}>Diterima
                    </option>
                    <option value="ditolak" {{ old('status_pendaftaran') == 'ditolak' ? 'selected' : '' }}>Ditolak
                    </option>
                </select>
            </div>

            <div class="mb-3">
                <label>Catatan Revisi</label>
                <textarea name="catatan_revisi" class="form-control">{{ old('catatan_revisi') }}</textarea>
            </div>

            <button type="submit" class="btn btn-primary">Simpan</button>
            <a href="{{ route('pendaftaran.index') }}" class="btn btn-secondary">Batal</a>
        </form>
    </div>
@endsection
