<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\Pengaturan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PengaturanController extends Controller
{
    public function index()
    {
        $pengaturans = Pengaturan::pluck('value', 'key')->toArray();
        return view('superadmin.pengaturan.index', compact('pengaturans'));
    }

    public function edit($key)
    {
        $pengaturan = Pengaturan::where('key', $key)->firstOrFail();
        return view('superadmin.pengaturan.edit', compact('pengaturan'));
    }

    public function update(Request $request, $key)
    {
        $pengaturan = Pengaturan::where('key', $key)->firstOrFail();

        $rules = [];
        if (in_array($pengaturan->key, ['site_logo', 'brosur_file'])) {
            $rules['value'] = 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048';
        } else {
            $rules['value'] = 'nullable|string';
        }
        $request->validate($rules);

        if ($request->hasFile('value')) {
            if ($pengaturan->value && Storage::disk('public')->exists($pengaturan->value)) {
                Storage::disk('public')->delete($pengaturan->value);
            }
            $path = $request->file('value')->store('uploads', 'public');
            $pengaturan->value = $path;
        } else {
            $pengaturan->value = $request->value;
        }

        $pengaturan->save();

        return redirect()->route('pengaturan.index')->with('success', 'Pengaturan berhasil diperbarui');
    }
}
