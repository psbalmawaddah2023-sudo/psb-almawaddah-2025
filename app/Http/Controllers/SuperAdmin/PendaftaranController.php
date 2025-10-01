<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Models\User;
use App\Models\Role;
use App\Models\Pendaftaran;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PendaftaranController extends Controller
{
    // ================= SUPERADMIN =================
    public function index()
    {
        // Ambil semua pendaftaran beserta user
        $pendaftarans = Pendaftaran::with('user')->get();
        return view('superadmin.pendaftaran.index', compact('pendaftarans'));
    }

    public function create()
    {
        $users = DB::table('users')
            ->join('roles', 'users.role_id', '=', 'roles.id')
            ->where('roles.role', 'capel')
            ->select('users.*')
            ->get();

        // Generate nomor pendaftaran otomatis
        $tahunBulan = now()->format('Ym');
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

        return view('superadmin.pendaftaran.create', compact('users', 'noPendaftaran'));
    }


    public function store(Request $request)
    {
        $data = $request->validate([
            'user_id' => 'required|exists:users,id',
            'no_pendaftaran' => 'nullable|unique:pendaftarans,no_pendaftaran',
            'tanggal_daftar' => 'required|date',
            'kelas_diinginkan' => 'required',
            'nama_lengkap' => 'required',
            'tempat_lahir' => 'required',
            'tanggal_lahir' => 'required|date',
            'alamat_lengkap' => 'required',
            'sekolah_asal' => 'required',
            'alamat_sekolah_asal' => 'required',
            'email_ortu' => 'required|email',
            'nomor_telepon' => 'required',
            'nomor_whatsapp' => 'required',
            'kip' => 'nullable|string',
            'nisn' => 'nullable|string',
            'nik' => 'nullable|string',
            'no_kk' => 'nullable|string',
            'nama_ayah' => 'nullable|string',
            'nik_ayah' => 'nullable|string',
            'pekerjaan_ayah' => 'nullable|string',
            'nama_ibu' => 'nullable|string',
            'nik_ibu' => 'nullable|string',
            'pekerjaan_ibu' => 'nullable|string',
            'penghasilan_ortu' => 'nullable|string',
            'status_pendaftaran' => 'required',
            'catatan_revisi' => 'nullable|string',
        ]);
        // === Generate Nomor Pendaftaran Otomatis ===
        $tahunBulan = now()->format('Ym'); // contoh: 202509
        $last = Pendaftaran::where('no_pendaftaran', 'like', 'REG-' . $tahunBulan . '-%')
            ->orderBy('no_pendaftaran', 'desc')
            ->first();

        if ($last) {
            $lastNumber = intval(substr($last->no_pendaftaran, -4));
            $newNumber = str_pad($lastNumber + 1, 4, '0', STR_PAD_LEFT);
        } else {
            $newNumber = '0001';
        }

        $data['no_pendaftaran'] = 'REG-' . $tahunBulan . '-' . $newNumber;

        // Simpan ke database
        Pendaftaran::create($data);

        return redirect()->route('pendaftaran.index')
            ->with('success', 'Pendaftaran berhasil ditambahkan.');
    }

    public function show($id)
    {
        $pendaftaran = Pendaftaran::with('user')->findOrFail($id);
        return view('superadmin.pendaftaran.show', compact('pendaftaran'));
    }

    public function edit($id)
    {
        $pendaftaran = Pendaftaran::findOrFail($id);

        // Ambil user untuk dropdown jika perlu
        $users = User::whereHas('role', function ($query) {
            $query->where('name', 'capel');
        })->get();

        return view('superadmin.pendaftaran.edit', compact('pendaftaran', 'users'));
    }

    public function update(Request $request, $id)
    {
        $pendaftaran = Pendaftaran::findOrFail($id);

        $data = $request->all(); // pastikan semua field ada di $fillable di model Pendaftaran
        $pendaftaran->update($data);

        return redirect()->route('pendaftaran.index')->with('success', 'Data berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $pendaftaran = Pendaftaran::findOrFail($id);
        $pendaftaran->delete();

        return redirect()->route('pendaftaran.index')
            ->with('success', 'Pendaftaran berhasil dihapus.');
    }
}
