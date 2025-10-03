<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\SuperAdmin\DashboardController;
use App\Http\Controllers\SuperAdmin\PendaftaranController;
use App\Http\Controllers\SuperAdmin\AdminController;
use App\Http\Controllers\SuperAdmin\LaporanController;
use App\Http\Controllers\SuperAdmin\PengaturanController;
use App\Http\Controllers\SuperAdmin\DokumenController;
use App\Http\Controllers\WelcomeController;
use App\Http\Controllers\Capel\PendaftaranController as CapelPendaftaranController;
use Illuminate\Support\Facades\Auth;

// ================= PUBLIC AREA =================

// Dashboard umum
Route::get('/', [WelcomeController::class, 'index'])->name('welcome');

// Tutorial
Route::get('/tutorial-website', function () {
    return view('tutorWeb');
})->name('tutorial.website');

// Tutorial hanya bisa diakses setelah login
Route::middleware(['auth'])->group(function () {
    Route::get('/tutorial', [AuthController::class, 'tutorial'])->name('capel.tutorial.website');
});

//verifikasi email
Route::get('/verify', [AuthController::class, 'showVerifyForm'])->name('verify.form');
Route::post('/verify', [AuthController::class, 'verify'])->name('verify');
Route::post('/admin/{id}/verify', [AdminController::class, 'verify'])->name('admin.verify');

// Register
Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [AuthController::class, 'register']);

// Login
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);

// Logout
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');


// ================= SUPERADMIN AREA =================
Route::middleware(['auth', 'role:superadmin'])
    ->prefix('superadmin')
    ->group(function () {

        // Dashboard
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('superadmin.dashboard');

        // Pendaftaran (Capel)
        Route::resource('pendaftaran', PendaftaranController::class);

        // Admin Management
        Route::get('/admin', [AdminController::class, 'index'])->name('admin.index');
        Route::get('/admin/create', [AdminController::class, 'create'])->name('admin.create');
        Route::post('/admin', [AdminController::class, 'store'])->name('admin.store');
        Route::get('/admin/{id}/edit', [AdminController::class, 'edit'])->name('admin.edit');
        Route::put('/admin/{id}', [AdminController::class, 'update'])->name('admin.update');
        Route::delete('/admin/{id}', [AdminController::class, 'destroy'])->name('admin.destroy');

        // Laporan
        Route::prefix('laporan')->group(function () {
            Route::get('/', [LaporanController::class, 'index'])->name('laporan.index');
            Route::get('/export/excel', [LaporanController::class, 'exportExcel'])->name('laporan.capel.excel');
            Route::get('/export/pdf', [LaporanController::class, 'exportPDF'])->name('laporan.capel.pdf');
        });

        // Pengaturan
        Route::get('pengaturan', [PengaturanController::class, 'index'])->name('pengaturan.index');
        Route::get('pengaturan/{id}/edit', [PengaturanController::class, 'edit'])->name('pengaturan.edit');
        Route::put('pengaturan/{id}', [PengaturanController::class, 'update'])->name('pengaturan.update');

        // Dokumen
        Route::post('pendaftaran/{pendaftaran}/dokumen', [DokumenController::class, 'store'])
            ->name('dokumen.store');
        Route::delete('dokumen/{dokumen}', [DokumenController::class, 'destroy'])
            ->name('dokumen.destroy');
    });

// ================= CAPEL AREA =================
Route::middleware(['auth', 'role:capel'])
    ->prefix('capel')
    ->name('capel.')
    ->group(function () {
        // Dashboard capel
        Route::get('/dashboard', [CapelPendaftaranController::class, 'dashboard'])->name('dashboard');

        // Form Pendaftaran (multi-step)
        Route::prefix('pendaftaran')->name('pendaftaran.')->group(function () {
            // Step 1: Data Awal
            Route::get('/step1', [CapelPendaftaranController::class, 'step1'])->name('step1');
            Route::post('/step1', [CapelPendaftaranController::class, 'storeStep1'])->name('storeStep1');

            // Step 2: Data Kontak
            Route::get('/step2', [CapelPendaftaranController::class, 'createStep2'])->name('createStep2');
            Route::post('/step2', [CapelPendaftaranController::class, 'storeStep2'])->name('storeStep2');

            // Step 3: Data Orang Tua
            Route::get('/{pendaftaran}/step3', [CapelPendaftaranController::class, 'step3'])->name('step3');
            Route::post('/{pendaftaran}/step3', [CapelPendaftaranController::class, 'storeStep3'])->name('storeStep3');

            // Step 4: Upload Dokumen
            Route::get('/{pendaftaran}/step4', [CapelPendaftaranController::class, 'step4'])->name('step4');
            Route::post('/{pendaftaran}/step4', [CapelPendaftaranController::class, 'storeStep4'])->name('storeStep4');


            /// Step 5: Konfirmasi
            Route::get('/{pendaftaran}/step5', [CapelPendaftaranController::class, 'step5'])->name('step5');
            Route::post('/{pendaftaran}/step5', [CapelPendaftaranController::class, 'storeStep5'])->name('step5.store');

            // Export PDF
            Route::get('/{pendaftaran}/step5/export', [CapelPendaftaranController::class, 'exportPdf'])->name('step5.export');


            // Konfirmasi
            Route::post('/{id}/konfirmasi', [CapelPendaftaranController::class, 'konfirmasi'])
                ->name('konfirmasi');


            // Lihat semua pendaftaran
            Route::get('/all', [CapelPendaftaranController::class, 'index'])->name('all');

            // Detail pendaftaran
            Route::get('/all/{pendaftaran}', [CapelPendaftaranController::class, 'show'])->name('capel.pendaftaran.show');

            // Edit pendaftaran
            Route::get('/all/{pendaftaran}/edit', [CapelPendaftaranController::class, 'edit'])->name('edit');

            // Update pendaftaran
            Route::put('/all/{pendaftaran}', [CapelPendaftaranController::class, 'update'])->name('update');

            Route::put(
                '/{pendaftaran}/update-dokumen/{dokumen}',
                [CapelPendaftaranController::class, 'updateDokumen']
            )->name('updateDokumen');
        });
    });
