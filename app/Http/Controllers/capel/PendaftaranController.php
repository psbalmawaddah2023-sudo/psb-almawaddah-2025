<?php

namespace App\Http\Controllers\Capel;

use Carbon\Carbon;
use App\Models\Pendaftaran;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Dokumen;
use Barryvdh\DomPDF\Facade\Pdf;


use Illuminate\Support\Facades\Auth;

class PendaftaranController extends Controller
{
    // ================= Dashboard Capel =================
    public function dashboard()
    {
        $user = Auth::user();
        $pendaftaran = Pendaftaran::where('user_id', $user->id)->first();

        $pengaturan = [
            'site_title' => 'Dashboard Calon Pelajar',
        ];

        $total = Pendaftaran::count();

        return view('capel.dashboard', compact('user', 'pendaftaran', 'pengaturan', 'total'));
    }

    // ================= STEP 1: Data Awal =================
    public function step1()
    {
        $tahunBulan = Carbon::now()->format('Ym'); // contoh: 202509

        $last = Pendaftaran::where('no_pendaftaran', 'like', 'REG-' . $tahunBulan . '-%')
            ->orderBy('no_pendaftaran', 'desc')
            ->first();

        if ($last) {
            $lastNumber = intval(substr($last->no_pendaftaran, -4));
            $newNumber = str_pad($lastNumber + 1, 4, '0', STR_PAD_LEFT);
        } else {
            $newNumber = '0001';
        }

        $noPendaftaran = 'REG-' . $tahunBulan . '-' . $newNumber;
        $tanggalDaftar = now()->format('Y-m-d');

        return view('capel.pendaftaran.step1', compact('noPendaftaran', 'tanggalDaftar'));
    }

    public function storeStep1(Request $request)
    {
        $data = $request->validate([
            'no_pendaftaran'      => 'required|unique:pendaftarans,no_pendaftaran',
            'tanggal_daftar'      => 'required|date',
            'kelas_diinginkan'    => 'required',
            'nama_lengkap'        => 'required',
            'tempat_lahir'        => 'required',
            'tanggal_lahir'       => 'required|date',
            'alamat_lengkap'      => 'required',
            'sekolah_asal'        => 'required',
            'alamat_sekolah_asal' => 'required',
        ]);

        $data['user_id'] = Auth::id();

        $pendaftaran = Pendaftaran::create($data);

        return redirect()->route('capel.pendaftaran.createStep2');
    }

    // ================= STEP 2: Data Kontak =================
    public function createStep2()
    {
        $user = Auth::user();
        $pendaftaran = Pendaftaran::where('user_id', $user->id)->latest()->first();

        return view('capel.pendaftaran.step2', compact('pendaftaran'));
    }

    public function storeStep2(Request $request)
    {
        $data = $request->validate([
            'nomor_telepon'   => 'nullable|string|max:20',
            'nomor_whatsapp'  => 'nullable|string|max:20',
            'nisn'            => 'nullable|string|max:20',
            'nik'             => 'nullable|string|max:20',
            'no_kk'           => 'nullable|string|max:20',
            'kip'             => 'nullable|string|max:20',
        ]);

        $user = Auth::user();
        $pendaftaran = Pendaftaran::where('user_id', $user->id)->latest()->first();

        if ($pendaftaran) {
            $pendaftaran->update($data);
        }

        return redirect()->route('capel.pendaftaran.step3', $pendaftaran->id)
            ->with('success', 'Data Kontak & Identitas berhasil disimpan.');
    }

    // ================= STEP 3: Data Orang Tua =================
    public function step3(Pendaftaran $pendaftaran)
    {
        return view('capel.pendaftaran.step3', compact('pendaftaran'));
    }

