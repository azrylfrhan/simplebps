<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Tabel Tim
        Schema::create('tim', function (Blueprint $table) {
            $table->id();
            $table->string('nama_tim', 100)->unique();
            $table->string('ketua_tim', 100)->nullable();
            $table->timestamps();
        });

        // Tabel Users
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('username', 50)->unique();
            $table->string('nama_lengkap', 100);
            $table->string('password');
            $table->enum('role', ['admin', 'operator']);
            $table->enum('status', ['aktif', 'wajib_ganti_password', 'nonaktif'])->default('wajib_ganti_password');
            $table->foreignId('tim_id')->nullable()->constrained('tim')->nullOnDelete();
            $table->timestamps();
        });

        // Tabel Pegawai
        Schema::create('pegawai', function (Blueprint $table) {
            $table->id();
            $table->string('nama_lengkap', 100);
            $table->string('jabatan', 100);
            $table->foreignId('tim_id')->constrained('tim')->cascadeOnDelete();
            $table->timestamps();
        });

        // Tabel Lembur
        Schema::create('lembur', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pegawai_id')->constrained('pegawai')->cascadeOnDelete();
            $table->date('tanggal');
            $table->time('jam_masuk_kantor')->nullable();
            $table->time('jam_pulang_kantor')->nullable();
            $table->time('jam_mulai')->nullable();
            $table->time('jam_selesai')->nullable();
            $table->text('maksud_lembur');
            $table->enum('status', ['pending', 'disetujui', 'ditolak'])->default('pending');
            $table->text('catatan_verifikator')->nullable();
            $table->foreignId('dibuat_oleh')->constrained('users');
            $table->timestamps();
        });

        // Tabel Hari Libur
        Schema::create('hari_libur', function (Blueprint $table) {
            $table->id();
            $table->date('tanggal')->unique();
            $table->string('keterangan');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('hari_libur');
        Schema::dropIfExists('lembur');
        Schema::dropIfExists('pegawai');
        Schema::dropIfExists('users');
        Schema::dropIfExists('tim');
    }
};
