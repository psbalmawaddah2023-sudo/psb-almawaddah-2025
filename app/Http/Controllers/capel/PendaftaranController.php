<?php

namespace App\Http\Controllers\Capel;

use Carbon\Carbon;
use App\Models\Pendaftaran;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Dokumen;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage; // Digunakan untuk menghapus file lama

class PendaftaranController extends Controller
{
    // ================= Dashboard Capel =================
    public function dashboard()
    {
        $user = Auth::user();
        // Ambil pendaftaran terakhir (jika ada) untuk ditampilkan di dashboard
        $pendaftaran = Pendaftaran::where('user_id', $user->id)->latest()->first();

        $pengaturan = [
            'site_title' => 'Dashboard Calon Pelajar',
        ];

        // Contoh total data pendaftaran di sistem (mungkin lebih cocok di sisi Admin)
        $total = Pendaftaran::count(); 

        return view('capel.dashboard', compact('user', 'pendaftaran', 'pengaturan', 'total'));
    }

    // ================= INDEX (Ringkasan Pendaftaran) =================
    // Menampilkan daftar/ringkasan pendaftaran user yang login
    public function index()
    {
        $user = auth()->user();
        // Ambil pendaftaran terakhir yang dimiliki user
        $pendaftaran = Pendaftaran::with('dokumens')
            ->where('user_id', $user->id)
            ->latest()
            ->first();
        
        // Jika belum ada pendaftaran, inisialisasi kosong
        if (!$pendaftaran) {
            return view('capel.index', [
                'pendaftaran' => null, 
                'dokumen' => collect(), 
                'catatanRevisi' => 'Anda belum melakukan pendaftaran.',
            ]);
        }

        $dokumen = $pendaftaran->dokumens; // Relasi HasMany, gunakan plural 'dokumens'
        $catatanRevisi = $pendaftaran->catatan_revisi ?? 'Belum ada catatan dari admin.';

        return view('capel.index', compact('pendaftaran', 'dokumen', 'catatanRevisi'));
    }
    
    public function show(Pendaftaran $pendaftaran)
    {
        // Otorisasi: Pastikan pendaftaran milik user yang login
        if ($pendaftaran->user_id !== auth()->id()) {
            abort(403, 'Unauthorized');
        }

        // Ambil dokumen
        $dokumen = $pendaftaran->dokumens; // Pastikan relasi 'dokumens' (plural)
        $catatanRevisi = $pendaftaran->catatan_revisi ?? 'Catatan dari admin akan muncul di sini jika ada yang perlu diubah.';

        $pengaturan = [
            'site_title' => 'Detail Pendaftaran'
        ];

        return view('capel.pendaftaran.index', compact('pendaftaran', 'dokumen', 'catatanRevisi', 'pengaturan'));
    }

    // ----------------------------------------------------
    // ========== Proses Pendaftaran Multi-Step ===========
    // ----------------------------------------------------

