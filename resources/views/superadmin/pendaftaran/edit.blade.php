@extends('superadmin.layouts.app')

@section('content')
<div class="container">
    <h1>Edit Pendaftaran</h1>
    <form action="{{ route('pendaftaran.update', $pendaftaran->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label>No Pendaftaran</label>
            <input type="text" name="no_pendaftaran" value="{{ $pendaftaran->no_pendaftaran }}" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Nama Lengkap</label>
            <input type="text" name="nama_lengkap" value="{{ $pendaftaran->nama_lengkap }}" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Kelas Diinginkan</label>
            <select name="kelas_diinginkan" class="form-control" required>
                <option value="Kelas 1 Biasa" {{ $pendaftaran->kelas_diinginkan == 'Kelas 1 Biasa' ? 'selected' : '' }}>Kelas 1 Biasa</option>
                <option value="Kelas 1 Pintas" {{ $pendaftaran->kelas_diinginkan == 'Kelas 1 Pintas' ? 'selected' : '' }}>Kelas 1 Pintas</option>
            </select>
        </div>

        <div class="mb-3">
            <label>Tanggal Daftar</label>
            <input type="date" name="tanggal_daftar" value="{{ $pendaftaran->tanggal_daftar }}" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Tempat Lahir</label>
            <input type="text" name="tempat_lahir" value="{{ $pendaftaran->tempat_lahir }}" class="form-control">
        </div>

        <div class="mb-3">
            <label>Tanggal Lahir</label>
            <input type="date" name="tanggal_lahir" value="{{ $pendaftaran->tanggal_lahir }}" class="form-control">
        </div>

        <div class="mb-3">
            <label>Alamat Lengkap</label>
            <textarea name="alamat_lengkap" class="form-control">{{ $pendaftaran->alamat_lengkap }}</textarea>
        </div>

        <div class="mb-3">
            <label>Sekolah Asal</label>
            <input type="text" name="sekolah_asal" value="{{ $pendaftaran->sekolah_asal }}" class="form-control">
        </div>

        <div class="mb-3">
            <label>Alamat Sekolah Asal</label>
            <input type="text" name="alamat_sekolah_asal" value="{{ $pendaftaran->alamat_sekolah_asal }}" class="form-control">
        </div>

        <div class="mb-3">
            <label>Email Orang Tua</label>
            <input type="email" name="email_ortu" value="{{ $pendaftaran->email_ortu }}" class="form-control">
        </div>

        <div class="mb-3">
            <label>Nomor Telepon</label>
            <input type="text" name="nomor_telepon" value="{{ $pendaftaran->nomor_telepon }}" class="form-control">
        </div>

        <div class="mb-3">
            <label>Nomor WhatsApp</label>
            <input type="text" name="nomor_whatsapp" value="{{ $pendaftaran->nomor_whatsapp }}" class="form-control">
        </div>

        <div class="mb-3">
            <label>NISN</label>
            <input type="text" name="nisn" value="{{ $pendaftaran->nisn }}" class="form-control">
        </div>

        <div class="mb-3">
            <label>KIP</label>
            <input type="text" name="kip" value="{{ $pendaftaran->kip }}" class="form-control">
        </div>

        <div class="mb-3">
            <label>NIK</label>
            <input type="text" name="nik" value="{{ $pendaftaran->nik }}" class="form-control">
        </div>

        <div class="mb-3">
            <label>No KK</label>
            <input type="text" name="no_kk" value="{{ $pendaftaran->no_kk }}" class="form-control">
        </div>

        <div class="mb-3">
            <label>Nama Ayah</label>
            <input type="text" name="nama_ayah" value="{{ $pendaftaran->nama_ayah }}" class="form-control">
        </div>

        <div class="mb-3">
            <label>NIK Ayah</label>
            <input type="text" name="nik_ayah" value="{{ $pendaftaran->nik_ayah }}" class="form-control">
        </div>

        <div class="mb-3">
            <label>Pekerjaan Ayah</label>
            <input type="text" name="pekerjaan_ayah" value="{{ $pendaftaran->pekerjaan_ayah }}" class="form-control">
        </div>

        <div class="mb-3">
            <label>Nama Ibu</label>
            <input type="text" name="nama_ibu" value="{{ $pendaftaran->nama_ibu }}" class="form-control">
        </div>

        <div class="mb-3">
            <label>NIK Ibu</label>
            <input type="text" name="nik_ibu" value="{{ $pendaftaran->nik_ibu }}" class="form-control">
        </div>

        <div class="mb-3">
            <label>Pekerjaan Ibu</label>
            <input type="text" name="pekerjaan_ibu" value="{{ $pendaftaran->pekerjaan_ibu }}" class="form-control">
        </div>

        <div class="mb-3">
            <label>Penghasilan Orang Tua</label>
            <input type="text" name="penghasilan_ortu" value="{{ $pendaftaran->penghasilan_ortu }}" class="form-control">
        </div>

        <div class="mb-3">
            <label>Status Pendaftaran</label>
            <select name="status_pendaftaran" value="{{ $pendaftaran->status_pendaftaran}}" class="form-control" required>
                <option value="pending" {{ (isset($pendaftaran) ? $pendaftaran->status_pendaftaran : 'pending') == 'pending' ? 'selected' : '' }}>Pending</option>
                <option value="revisi" {{ (isset($pendaftaran) ? $pendaftaran->status_pendaftaran : '') == 'revisi' ? 'selected' : '' }}>Revisi</option>
                <option value="diterima" {{ (isset($pendaftaran) ? $pendaftaran->status_pendaftaran : '') == 'diterima' ? 'selected' : '' }}>Diterima</option>
                <option value="ditolak" {{ (isset($pendaftaran) ? $pendaftaran->status_pendaftaran : '') == 'ditolak' ? 'selected' : '' }}>Ditolak</option>
            </select>
        </div>
        
        <div class="mb-3">
            <label>Catatan Revisi</label>
            <textarea name="catatan_revisi" class="form-control">{{ $pendaftaran->catatan_revisi }}</textarea>
        </div>

        <button type="submit" class="btn btn-success">Simpan</button>
        <a href="{{ route('pendaftaran.index') }}" class="btn btn-secondary">Batal</a>
    </form>
</div>
@endsection
