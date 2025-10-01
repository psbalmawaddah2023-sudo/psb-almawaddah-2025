<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pengaturan;

class WelcomeController extends Controller
{
    public function index()
    {
        // Ambil semua pengaturan, jadi array key => value
        $pengaturan = Pengaturan::pluck('value','key')->toArray();

        // Kirim ke view welcome
        return view('welcome', compact('pengaturan'));
    }
}
