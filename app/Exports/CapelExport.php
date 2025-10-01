<?php

namespace App\Exports;

use App\Models\Pendaftaran;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;


class CapelExport implements FromCollection, WithHeadings
{
    public function collection()
    {
        return Pendaftaran::select(
            'no_pendaftaran',
            'nama_lengkap',
            'kelas_diinginkan',
            'tanggal_daftar',
            'status_pendaftaran'
        )->get();
    }

    public function headings(): array
    {
        return [
            'No Pendaftaran',
            'Nama Lengkap',
            'Kelas Diinginkan',
            'Tanggal Daftar',
            'Status Pendaftaran',
        ];
    }
}
