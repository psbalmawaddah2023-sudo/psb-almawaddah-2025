
@section('title', 'Edit Pendaftaran')

@section('content')
<h1>Edit Pendaftaran</h1>

<form action="{{ route('capel.pendaftaran.update', $pendaftaran->id) }}" method="POST" enctype="multipart/form-data">
    @csrf
    @method('PUT')

    <h3>Data Calon Peserta</h3>
    <div class="form-group">
        <label>Nama Lengkap</label>
        <input type="text" name="nama_lengkap" value="{{ old('nama_lengkap', $pendaftaran->nama_lengkap) }}" class="form-control" required>
    </div>
    <div class="form-group">
        <label>Kelas Diinginkan</label>
        <input type="text" name="kelas_diinginkan" value="{{ old('kelas_diinginkan', $pendaftaran->kelas_diinginkan) }}" class="form-control" required>
    </div>
    <div class="form-group">
        <label>Tempat Lahir</label>
        <input type="text" name="tempat_lahir" value="{{ old('tempat_lahir', $pendaftaran->tempat_lahir) }}" class="form-control">
    </div>
    <div class="form-group">
        <label>Tanggal Lahir</label>
        <input type="date" name="tanggal_lahir" value="{{ old('tanggal_lahir', $pendaftaran->tanggal_lahir) }}" class="form-control">
    </div>
    <div class="form-group">
        <label>Alamat Lengkap</label>
        <textarea name="alamat_lengkap" class="form-control">{{ old('alamat_lengkap', $pendaftaran->alamat_lengkap) }}</textarea>
    </div>
    <div class="form-group">
        <label>Sekolah Asal</label>
        <input type="text" name="sekolah_asal" value="{{ old('sekolah_asal', $pendaftaran->sekolah_asal) }}" class="form-control">
    </div>
    <div class="form-group">
        <label>Alamat Sekolah Asal</label>
        <input type="text" name="alamat_sekolah_asal" value="{{ old('alamat_sekolah_asal', $pendaftaran->alamat_sekolah_asal) }}" class="form-control">
    </div>

    <h3>Kontak & Identitas</h3>
    <div class="form-group">
        <label>Email Orang Tua</label>
        <input type="email" name="email_ortu" value="{{ old('email_ortu', $pendaftaran->email_ortu) }}" class="form-control">
    </div>
    <div class="form-group">
        <label>Nomor Telepon</label>
        <input type="text" name="nomor_telepon" value="{{ old('nomor_telepon', $pendaftaran->nomor_telepon) }}" class="form-control">
    </div>
    <div class="form-group">
        <label>Nomor Whatsapp</label>
        <input type="text" name="nomor_whatsapp" value="{{ old('nomor_whatsapp', $pendaftaran->nomor_whatsapp) }}" class="form-control">
    </div>

    <h3>Data Orang Tua</h3>
    <div class="form-group">
        <label>Nama Ayah</label>
        <input type="text" name="nama_ayah" value="{{ old('nama_ayah', $pendaftaran->nama_ayah) }}" class="form-control">
    </div>
    <div class="form-group">
        <label>NIK Ayah</label>
        <input type="text" name="nik_ayah" value="{{ old('nik_ayah', $pendaftaran->nik_ayah) }}" class="form-control">
    </div>
    <div class="form-group">
        <label>Pekerjaan Ayah</label>
        <input type="text" name="pekerjaan_ayah" value="{{ old('pekerjaan_ayah', $pendaftaran->pekerjaan_ayah) }}" class="form-control">
    </div>
    <div class="form-group">
        <label>Nama Ibu</label>
        <input type="text" name="nama_ibu" value="{{ old('nama_ibu', $pendaftaran->nama_ibu) }}" class="form-control">
    </div>
    <div class="form-group">
        <label>NIK Ibu</label>
        <input type="text" name="nik_ibu" value="{{ old('nik_ibu', $pendaftaran->nik_ibu) }}" class="form-control">
    </div>
    <div class="form-group">
        <label>Pekerjaan Ibu</label>
        <input type="text" name="pekerjaan_ibu" value="{{ old('pekerjaan_ibu', $pendaftaran->pekerjaan_ibu) }}" class="form-control">
    </div>
    <div class="form-group">
        <label>Penghasilan Orang Tua</label>
        <input type="text" name="penghasilan_ortu" value="{{ old('penghasilan_ortu', $pendaftaran->penghasilan_ortu) }}" class="form-control">
    </div>

    <h3>Dokumen (Unggah Ulang jika ingin mengganti)</h3>
    @foreach(['pas_foto','kartu_nisn','akta_kelahiran','kartu_keluarga','kartu_indonesia_pintar','bukti_transfer'] as $doc)
        <div class="form-group">
            <label>{{ ucwords(str_replace('_',' ',$doc)) }}</label>
            <input type="file" name="{{ $doc }}" class="form-control">
            @php $existing = $pendaftaran->dokumens->where('jenis_dokumen',$doc)->first(); @endphp
            @if($existing)
                <small>File saat ini: <a href="{{ asset('storage/'.$existing->path_file) }}" target="_blank">{{ $existing->nama_file_asli }}</a></small>
            @endif
        </div>
    @endforeach

    <button type="submit" class="btn btn-success mt-3">Update Pendaftaran</button>
    <a href="{{ route('capel.pendaftaran.show', $pendaftaran->id) }}" class="btn btn-secondary mt-3">Batal</a>
</form>
@endsection
