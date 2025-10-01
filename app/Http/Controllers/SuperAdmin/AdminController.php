<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Role;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    // Tampilkan semua admin/superadmin/capel
    public function index()
    {
        $users = User::whereIn('role_id', [1, 2, 3])->get();
        return view('superadmin.admin.index', compact('users'));
    }

    // Form tambah admin
    public function create()
    {
        $roles = Role::all();
        return view('superadmin.admin.create', compact('roles'));
    }

    // Simpan admin baru
    public function store(Request $request)
    {
        $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
            'role_id'  => 'required|exists:roles,id',
        ]);

        User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => bcrypt($request->password),
            'role_id'  => $request->role_id,
        ]);

        return redirect()->route('admin.index')->with('success', 'Admin berhasil ditambahkan');
    }

    // Form edit admin
    public function edit($id)
    {
        $admin = User::findOrFail($id);
        $roles = Role::all();
        return view('superadmin.admin.edit', compact('admin', 'roles'));
    }

    // Update data admin
    public function update(Request $request, $id)
    {
        $admin = User::findOrFail($id);

        $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|string|email|max:255|unique:users,email,' . $id,
            'password' => 'nullable|string|min:6|confirmed',
            'role_id'  => 'required|exists:roles,id',
        ]);

        $admin->name  = $request->name;
        $admin->email = $request->email;

        if ($request->filled('password')) {
            $admin->password = bcrypt($request->password);
        }

        // Hanya update role jika bukan Capel
        if ($admin->role_id != 1) {
            $admin->role_id = $request->role_id;
        }

        $admin->save();

        return redirect()->route('admin.index')->with('success', 'Admin berhasil diperbarui');
    }

    // Hapus admin
    public function destroy($id)
    {
        $admin = User::findOrFail($id);
        $admin->delete();

        return redirect()->route('admin.index')->with('success', 'Admin berhasil dihapus');
    }

    public function verify($id)
    {
        $user = User::findOrFail($id);
        if (is_null($user->email_verified_at)) {
            $user->email_verified_at = now();
            $user->save();
        }

        return redirect()->back()->with('success', 'User berhasil diverifikasi.');
    }
}
