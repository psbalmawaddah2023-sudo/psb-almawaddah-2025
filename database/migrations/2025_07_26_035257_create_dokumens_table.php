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
        Schema::create('dokumens', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pendaftaran_id')->constrained()->onDelete('cascade');
            
            // Jenis dokumen bisa divalidasi di sisi aplikasi agar fleksibel dan tidak hardcode
            $table->enum('jenis_dokumen', [
                'pas_foto',
                'kartu_nisn',
                'akta_kelahiran',
                'kartu_keluarga',
                'kartu_indonesia_pintar',
                'bukti_transfer'
            ]);
            
            $table->string('nama_file_asli')->nullable(); // Nama file original
            $table->string('path_file');                  // Lokasi file disimpan
            $table->unsignedBigInteger('ukuran_file');    // Dalam byte (maks 1 MB = 1048576)
            $table->string('mime_type');                  // Jenis MIME: image/png, application/pdf, dll
            $table->timestamps();
        });
      }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dokumens');
    }
};
