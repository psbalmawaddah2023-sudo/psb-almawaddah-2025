
@section('title', 'Detail Pendaftaran')

@section('content')
<h1>Detail Pendaftaran</h1>

<p><strong>Catatan dari Admin:</strong> {{ $pendaftaran->catatan_revisi ?? 'Catatan dari admin akan muncul di sini jika ada yang perlu diubah.' }}</p>
<p><strong>Status Pendaftaran:</strong> {{ ucfirst($pendaftaran->status_pendaftaran) }}</p>

<h3>Data Calon Peserta</h3>
<table class="table table-bordered">
    <tr>
        <th>No Pendaftaran</th>
        <td>{{ $pendaftaran->no_pendaftaran }}</td>
    </tr>
    <tr>
        <th>Tanggal Daftar</th>
        <td>{{ $pendaftaran->tanggal_daftar }}</td>
    </tr>
    <tr>
        <th>Nama Lengkap</th>
        <td>{{ $pendaftaran->nama_lengkap }}</td>
    </tr>
    <tr>
        <th>Tempat, Tanggal Lahir</th>
        <td>{{ $pendaftaran->tempat_lahir }}, {{ $pendaftaran->tanggal_lahir }}</td>
    </tr>
    <tr>
        <th>Alamat Lengkap</th>
        <td>{{ $pendaftaran->alamat_lengkap }}</td>
    </tr>
    <tr>
        <th>Kelas Diinginkan</th>
        <td>{{ $pendaftaran->kelas_diinginkan }}</td>
    </tr>
</table>

<h3>Kontak & Identitas</h3>
<table class="table table-bordered">
    <tr><th>Email Orang Tua</th><td>{{ $pendaftaran->email_ortu }}</td></tr>
    <tr><th>Nomor Telepon</th><td>{{ $pendaftaran->nomor_telepon }}</td></tr>
    <tr><th>Nomor Whatsapp</th><td>{{ $pendaftaran->nomor_whatsapp }}</td></tr>
    <tr><th>NIK</th><td>{{ $pendaftaran->nik }}</td></tr>
    <tr><th>No KK</th><td>{{ $pendaftaran->no_kk }}</td></tr>
</table>

<h3>Data Orang Tua</h3>
<table class="table table-bordered">
    <tr><th>Nama Ayah</th><td>{{ $pendaftaran->nama_ayah }}</td></tr>
    <tr><th>NIK Ayah</th><td>{{ $pendaftaran->nik_ayah }}</td></tr>
    <tr><th>Pekerjaan Ayah</th><td>{{ $pendaftaran->pekerjaan_ayah }}</td></tr>
    <tr><th>Nama Ibu</th><td>{{ $pendaftaran->nama_ibu }}</td></tr>
    <tr><th>NIK Ibu</th><td>{{ $pendaftaran->nik_ibu }}</td></tr>
    <tr><th>Pekerjaan Ibu</th><td>{{ $pendaftaran->pekerjaan_ibu }}</td></tr>
    <tr><th>Penghasilan Orang Tua</th><td>{{ $pendaftaran->penghasilan_ortu }}</td></tr>
</table>

<h3>Dokumen yang sudah diunggah</h3>
<table class="table table-bordered">
    <thead>
        <tr>
            <th>Jenis Dokumen</th>
            <th>Nama File</th>
            <th>Aksi</th>
        </tr>
    </thead>
    <tbody>
        @foreach($dokumen as $doc)
        <tr>
            <td>{{ ucwords(str_replace('_',' ',$doc->jenis_dokumen)) }}</td>
            <td>{{ $doc->nama_file_asli }}</td>
            <td>
                <a href="{{ asset('storage/'.$doc->path_file) }}" target="_blank" class="btn btn-primary btn-sm">Lihat</a>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>

<a href="{{ route('capel.pendaftaran.index') }}" class="btn btn-secondary">Kembali</a>
<a href="{{ route('capel.pendaftaran.edit', $pendaftaran->id) }}" class="btn btn-warning">Edit Pendaftaran</a>

@endsection
