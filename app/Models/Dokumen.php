<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Dokumen extends Model
{
    protected $fillable = [
        'pendaftaran_id',
        'jenis_dokumen',
        'nama_file_asli',
        'path_file',
        'ukuran_file',
        'mime_type',
    ];

    public function pendaftaran()
    {
        return $this->belongsTo(Pendaftaran::class);
    }
}
