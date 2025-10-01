<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('pendaftarans', function (Blueprint $table) {
            $table->id();
            // Relasi ke user
            $table->foreignId('user_id')->constrained()->onDelete('cascade');

            // Status Pendaftaran (relasi fleksibel ke tabel status_pendaftarans)
            $table->foreignId('status_pendaftaran_id')->nullable()->constrained()->onDelete('set null');

            // Informasi Pendaftaran
            $table->string('no_pendaftaran')->unique();
            $table->date('tanggal_daftar');
            $table->enum('kelas_diinginkan', ['Kelas 1 Biasa', 'Kelas 1 Pintas']);

            // Biodata
            $table->string('nama_lengkap');
            $table->string('tempat_lahir');
            $table->date('tanggal_lahir');
            $table->text('alamat_lengkap');

            // Sekolah Asal
            $table->string('sekolah_asal');
            $table->string('alamat_sekolah_asal');

            // Kontak
            $table->string('email_ortu')->nullable();
            $table->string('nomor_telepon')->nullable();
            $table->string('nomor_whatsapp')->nullable();

            // Identitas
            $table->string('nik')->nullable();
            $table->string('no_kk')->nullable();

            // Data Orang Tua
            $table->string('nama_ayah')->nullable();
            $table->string('nik_ayah')->nullable();
            $table->string('pekerjaan_ayah')->nullable();
            $table->string('nama_ibu')->nullable();
            $table->string('nik_ibu')->nullable();
            $table->string('pekerjaan_ibu')->nullable();
            $table->string('penghasilan_ortu')->nullable();

            //status
            $table->enum('status_pendaftaran', ['pending', 'revisi', 'diterima', 'ditolak'])->default('pending');
            $table->text('catatan_revisi')->nullable();

            // Tracking tambahan (sudah diverifikasi admin)
            $table->boolean('is_verified')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pendaftarans');
    }
};