    // ================= STEP 1: Data Awal =================
    public function step1()
    {
        // Logika pembuatan No Pendaftaran
        $tahunBulan = Carbon::now()->format('Ym'); 

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
            'no_pendaftaran'        => 'required|unique:pendaftarans,no_pendaftaran',
            'tanggal_daftar'        => 'required|date',
            'kelas_diinginkan'      => 'required|string',
            'nama_lengkap'          => 'required|string|max:255',
            'tempat_lahir'          => 'required|string|max:100',
            'tanggal_lahir'         => 'required|date',
            'alamat_lengkap'        => 'required|string',
            'sekolah_asal'          => 'required|string|max:255',
            'alamat_sekolah_asal'   => 'required|string',
        ]);

        $data['user_id'] = Auth::id();
        $data['status_pendaftaran'] = 'draft'; // Tambahkan status draft

        $pendaftaran = Pendaftaran::create($data);

        // Redirect ke Step 2 dengan membawa ID Pendaftaran
        return redirect()->route('capel.pendaftaran.createStep2', $pendaftaran->id);
    }

    // ================= STEP 2: Data Kontak & Identitas =================
    // Menggunakan Route Model Binding untuk Pendaftaran $pendaftaran
    public function createStep2(Pendaftaran $pendaftaran)
    {
        // Otorisasi: Pastikan pendaftaran milik user yang login
        if ($pendaftaran->user_id !== Auth::id()) {
            abort(403, 'Unauthorized');
        }

        return view('capel.pendaftaran.step2', compact('pendaftaran'));
    }

    public function storeStep2(Request $request, Pendaftaran $pendaftaran)
    {
        // Otorisasi
        if ($pendaftaran->user_id !== Auth::id()) {
            abort(403, 'Unauthorized');
        }
        
        // Aturan validasi yang sudah di-set nullable
        $data = $request->validate([
            'nomor_telepon'   => 'nullable|string|max:20',
            'nomor_whatsapp'  => 'nullable|string|max:20',
            'nisn'            => 'nullable|string|max:20', // Perlu pastikan NISN di DB NULLABLE
            'nik'             => 'nullable|string|max:20',
            'no_kk'           => 'nullable|string|max:20',
            'kip'             => 'nullable|string|max:20',
        ]);

        $pendaftaran->update($data);

        return redirect()->route('capel.pendaftaran.step3', $pendaftaran->id)
            ->with('success', 'Data Kontak & Identitas berhasil disimpan.');
    }

    // ================= STEP 3: Data Orang Tua =================
    public function step3(Pendaftaran $pendaftaran)
    {
        if ($pendaftaran->user_id !== Auth::id()) {
            abort(403, 'Unauthorized');
        }

        return view('capel.pendaftaran.step3', compact('pendaftaran'));
    }

    public function storeStep3(Request $request, Pendaftaran $pendaftaran)
    {
        if ($pendaftaran->user_id !== Auth::id()) {
            abort(403, 'Unauthorized');
        }

        $data = $request->validate([
            'email_ortu'       => 'required|email|max:255',
            'nama_ayah'        => 'nullable|string|max:255',
            'nik_ayah'         => 'nullable|string|max:20',
            'pekerjaan_ayah'   => 'nullable|string|max:100',
            'nama_ibu'         => 'nullable|string|max:255',
            'nik_ibu'          => 'nullable|string|max:20',
            'pekerjaan_ibu'    => 'nullable|string|max:100',
            'penghasilan_ortu' => 'nullable|string|max:100',
        ]);

        $pendaftaran->update($data);

        return redirect()->route('capel.pendaftaran.step4', $pendaftaran->id);
    }

    // ================= STEP 4: Upload Dokumen =================
    public function step4(Pendaftaran $pendaftaran)
    {
        if ($pendaftaran->user_id !== Auth::id()) {
            abort(403, 'Unauthorized');
        }
        
        // Ambil semua dokumen terkait pendaftaran ini
        $dokumens = $pendaftaran->dokumens; 

        return view('capel.pendaftaran.step4', compact('pendaftaran', 'dokumens'));
    }

    public function storeStep4(Request $request, Pendaftaran $pendaftaran)
    {
        if ($pendaftaran->user_id !== Auth::id()) {
            abort(403, 'Unauthorized');
        }

        $data = $request->validate([
            'pas_foto'                => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'kartu_nisn'              => 'nullable|mimes:pdf,jpg,jpeg,png|max:2048',
            'akta_kelahiran'          => 'nullable|mimes:pdf,jpg,jpeg,png|max:2048',
            'kartu_keluarga'          => 'nullable|mimes:pdf,jpg,jpeg,png|max:2048',
            'kartu_indonesia_pintar'  => 'nullable|mimes:pdf,jpg,jpeg,png|max:2048',
            'bukti_transfer'          => 'nullable|mimes:pdf,jpg,jpeg,png|max:2048',
        ]);

        $fields = ['pas_foto', 'kartu_nisn', 'akta_kelahiran', 'kartu_keluarga', 'kartu_indonesia_pintar', 'bukti_transfer'];

        foreach ($fields as $field) {
            if ($request->hasFile($field)) {
                $file = $request->file($field);
                
                // Cek apakah dokumen lama ada dan hapus (Opsional, jika Anda mau replace file lama)
                $dokumenLama = Dokumen::where('pendaftaran_id', $pendaftaran->id)
                                    ->where('jenis_dokumen', $field)
                                    ->first();
                
                if ($dokumenLama && Storage::disk('public')->exists($dokumenLama->path_file)) {
                    Storage::disk('public')->delete($dokumenLama->path_file);
                }

                $path = $file->store("dokumens/{$pendaftaran->id}", 'public');

                // Simpan/Update ke DB
                Dokumen::updateOrCreate(
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
            ->with('success', 'Dokumen berhasil diunggah/diperbarui.');
    }

    // ================= STEP 5: Konfirmasi & Selesai =================
    public function step5(Pendaftaran $pendaftaran)
    {
        if ($pendaftaran->user_id !== Auth::id()) {
            abort(403, 'Unauthorized');
        }

        $dokumens = $pendaftaran->dokumens; // Gunakan plural 'dokumens'
        $catatanRevisi = $pendaftaran->catatan_revisi;

        return view('capel.pendaftaran.step5', compact('pendaftaran', 'dokumens', 'catatanRevisi'));
    }

    public function konfirmasi(Pendaftaran $pendaftaran)
    {
        // Otorisasi menggunakan Route Model Binding
        if ($pendaftaran->user_id !== auth()->id()) {
            abort(403, 'Unauthorized');
        }

        // Update status menjadi 'pending' untuk diverifikasi admin
        $pendaftaran->update([
            'status_pendaftaran' => 'pending',
        ]);

        return redirect()->route('capel.dashboard')
            ->with('success', 'Data berhasil dikonfirmasi & sudah disubmit. Menunggu verifikasi admin.');
    }

    // ================= Export PDF =================
    public function exportPdf(Pendaftaran $pendaftaran)
    {
        if ($pendaftaran->user_id !== Auth::id()) {
            abort(403, 'Unauthorized');
        }

        $dokumens = $pendaftaran->dokumens; // Gunakan plural 'dokumens'
        $catatanRevisi = $pendaftaran->catatan_revisi;

        // Load view PDF
        $pdf = Pdf::loadView('capel.pendaftaran.step5_pdf', compact('pendaftaran', 'dokumens', 'catatanRevisi'));

        // Download PDF dengan nama file
        return $pdf->download('pendaftaran_' . $pendaftaran->no_pendaftaran . '.pdf');
    }

    // ----------------------------------------------------
    // ====================== Edit Data ======================
    // ----------------------------------------------------

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
        if ($pendaftaran->user_id !== auth()->id() || $dokumen->pendaftaran_id !== $pendaftaran->id) {
            abort(403, 'Unauthorized');
        }

        $request->validate([
            // Sesuaikan aturan file berdasarkan jenis dokumen (misal, foto hanya boleh image)
            'file' => 'required|mimes:jpg,jpeg,png,pdf|max:2048', 
        ]);

        // Hapus file lama dari storage
        if (Storage::disk('public')->exists($dokumen->path_file)) {
            Storage::disk('public')->delete($dokumen->path_file);
        }

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
        
        // Opsional: Atur status pendaftaran kembali ke draft/revisi jika sebelumnya sudah submitted
        if ($pendaftaran->status_pendaftaran == 'pending' || $pendaftaran->status_pendaftaran == 'revisi') {
             $pendaftaran->update(['status_pendaftaran' => 'revisi']);
        }


        return back()->with('success', 'Dokumen berhasil diperbarui');
    }
    
    // Update data pendaftaran secara inline (AJAX/edit cepat)
    public function update(Request $request, Pendaftaran $pendaftaran)
    {
        if ($pendaftaran->user_id !== auth()->id()) {
            abort(403, 'Unauthorized');
        }

        $field = $request->input('field');
        $value = $request->input('value');

        // Daftar lengkap aturan validasi
        $rules = [
            'nama_lengkap' => 'required|string|max:255',
            'kelas_diinginkan' => 'required|string|max:100',
            'tempat_lahir' => 'required|string|max:255',
            'tanggal_lahir' => 'required|date',
            'alamat_lengkap' => 'required|string',
            'email_ortu' => 'required|email|max:255',
            'nomor_telepon' => 'nullable|string|max:20',
            'nomor_whatsapp' => 'nullable|string|max:20',
            'nisn' => 'nullable|string|max:20', // Harus dipastikan NISN NULLABLE di DB
            'nik' => 'nullable|string|max:20',
            'no_kk' => 'nullable|string|max:20',
            'kip' => 'nullable|string|max:20',
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
        
        // Jalankan validasi hanya untuk field yang di-update
        $request->validate([
            'value' => $rules[$field]
        ], [
             // Custom error message
             'value.required' => 'Kolom ini wajib diisi.',
             'value.max' => 'Panjang maksimum adalah :max karakter.',
             'value.email' => 'Format harus berupa email yang valid.',
        ]);

        $pendaftaran->update([$field => $value]);

        return back()->with('success', 'Data berhasil diperbarui.');
    }
}