    public function storeStep3(Request $request, Pendaftaran $pendaftaran)
    {
        $data = $request->validate([
            'email_ortu'       => 'required|email',
            'nama_ayah'        => 'nullable|string',
            'nik_ayah'         => 'nullable|string',
            'pekerjaan_ayah'   => 'nullable|string',
            'nama_ibu'         => 'nullable|string',
            'nik_ibu'          => 'nullable|string',
            'pekerjaan_ibu'    => 'nullable|string',
            'penghasilan_ortu' => 'nullable|string',
        ]);

        $pendaftaran->update($data);

        return redirect()->route('capel.pendaftaran.step4', $pendaftaran->id);
    }

    // ================= STEP 4: Upload Dokumen =================
    public function step4(Pendaftaran $pendaftaran)
    {
        // cek apakah sudah ada dokumen
        $dokumen = $pendaftaran->dokumen; // otomatis ambil relasi hasOne

        return view('capel.pendaftaran.step4', compact('pendaftaran', 'dokumen'));
    }

    public function storeStep4(Request $request, Pendaftaran $pendaftaran)
    {
        $data = $request->validate([
            'pas_foto'               => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'kartu_nisn'             => 'nullable|mimes:pdf,jpg,jpeg,png|max:2048',
            'akta_kelahiran'         => 'nullable|mimes:pdf,jpg,jpeg,png|max:2048',
            'kartu_keluarga'         => 'nullable|mimes:pdf,jpg,jpeg,png|max:2048',
            'kartu_indonesia_pintar' => 'nullable|mimes:pdf,jpg,jpeg,png|max:2048',
            'bukti_transfer'         => 'nullable|mimes:pdf,jpg,jpeg,png|max:2048',
        ]);

        foreach (['pas_foto', 'kartu_nisn', 'akta_kelahiran', 'kartu_keluarga', 'kartu_indonesia_pintar', 'bukti_transfer'] as $field) {
            if ($request->hasFile($field)) {
                $file = $request->file($field);
                $path = $file->store("dokumens/{$pendaftaran->id}", 'public');

                // simpan ke DB
                \App\Models\Dokumen::updateOrCreate(
                    [
                        'pendaftaran_id' => $pendaftaran->id,
                        'jenis_dokumen'  => $field,
                    ],
                    [
                        'nama_file_asli' => $file->getClientOriginalName(),
                        'path_file'      => $path,
                        'ukuran_file'    => $file->getSize(),
                        'mime_type'      => $file->getMimeType(),
                    ]
                );
            }
        }

        return redirect()->route('capel.pendaftaran.step5', $pendaftaran->id)
            ->with('success', 'Dokumen berhasil diunggah.');
    }

    // ================= STEP 5: Konfirmasi =================
    public function step5(Pendaftaran $pendaftaran)
    {
        $dokumen = $pendaftaran->dokumens ?? collect();

        // Ambil catatan revisi jika ada
        $catatanRevisi = $pendaftaran->catatan_revisi;

        return view('capel.pendaftaran.step5', compact('pendaftaran', 'dokumen', 'catatanRevisi'));
    }

    // Export PDF
    public function exportPdf(Pendaftaran $pendaftaran)
    {
        $dokumen = $pendaftaran->dokumen ?? collect();
        $catatanRevisi = $pendaftaran->catatan_revisi;

        // Load view PDF
        $pdf = PDF::loadView('capel.pendaftaran.step5_pdf', compact('pendaftaran', 'dokumen', 'catatanRevisi'));

        // Download PDF dengan nama file
        return $pdf->download('pendaftaran_' . $pendaftaran->no_pendaftaran . '.pdf');
    }
    public function konfirmasi($id)
    {
        $pendaftaran = Pendaftaran::findOrFail($id);

        // pastikan hanya user pemilik yg bisa konfirmasi
        if ($pendaftaran->user_id !== auth()->id()) {
            abort(403, 'Unauthorized');
        }

        // update status jadi tetap pending (biar admin yg ubah nanti)
        $pendaftaran->update([
            'status_pendaftaran' => 'pending',
        ]);

        return redirect()->route('capel.dashboard')
            ->with('success', 'Data berhasil dikonfirmasi & sudah disubmit. Menunggu verifikasi admin.');
    }

