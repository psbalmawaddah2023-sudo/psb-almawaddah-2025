<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Pendaftaran {{ $pendaftaran->no_pendaftaran }}</title>
    <style>
        body {
            font-family: sans-serif;
            font-size: 12px;
            color: #333;
        }
        h2, h3 {
            margin-bottom: 0;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        th, td {
            border: 1px solid #333;
            padding: 8px 10px;
            vertical-align: top;
        }
        th {
            background-color: #f2f2f2;
            text-align: left;
            width: 30%;   /* kolom label seragam */
            white-space: nowrap;
        }
        td {
            width: 70%;
        }
        .badge {
            display: inline-block;
            padding: 3px 6px;
            background-color: #17a2b8;
            color: white;
            border-radius: 4px;
            font-size: 11px;
        }
        .section-title {
            margin-top: 20px;
            margin-bottom: 5px;
            font-weight: bold;
        }
    </style>
</head>
<body>

    <h2>Data Pendaftaran Calon Santriwati Baru</h2>
    <h3>{{ $pendaftaran->nama_lengkap }}</h3>

    <p><strong>No Pendaftaran:</strong> {{ $pendaftaran->no_pendaftaran }}</p>
    <p><strong>Status:</strong> 
        <span class="badge">{{ ucfirst($pendaftaran->status_pendaftaran) }}</span>
    </p>

    @if($catatanRevisi)
        <p><strong>Catatan Admin:</strong> {{ $catatanRevisi }}</p>
    @endif

    <!-- Data Calon Peserta -->
    <div class="section-title">Data Calon Peserta</div>
    <table>
        <tbody>
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
        </tbody>
    </table>

    <!-- Kontak & Identitas -->
    <div class="section-title">Kontak & Identitas</div>
    <table>
        <tbody>
            <tr>
                <th>Email Orang Tua</th>
                <td>{{ $pendaftaran->email_ortu }}</td>
            </tr>
            <tr>
                <th>Nomor Telepon</th>
                <td>{{ $pendaftaran->nomor_telepon }}</td>
            </tr>
            <tr>
                <th>Nomor Whatsapp</th>
                <td>{{ $pendaftaran->nomor_whatsapp }}</td>
            </tr>
            <tr>
                <th>NIK</th>
                <td>{{ $pendaftaran->nik }}</td>
            </tr>
            <tr>
                <th>No KK</th>
                <td>{{ $pendaftaran->no_kk }}</td>
            </tr>
        </tbody>
    </table>

    <!-- Data Orang Tua -->
    <div class="section-title">Data Orang Tua</div>
    <table>
        <tbody>
            <tr>
                <th>Nama Ayah</th>
                <td>{{ $pendaftaran->nama_ayah }}</td>
            </tr>
            <tr>
                <th>NIK Ayah</th>
                <td>{{ $pendaftaran->nik_ayah }}</td>
            </tr>
            <tr>
                <th>Pekerjaan Ayah</th>
                <td>{{ $pendaftaran->pekerjaan_ayah }}</td>
            </tr>
            <tr>
                <th>Nama Ibu</th>
                <td>{{ $pendaftaran->nama_ibu }}</td>
            </tr>
            <tr>
                <th>NIK Ibu</th>
                <td>{{ $pendaftaran->nik_ibu }}</td>
            </tr>
            <tr>
                <th>Pekerjaan Ibu</th>
                <td>{{ $pendaftaran->pekerjaan_ibu }}</td>
            </tr>
            <tr>
                <th>Penghasilan Orang Tua</th>
                <td>{{ $pendaftaran->penghasilan_ortu }}</td>
            </tr>
        </tbody>
    </table>

</body>
</html>
