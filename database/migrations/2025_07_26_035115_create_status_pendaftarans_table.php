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
    Schema::create('status_pendaftarans', function (Blueprint $table) {
    $table->id();
    $table->enum('status', ['input', 'pemeriksaan', 'revisi', 'lengkap', 'pembayaran', 'lunas'])->default('input');
    $table->string('catatan_revisi');
    $table->timestamps();
});

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('status_pendaftarans');
    }
};