    // ================= INDEX =================
    // Menampilkan daftar semua pendaftaran user yang login
    public function index()
    {
        $user = auth()->user();
        $pendaftaran = Pendaftaran::with('dokumens')
            ->where('user_id', $user->id)
            ->latest()
            ->first(); // <== ambil 1 model saja
        $dokumen = $pendaftaran->dokumens ?? collect(); // <== tambahkan ini
        $catatanRevisi = $pendaftaran->catatan_revisi ?? 'Belum ada catatan dari admin.';

    return view('capel.index', compact('pendaftaran', 'dokumen', 'catatanRevisi'));
    }

    public function show(Pendaftaran $pendaftaran)
    {
        if ($pendaftaran->user_id !== auth()->id()) {
            abort(403, 'Unauthorized');
        }

        // Ambil dokumen
        $dokumen = $pendaftaran->dokumens ?? collect();

        // Ambil catatan revisi
        $catatanRevisi = $pendaftaran->catatan_revisi ?? 'Catatan dari admin akan muncul di sini jika ada yang perlu diubah.';

        // Pengaturan navbar
        $pengaturan = [
            'site_title' => 'Portal Pendaftaran'
        ];

        return view('capel.pendaftaran.index', compact('pendaftaran', 'dokumen', 'catatanRevisi', 'pengaturan'));
    }

    // ================= EDIT =================
    public function edit(Pendaftaran $pendaftaran)
    {
        if ($pendaftaran->user_id !== auth()->id()) {
            abort(403, 'Unauthorized');
        }

        $dokumen = $pendaftaran->dokumens;
        return view('capel.pendaftaran.edit', compact('pendaftaran', 'dokumen'));
    }

    public function updateDokumen(Request $request, Pendaftaran $pendaftaran, Dokumen $dokumen)
    {
        if ($pendaftaran->user_id !== auth()->id()) {
            abort(403, 'Unauthorized');
        }

        $request->validate([
            'file' => 'required|mimes:jpg,jpeg,png,pdf|max:2048', // bisa disesuaikan
        ]);

        // Simpan file baru
        $file = $request->file('file');
        $path = $file->store("dokumens/{$pendaftaran->id}", 'public');

        // Update record dokumen
        $dokumen->update([
            'nama_file_asli' => $file->getClientOriginalName(),
            'path_file'      => $path,
            'ukuran_file'    => $file->getSize(),
            'mime_type'      => $file->getMimeType()
        ]);

        return back()->with('success', 'Dokumen berhasil diperbarui');
    }
    public function update(Request $request, Pendaftaran $pendaftaran)
    {
        if ($pendaftaran->user_id !== auth()->id()) {
            abort(403, 'Unauthorized');
        }

        $field = $request->input('field');
        $value = $request->input('value');

        // Validasi field sesuai tipe data
        $rules = [
            'nama_lengkap' => 'required|string|max:255',
            'kelas_diinginkan' => 'required|string|max:100',
            'tempat_lahir' => 'required|string|max:255',
            'tanggal_lahir' => 'required|date',
            'alamat_lengkap' => 'required|string',
            'email_ortu' => 'required|email',
            'nomor_telepon' => 'nullable|string|max:20',
            'nomor_whatsapp' => 'nullable|string|max:20',
            'nik' => 'nullable|string|max:20',
            'no_kk' => 'nullable|string|max:20',
            'nama_ayah' => 'nullable|string|max:255',
            'nik_ayah' => 'nullable|string|max:20',
            'pekerjaan_ayah' => 'nullable|string|max:100',
            'nama_ibu' => 'nullable|string|max:255',
            'nik_ibu' => 'nullable|string|max:20',
            'pekerjaan_ibu' => 'nullable|string|max:100',
            'penghasilan_ortu' => 'nullable|string|max:100',
        ];

        if (!array_key_exists($field, $rules)) {
            return back()->with('error', 'Field tidak valid');
        }

        $request->validate([
            'value' => $rules[$field]
        ]);

        $pendaftaran->update([$field => $value]);

        return back()->with('success', 'Data berhasil diperbarui.');
    }
}
