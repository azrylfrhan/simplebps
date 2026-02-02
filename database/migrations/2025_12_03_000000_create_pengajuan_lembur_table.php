<?php
// database/migrations/2025_12_03_000000_create_pengajuan_lembur_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('pengajuan_lembur', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pegawai_id')->constrained('pegawai')->cascadeOnDelete();
            $table->date('tanggal');
            $table->integer('lama_jam_taksiran'); // Estimasi jam
            $table->integer('lama_jam_disetujui')->nullable(); // Diisi Kabag
            $table->text('maksud_lembur');
            $table->enum('status', ['pending', 'disetujui', 'ditolak'])->default('pending');
            $table->text('catatan_verifikator')->nullable();
            $table->foreignId('dibuat_oleh')->constrained('users');
            $table->timestamps();
        });
    }

    public function down(): void {
        Schema::dropIfExists('pengajuan_lembur');
    }
};
