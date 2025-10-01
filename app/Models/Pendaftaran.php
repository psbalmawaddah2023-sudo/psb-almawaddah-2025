<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pendaftaran extends Model
{
    use HasFactory;
    protected $table = 'pendaftarans'; 

    protected $fillable = [
    'user_id',
    'no_pendaftaran',
    'nama_lengkap',
    'kelas_diinginkan',
    'tanggal_daftar',
    'tempat_lahir',
    'tanggal_lahir',
    'alamat_lengkap',
    'sekolah_asal',
    'alamat_sekolah_asal',
    'email_ortu',
    'nomor_telepon',
    'nomor_whatsapp',
    'nisn',
    'kip',
    'nik',
    'no_kk',
    'nama_ayah',
    'nik_ayah',
    'pekerjaan_ayah',
    'nama_ibu',
    'nik_ibu',
    'pekerjaan_ibu',
    'penghasilan_ortu',
    'status_pendaftaran',
    'catatan_revisi'
];

    // Relasi ke user
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    //relasi ke dokumen
    public function dokumens()
{
    return $this->hasMany(Dokumen::class);
}

}
