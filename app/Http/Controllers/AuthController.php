<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use App\Models\User;

class AuthController extends Controller
{
    // Tampilkan form register
    public function showRegisterForm()
    {
        return view('auth.register');
    }

    // Proses register
    public function register(Request $request)
    {
        $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:users',
            'password' => 'required|string|min:6|confirmed',
        ]);

        // Generate kode random 6 digit
        $code = rand(100000, 999999);

        $user = User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
            'role_id'  => 1,
            'verification_code' => $code,
        ]);

        // Kirim email verifikasi
        Mail::raw("Kode verifikasi Anda adalah: $code", function ($message) use ($user) {
            $message->to($user->email)
                ->subject('Kode Verifikasi Akun');
        });

        return redirect()->route('verify')->with('success', 'Registrasi berhasil. Silakan cek email untuk kode verifikasi.');
    }

    // Tampilkan form login
    public function showLoginForm()
    {
        return view('auth.login');
    }

    // Proses login
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email'    => 'required|email',
            'password' => 'required|string',
        ]);

        // if (Auth::attempt($credentials)) {
        //     $request->session()->regenerate();

        //     $user = Auth::user();

        //     if ($user->role_id == 3) {
        //         // Superadmin
        //         return redirect()->route('superadmin.dashboard');
        //     } elseif ($user->role_id == 2) {
        //         // Admin
        //         return redirect()->route('admin.index'); 
        //     } else {
        //         // Capel (calon pendaftar)
        //         return redirect()->route('capel.dashboard');
        //     }
        // }

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            $user = Auth::user();

            if (is_null($user->email_verified_at)) {
                Auth::logout();
                return back()->withErrors([
                    'email' => 'Akun belum diverifikasi. Silakan cek email Anda.',
                ]);
            }

            if ($user->role_id == 2) {
                return redirect()->route('superadmin.dashboard');
            } elseif ($user->role_id == 1) {
                return redirect()->route('capel.dashboard');
            }
        }


        return back()->withErrors([
            'email' => 'Email atau password salah.',
        ])->onlyInput('email');
    }


    // Logout
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        // Arahkan langsung ke URL root
        return redirect('/'); // jangan pakai route('/')
    }

    public function showVerifyForm()
    {
        return view('auth.verify');
    }

    public function verify(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'code'  => 'required',
        ]);

        $user = User::where('email', $request->email)
            ->where('verification_code', $request->code)
            ->first();

        if ($user) {
            $user->email_verified_at = now();
            $user->verification_code = null; // reset kode
            $user->save();

            return redirect()->route('login')->with('success', 'Email berhasil diverifikasi, silakan login.');
        }

        return back()->withErrors(['code' => 'Kode verifikasi salah.']);
    }

    // ================== TUTORIAL ==================
    public function tutorial()
    {
        // langsung arahkan ke view tutorial
        return view('capel.tutorWeb');
    }
}
