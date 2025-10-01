<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\Pendaftaran;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\CapelExport;
use Barryvdh\DomPDF\Facade\Pdf;

class LaporanController extends Controller
{
    public function index()
    {
        // total capel
        $total = Pendaftaran::count();

        // rekap per kelas
        $perKelas = Pendaftaran::select('kelas_diinginkan')
            ->selectRaw('COUNT(*) as jumlah')
            ->groupBy('kelas_diinginkan')
            ->get();

        // rekap per status langsung dari field tabel
        $perStatus = Pendaftaran::select('status_pendaftaran')
            ->selectRaw('COUNT(*) as jumlah')
            ->groupBy('status_pendaftaran')
            ->get();

        // ambil semua data pendaftaran
        $pendaftarans = Pendaftaran::with(['user', 'dokumens'])
            ->latest()
            ->get();

        return view('superadmin.laporan.index', compact('total','perKelas','perStatus','pendaftarans'));
    }

    // Export Excel
    public function exportExcel()
    {
        return Excel::download(new CapelExport, 'laporan_capel.xlsx');
    }

    // Export PDF
    public function exportPDF()
    {
        $pendaftarans = Pendaftaran::all();

        $pdf = PDF::loadView('superadmin.laporan.capel_pdf', compact('pendaftarans'))
                ->setPaper('a4', 'landscape'); // biar tabel lebih muat

        return $pdf->download('laporan_capel.pdf');
    }
}
