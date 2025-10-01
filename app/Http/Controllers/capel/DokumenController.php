<?php

namespace App\Http\Controllers\Capel;

use App\Http\Controllers\Controller;
use App\Models\Dokumen;
use App\Models\Pendaftaran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class DokumenController extends Controller
{
    // Tampilkan form upload dokumen
    public function index(Pendaftaran $pendaftaran)
    {
        // Ambil dokumen yang sudah diupload user ini
        $dokumens = $pendaftaran->dokumens;

        return view('capel.pendaftaran.step4', compact('pendaftaran', 'dokumens'));
    }

    // Simpan dokumen
    public function store(Request $request, Pendaftaran $pendaftaran)
    {
        $request->validate([
            'jenis_dokumen' => 'required|in:pas_foto,kartu_nisn,akta_kelahiran,kartu_keluarga,kartu_indonesia_pintar,bukti_transfer',
            'file'          => 'required|mimes:jpg,jpeg,png,pdf|max:5000',
        ]);

        $file = $request->file('file');
        $path = $file->store('dokumen', 'public');

        $pendaftaran->dokumens()->create([
            'jenis_dokumen'   => $request->jenis_dokumen,
            'nama_file_asli'  => $file->getClientOriginalName(),
            'path_file'       => $path,
            'ukuran_file'     => $file->getSize(),
            'mime_type'       => $file->getMimeType(),
        ]);

        return back()->with('success', 'Dokumen berhasil diupload.');
    }

    // Hapus dokumen
    public function destroy(Dokumen $dokumen)
    {
        if (Storage::disk('public')->exists($dokumen->path_file)) {
            Storage::disk('public')->delete($dokumen->path_file);
        }

        $dokumen->delete();

        return back()->with('success', 'Dokumen berhasil dihapus.');
    }
}
