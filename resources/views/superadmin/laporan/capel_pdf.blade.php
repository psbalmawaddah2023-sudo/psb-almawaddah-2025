<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan Pendaftar Capel</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; font-size: 12px; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        table th, table td { border: 1px solid #000; padding: 5px; text-align: left; }
        table th { background-color: #f2f2f2; }
        h2, h4 { margin: 0; text-align: center; }
        .summary { margin-top: 15px; }
    </style>
</head>
<body>
    <h2>Laporan Pendaftar Capel</h2>
    <h4>Dicetak: {{ \Carbon\Carbon::now()->format('d M Y H:i') }}</h4>

    <div class="summary">
        <p><strong>Total Pendaftar:</strong> {{ $pendaftarans->count() }}</p>
    </div>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>No Pendaftaran</th>
                <th>Nama Lengkap</th>
                <th>Kelas</th>
                <th>Status</th>
                <th>Tanggal Daftar</th>
            </tr>
        </thead>
        <tbody>
            @foreach($pendaftarans as $p)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $p->no_pendaftaran }}</td>
                <td>{{ ucwords($p->nama_lengkap) }}</td>
                <td>{{ $p->kelas_diinginkan }}</td>
                <td>{{ ucfirst($p->status_pendaftaran) }}</td>
                <td>{{ \Carbon\Carbon::parse($p->tanggal_daftar)->format('d M Y') }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
